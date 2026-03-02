<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateTransactionRequest;
use App\Services\Archives\ArchiveUploadService;
use App\Services\Transactions\TransactionService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laracasts\Presenter\Exceptions\PresenterException;

class TransactionController extends Controller
{
    protected TransactionService $transactionService;
    protected ArchiveUploadService $archiveUploadService;
    protected string $viewPath = 'admin-painel.transactions';

    public function __construct(TransactionService $transactionService, ArchiveUploadService $archiveUploadService)
    {
        $this->transactionService = $transactionService;
        $this->archiveUploadService = $archiveUploadService;
    }

    /**
     * @throws AuthorizationException
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $this->authorize('transaction.view');

        $transactions = $this->transactionService->getAllPaginated();

        return view($this->viewPath . '.index', compact('transactions'));
    }

    /**
     * @throws AuthorizationException
     */
    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $this->authorize('transaction.create');

        return view($this->viewPath . '.create');
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreUpdateTransactionRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('transaction.create');

        DB::beginTransaction();

        try {
            $archive = $this->archiveUploadService->upload(
                file: $request->file('archive'),
                type: 'transactions',
                visibility: 'public'
            );

            $this->transactionService->create([
                'user_id' => auth()->id(),
                'archive_id' => $archive->id,
                'value' => $request->value,
                'cpf' => $request->cpf,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()
                ->route('transactions.index')
                ->with('success', 'Transacao criada com sucesso.');
        } catch (\Throwable $e) {
            DB::rollBack();

            if (isset($archive)) {
                $this->archiveUploadService->delete($archive);
            }

            return back()->with('error', 'Erro ao criar transacao.');
        }
    }

    /**
     * @throws AuthorizationException|PresenterException
     */
    public function show(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->authorize('transaction.view');

        $transaction = $this->transactionService->findById($request->id);
        $archiveUrl = null;
        $archiveOriginalName = null;

        if ($transaction->archive) {
            $archiveUrl = Storage::disk($transaction->archive->disk ?? 'public')->url($transaction->archive->path);
            $archiveOriginalName = $transaction->archive->original_name ?? null;
        }

        return response()->json([
            'id' => $transaction->id,
            'user_name' => $transaction->user->name . ' - ' . $transaction->user->email,
            'user_id' => $transaction->user_id,
            'cpf' => $transaction->cpf,
            'cpf_formatted' => $transaction->cpf,
            'value' => (float) $transaction->value,
            'value_formatted' => 'R$ ' . number_format((float) $transaction->value, 2, ',', '.'),
            'status' => $transaction->status,
            'created_at' => $transaction->present()->createdFormatDateTime,
            'status_class' => $transaction->present()->getStatus,
            'archive' => $transaction->archive ? [
                'id' => $transaction->archive->id,
                'original_name' => $archiveOriginalName,
                'path' => $transaction->archive->path,
                'disk' => $transaction->archive->disk ?? 'public',
            ] : null,
            'archive_url' => $archiveUrl,
            'archive_original_name' => $archiveOriginalName,
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(string $id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $this->authorize('transaction.update');

        $transaction = $this->transactionService->findById($id);

        return view($this->viewPath . '.edit', compact('transaction'));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(StoreUpdateTransactionRequest $request, string $id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('transaction.update');

        $transaction = $this->transactionService->findById($id);
        $data = $request->all();

        if ($request->hasFile('archive')) {
            $archive = $this->archiveUploadService->upload($request->file('archive'), 'transaction', 'public');
            $data['archive_id'] = $archive->id;
        }

        $updated = $this->transactionService->update($transaction, $data);

        if ($updated) {
            return redirect()
                ->route('transactions.index')
                ->with('success', 'Transacao atualizada com sucesso.');
        }

        return redirect()->back()->with('error', 'Erro ao atualizar transacao.');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(string $id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('transaction.delete');

        $transaction = $this->transactionService->findById($id);
        $deleted = $this->transactionService->delete($transaction);

        if ($deleted) {
            return redirect()
                ->route('transactions.index')
                ->with('success', 'Transacao removida com sucesso.');
        }

        return redirect()->back()->with('error', 'Erro ao remover transacao.');
    }
}