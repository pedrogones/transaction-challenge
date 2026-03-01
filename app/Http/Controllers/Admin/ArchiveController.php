<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Archives\ArchivesService;
use App\Services\Archives\ArchiveUploadService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    protected ArchivesService $archivesService;
    protected string $viewPath = 'admin-painel.archives';
    public function __construct(ArchivesService $archivesService)
    {
        $this->archivesService = $archivesService;
    }

    /**
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
//        $this->authorize('archive.view');
        $archives = $this->archivesService->all();
        return view($this->viewPath.'.index', compact('archives'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
}
