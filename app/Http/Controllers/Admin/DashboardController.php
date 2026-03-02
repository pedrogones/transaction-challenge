<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Archives\ArchiveUploadService;
use App\Services\Transactions\TransactionService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct(protected TransactionService $transactionService)
    { }

    /**
     * @throws AuthorizationException
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $this->authorize('dashboard.view');
       $total = $this->transactionService->getInfoTransactions();
       $today = $this->transactionService->getInfoTransactions(now());

        return view('admin-painel.dashboard.index', compact('total', 'today'));
    }
}
