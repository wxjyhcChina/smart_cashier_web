@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.versionAndroid.management') . ' | ' . trans('labels.backend.versionAndroid.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.versionAndroid.management') }}
        <small>{{ trans('labels.backend.versionAndroid.create') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.versionAndroid.store', 'class' => 'form-horizontal', 'role' => 'form', 'id'=>'store-version-form', 'method' => 'post', 'enctype'=>"multipart/form-data"]) }}

    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.versionAndroid.create') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.versionAndroid.includes.partials.header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">

            <div class="form-group">
                {{ Form::label('package', trans('validation.attributes.backend.versionAndroid.package').":", ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    <input id='package' name='package' type="file" style="padding-top: 7px" accept=".apk">
                </div>
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('forced', trans('validation.attributes.backend.versionAndroid.forced').":", ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10" style="margin-top: 8px">
                    {{ Form::checkbox('forced', null, false, ['id' => 'forced_checkbox']) }}
                </div><!--col-lg-1-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('version_name', trans('validation.attributes.backend.versionAndroid.version_name').":", ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::text('version_name', null, ['class' => 'form-control', 'required', 'placeholder' => trans('validation.attributes.backend.versionAndroid.version_name')]) }}
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('version_code', trans('validation.attributes.backend.versionAndroid.version_code').":", ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::text('version_code', null, ['class' => 'form-control', 'required', 'placeholder' => trans('validation.attributes.backend.versionAndroid.version_code')]) }}
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('update_info', trans('validation.attributes.backend.versionAndroid.update_info').":", ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{Form::textArea('update_info', null, ['class'=>'form-control', 'style'=>'height:200px;resize:none;']) }}
                </div><!--col-lg-10-->
            </div><!--form control-->

        </div><!-- /.box-body -->
    </div><!--box-->

    <div class="box box-info">
        <div class="box-body">
            <div class="pull-left">
                {{ link_to_route('admin.versionAndroid.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
            </div><!--pull-left-->

            <div class="pull-right">
                {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-success btn-xs']) }}
            </div><!--pull-right-->

            <div class="clearfix"></div>
        </div><!-- /.box-body -->
    </div><!--box-->

    {{ Form::close() }}
@stop