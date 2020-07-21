@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.shop.management') . ' | ' . trans('labels.backend.shop.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.shop.management') }}
        <small>{{ trans('labels.backend.shop.edit') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::model($shop, ['route' => ['admin.shop.update', $shop], 'class' => 'form-horizontal', 'id'=>'edit-department-form','role' => 'form', 'method' => 'PATCH']) }}

    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.shop.edit') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.restaurant.includes.partials.header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="form-group">
                {{ Form::label('name', trans('validation.attributes.backend.shop.name').":", ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    <p style="padding-top: 7px">{{ $shop->name }}</p>
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('default', trans('validation.attributes.backend.shop.face').":", ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10" style="margin-top: 8px">
                    {{ Form::radio('face_flag', 1) }}是
                    {{ Form::radio('face_flag', 0) }}否
                </div><!--col-lg-1-->
            </div>

        </div><!-- /.box-body -->
    </div><!--box-->

    <div class="box box-info">
        <div class="box-body">
            <div class="pull-left">
                {{ link_to_route('admin.restaurant.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
            </div><!--pull-left-->

            <div class="pull-right">
                {{ Form::submit(trans('buttons.general.crud.edit'), ['class' => 'btn btn-success btn-xs']) }}
            </div><!--pull-right-->

            <div class="clearfix"></div>
        </div><!-- /.box-body -->
    </div><!--box-->

    {{ Form::close() }}

@stop