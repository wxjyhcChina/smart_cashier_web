<?php

namespace App\Http\Controllers\Backend\VersionAndroid;

use App\Common\Qiniu;
use App\Http\Requests\Backend\VersionAndroid\ManageVersionAndroidRequest;
use App\Modules\Models\VersionAndroid\VersionAndroid;
use App\Repositories\Backend\VersionAndroid\VersionAndroidRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class VersionAndroidController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('backend.versionAndroid.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('backend.versionAndroid.create');
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \App\Exceptions\Api\ApiException
     */
    public function store(Request $request)
    {
        //
        if ($_FILES['package']['tmp_name'])
        {
            $key = Qiniu::uploadFile(config('constants.qiniu.download_bucket'), $_FILES['package']['tmp_name'], 'apk', 'jyhc-'.$request->get('version_name'));
        }
        else
        {
            return redirect()->back()->withFlashDanger(trans('alerts.backend.versionAndroid.file_missing'))->withInput();
        }

        $input = $request->all();
        $input['download_url'] = $key;
        $this->versionAndroidRepo->create($input);

        Log::info("[VersionAndroid store] store android version successfully");

        return redirect()->route('admin.versionAndroid.index')->withFlashSuccess(trans('alerts.backend.versionAndroid.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * @param VersionAndroid $versionAndroid
     * @param ManageVersionAndroidRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function destroy(VersionAndroid $versionAndroid, ManageVersionAndroidRequest $request)
    {
        //
        $this->versionAndroidRepo->delete($versionAndroid);

        return redirect()->route('admin.versionAndroid.index')->withFlashSuccess(trans('alerts.backend.androidVersion.deleted'));
    }
}
