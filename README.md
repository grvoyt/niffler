# Niffler Balance

## Подключение

```php
use Grvoyt\Niffler\Traits\NifflerBalance;

class User extends Authenticatable
{
    use NifflerBalance;
}
```

## Использование

### Получить баланc

```php
$user = User::find(1);
$balance = $user->getBalance();
```

### Получить список

```php
$user = User::find(1);
$balances = $user->balanceList(int $page = 1, int $perPage = 10);
```

### Пополнить баланс

```php
$user = User::find(1);
$balances = $user->increaseMoney(float $amount, ?string $title = null, array $context = []);
```
`$amount` - сумма \
`$title` - Тут можно указать статью дохода текстом. \
`$context` - Тут массив даннх для контекста операции

### Получить список

```php
$user = User::find(1);
$balances = $user->decreaseMoney(float $amount, ?string $title = null, array $context = [])
```
`$amount` - сумма \
`$title` - Тут можно указать статью дохода текстом. \
`$context` - Тут массив даннх для контекста операции
