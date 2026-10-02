<?php

declare(strict_types=1);

use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

// Demo data for the preview only. A real app passes Transaction::query()->latest()->paginate(5).
return static function (): array {
    $all = collect(range(1, 23))->map(fn (int $n): object => new class($n) implements UrlRoutable
    {
        public string $reference;

        public string $amount;

        public string $status;

        // Routable like a model, so route('transactions.show', $transaction) works in the example as written.
        public function __construct(public int $id)
        {
            $this->reference = 'TX-'.str_pad((string) $id, 5, '0', STR_PAD_LEFT);
            $this->amount = number_format($id * 37.5, 2);
            $this->status = $id % 5 === 0 ? 'Failed' : 'Completed';
        }

        public function getRouteKey(): mixed
        {
            return $this->id;
        }

        public function getRouteKeyName(): string
        {
            return 'id';
        }

        public function resolveRouteBinding($value, $field = null): ?self
        {
            return null;
        }

        public function resolveChildRouteBinding($childType, $value, $field): ?self
        {
            return null;
        }
    });
    $page = Paginator::resolveCurrentPage('tx_page');

    return ['transactions' => new LengthAwarePaginator($all->forPage($page, 5)->values(), $all->count(), 5, $page, [
        'path' => request()->url(),
        'pageName' => 'tx_page',
    ])];
};
