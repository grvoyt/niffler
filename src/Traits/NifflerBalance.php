<?php

namespace Grvoyt\Niffler\Traits;

use Grvoyt\Niffler\Events\BalanceAction;
use Grvoyt\Niffler\Models\Balance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

trait NifflerBalance
{
    public function getBalance(): float
    {
        return Balance::where('user_id', $this->id)
            ->orderBy('id', 'desc')
            ->value('total') ?? 0.0;
    }

    public function balanceList(int $page = 1, int $perPage = 10)
    {
        return Balance::where('user_id', $this->id)
            ->orderBy('id', 'desc')
            ->paginate(
                perPage: $perPage,
                page: $page
            );
    }

    public function increaseMoney(float $amount, ?string $title = null, array $context = [])
    {
        DB::beginTransaction();

        $lastBalance = Balance::where('user_id', $this->id)
            ->orderBy('id', 'desc')
            ->lockForUpdate()
            ->value('total') ?? 0.0;

        $balance = Balance::create([
            'user_id' => $this->id,
            'title'   => $title,
            'debit'   => $amount,
            'credit'  => 0,
            'total'   => $lastBalance + $amount,
            'context' => $context,
        ]);

        DB::commit();

        event(new BalanceAction($balance->id));
    }

    public function decreaseMoney(float $amount, ?string $title = null, array $context = [])
    {
        try {
            DB::beginTransaction();

            $lastBalance = Balance::where('user_id', $this->id)
                ->orderBy('id', 'desc')
                ->lockForUpdate()
                ->value('total') ?? 0.0;

            if ($lastBalance < $amount) {
                throw ValidationException::withMessages([
                    'amount' => 'Low balance'
                ]);
            }

            $balance = Balance::create([
                'user_id' => $this->id,
                'title'   => $title,
                'debit'   => 0,
                'credit'  => $amount,
                'total'   => $lastBalance - $amount,
                'context' => $context,
            ]);

            DB::commit();

            event(new BalanceAction($balance->id));
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
