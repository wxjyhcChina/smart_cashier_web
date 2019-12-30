@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.restaurant.management') . ' | ' . trans('labels.backend.restaurant.info'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.restaurant.management') }}
        <small>{{ trans('labels.backend.restaurant.info') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::model($restaurant, ['route' => ['admin.restaurant.edit', $restaurant], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'get']) }}

    {{ Form::hidden('id', $restaurant->id, ['id' => 'id']) }}
    {{ Form::hidden('lat', $restaurant->lat, ['id' => 'lat']) }}
    {{ Form::hidden('lng', $restaurant->lng, ['id' => 'lng']) }}
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.restaurant.info') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.restaurant.includes.partials.header-buttons')
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="form-group">
                    {{ Form::label('image', trans('validation.attributes.backend.restaurant.logo'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        <img height="98px" width="98px" src="{{empty($restaurant->logo) ? "../../../img/shop.png" : $restaurant->logo}}" alt="Avatar">
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('name', trans('validation.attributes.backend.restaurant.name').":", ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        <p style="padding-top: 7px">{{$restaurant->name}}</p>
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('contact', trans('validation.attributes.backend.restaurant.contact').":", ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        <p style="padding-top: 7px">{{$restaurant->contact}}</p>
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('telephone', trans('validation.attributes.backend.restaurant.telephone').":", ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        <p style="padding-top: 7px">{{$restaurant->telephone}}</p>
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('address', trans('validation.attributes.backend.restaurant.city_name').":", ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        <p style="padding-top: 7px">{{$restaurant->city_name}}</p>
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('address', trans('validation.attributes.backend.restaurant.address').":", ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        <p style="padding-top: 7px">{{$restaurant->address}}</p>
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('map_address', trans('validation.attributes.backend.restaurant.map_address').":", ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        <div id="container" style="width:100%;height: 300px;"></div>
                    </div><!--col-lg-10-->
                </div><!--form control-->

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

@section('after-scripts')
    {{ Html::script('https://webapi.amap.com/maps?v=1.3&key=203fcb60e034eb36d73d0c2ef3485ea4') }}

    <script>
        $(function() {
            var lng = $('#lng').attr("value");
            var lat = $('#lat').attr("value")
            var map = new AMap.Map('container');
            map.setZoom(14);
            map.setCenter([lng, lat]);

            var marker = new AMap.Marker({
                position: [lng, lat],
                map:map
            });

            marker.setMap(map);

            AMap.plugin(['AMap.ToolBar','AMap.Scale'],function(){
                var toolBar = new AMap.ToolBar();
                var scale = new AMap.Scale();
                map.addControl(toolBar);
                map.addControl(scale);
            })
        });

    </script>
@stop
