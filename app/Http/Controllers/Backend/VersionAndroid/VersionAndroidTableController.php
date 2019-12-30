<?php

namespace App\Http\Controllers\Backend\VersionAndroid;

use App\Repositories\Api\VersionAndroid\VersionAndroidRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class VersionAndroidTableController extends Controller
{
    /**
     * @var VersionAndroidRepository
     */
    private $versionAndroidRepo;

    /**
     * VersionAndroidController constructor.
     * @param $versionAndroidRepo
     */
    public function __construct(VersionAndroidRepository $versionAndroidRepo)
    {
        $this->versionAndroidRepo = $versionAndroidRepo;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function __invoke()
    {
        return DataTables::of($this->versionAndroidRepo->getForDataTable())
            ->addColumn('actions', function ($version) {
                return $version->action_buttons;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
