@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.outerDevice.management') . ' | ' . trans('labels.backend.outerDevice.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.outerDevice.management') }}
        <small>{{ trans('labels.backend.outerDevice.edit') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::model($device, ['route' => ['admin.outerDevice.update', $device], 'class' => 'form-horizontal', 'id'=>'edit-device-form','role' => 'form', 'method' => 'PATCH']) }}

    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.outerDevice.edit') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.outerDevice.includes.partials.header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="form-group">
                {{ Form::label('sources', trans('validation.attributes.backend.outerDevice.sources').":", ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::text('sources', $device->sources, ['class' => 'form-control', 'required', 'placeholder' => trans('validation.attributes.backend.outerDevice.sources')]) }}
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('type', trans('validation.attributes.backend.outerDevice.type').":", ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::text('type', $device->type, ['class' => 'form-control', 'required', 'placeholder' => trans('validation.attributes.backend.outerDevice.type')]) }}
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('url', trans('validation.attributes.backend.outerDevice.url').":", ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::text('url', $device->url, ['class' => 'form-control', '', 'placeholder' => trans('validation.attributes.backend.outerDevice.url')]) }}
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('deviceKey', trans('validation.attributes.backend.outerDevice.deviceKey').":", ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::text('deviceKey', $device->deviceKey, ['class' => 'form-control', 'required', 'placeholder' => trans('validation.attributes.backend.outerDevice.deviceKey')]) }}
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('default', trans('validation.attributes.backend.outerDevice.enabled').":", ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10" style="margin-top: 8px">
                    {{ Form::radio('enabled', 1, true) }}是
                    {{ Form::radio('enabled', 0, false) }}否
                </div><!--col-lg-1-->
            </div>
        </div><!-- /.box-body -->
    </div><!--box-->

    <div class="box box-info">
        <div class="box-body">
            <div class="pull-left">
                {{ link_to_route('admin.outerDevice.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
            </div><!--pull-left-->

            <div class="pull-right">
                {{ Form::submit(trans('buttons.general.crud.edit'), ['class' => 'btn btn-success btn-xs']) }}
            </div><!--pull-right-->

            <div class="clearfix"></div>
        </div><!-- /.box-body -->
    </div><!--box-->

    {{ Form::close() }}

@stop