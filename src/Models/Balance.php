<?php

namespace Grvoyt\Niffler\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'debit',
        'credit',
        'total',
        'context',
    ];

    protected $casts = [
        'debit' => 'float',
        'credit' => 'float',
        'total' => 'float',
        'context' => 'collection',
        'title' => 'string',
    ];

    protected $hidden = [
        'context',
        'total',
    ];
}
