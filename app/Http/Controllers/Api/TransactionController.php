<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateTransactionRequest;
use App\Services\Archives\ArchiveUploadService;
use App\Services\Transactions\TransactionService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService,
        protected ArchiveUploadService $archiveUploadService
    ) {}

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->authorize('transaction.view');
        $transactions = $this->transactionService->getAll();
        return response()->json($transactions, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreUpdateTransactionRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->authorize('transaction.create');

        DB::beginTransaction();
        $archiveId = null;
        try {
            if($request->hasFile('archive')){
                $archive = $this->archiveUploadService->upload(
                    file: $request->file('archive'),
                    type: 'transactions',
                    visibility: 'public'
                );
                $archiveId = $archive?->id;
            }

            $transaction = $this->transactionService->create([
                'user_id'    => auth()->id(),
                'archive_id' => $archiveId,
                'value'      => $request->value,
                'cpf'        => $request->cpf,
                'status'     => $request->status,
            ]);

            DB::commit();

            return response()->json(['message' => 'Transação Criada com sucesso', 'data' => $transaction], 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            if (isset($archive)) $this->archiveUploadService->delete($archive);
            return response()->json(['message' => 'Erro ao criar Transação - '. $e->getMessage()], 500);
        }
    }

    /**
     * @throws AuthorizationException
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {
        $this->authorize('transaction.view');
        try {
            $transaction = $this->transactionService->findById($id);
            return response()->json([ 'transaction' => $transaction ], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => "Registro não encontrado"], 500);
        }
    }

    /**
     * @throws AuthorizationException
     */
    public function update(StoreUpdateTransactionRequest $request, int $id): \Illuminate\Http\JsonResponse{
        $this->authorize('transaction.update');
        $transaction = $this->transactionService->findById($id);
        $data = $request->only(['cpf', 'value', 'status', 'archive_id']);

        if ($request->hasFile('archive')) {
            $archive = $this->archiveUploadService->upload($request->file('archive'), 'transactions', 'public');
            $data['archive_id'] = $archive->id;
        }
        return $this->transactionService->update($transaction, $data)  ? response()->json(['message' => 'Atualizada com sucesso']) : response()->json(['message' => 'Erro ao atualizar'], 500);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $this->authorize('transaction.delete');

        $transaction = $this->transactionService->findById($id);
        $deleted = $this->transactionService->delete($transaction);

        return $deleted
            ? response()->json(['message' => 'Removida com sucesso'])
            : response()->json(['message' => 'Erro ao remover'], 500);
    }

}
