<?php

namespace App\Services\Transactions;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TransactionService
{

    public function getAll(): Collection
    {
        return Transaction::with('archive')->orderBy('created_at')->get();
    }
    public function getAllPaginated(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Transaction::with('archive')->orderBy('created_at')->paginate();
    }

    public function create(array $data): Transaction
    {
        return DB::transaction(function () use ($data) {
            return Transaction::create([
                'user_id' => $data['user_id'],
                'archive_id' => $data['archive_id'],
                'value' => $data['value'],
                'cpf' => $data['cpf'],
                'status' => $data['status']
            ]);
        });
    }

    public function update(Transaction $transaction, array $data): Transaction {
        return DB::transaction(function () use ($transaction, $data) {
            $updateData = [
                'user_id' => auth()->id(),
                'archive_id' => $data['archive_id'],
                'value' => $data['value'],
                'cpf' => $data['cpf'],
                'status' => $data['status']
            ];
            $transaction->update($updateData);
            return $transaction;
        });
    }

    public function findById($id): Transaction
    {
        return Transaction::with( 'user', 'archive')->findOrFail($id);
    }

    public function findBy(string $field, mixed $value): Transaction
    {
        return Transaction::where($field, $value)->firstOrFail();
    }

    public function delete(Transaction $transaction): ?bool
    {
        return $transaction->delete();
    }

    public function whereDate($date)
    {
        return Transaction::whereDate('created_at', $date);
    }

    public function getInfoTransactions($date = null): array
    {
        $query = $date ? $this->whereDate($date) : Transaction::query();

        $value = (clone $query)->sum('value');
        $aproves   = (clone $query)->where('status', 'Aprovada')->count();
        $inprocess = (clone $query)->where('status', 'Em processamento')->count();
        $negative   = (clone $query)->where('status', 'Negada')->count();

        return ['value' => formatValueCurrencyBr($value), 'inProcess' => $inprocess, 'aproves' => $aproves, 'negative' => $negative];
    }

}
