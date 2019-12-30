@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.restaurant.management') . ' | ' . trans('labels.backend.restaurant.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.restaurant.management') }}
        <small>{{ trans('labels.backend.restaurant.edit') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::model($restaurant, ['route' => ['admin.restaurant.update', $restaurant], 'class' => 'form-horizontal', 'id'=>'edit-restaurant-form','role' => 'form', 'method' => 'PATCH']) }}

    {{ Form::hidden('id', $restaurant->id, ['id' => 'id']) }}
    {{ Form::hidden('lat', $restaurant->lat, ['id' => 'lat']) }}
    {{ Form::hidden('lng', $restaurant->lng, ['id' => 'lng']) }}
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.restaurant.edit') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.restaurant.includes.partials.header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="form-group">
                {{ Form::label('image', trans('validation.attributes.backend.restaurant.logo'), ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    <div id="crop-avatar">
                        <div class="avatar-view avatar-view-customer custom-avatar-view" title="{{trans('labels.backend.restaurant.uploadImage')}}">
                            <input class="aspectRatio1" name="aspectRatio1" type="hidden" value='1'>
                            <input class="aspectRatio2" name="aspectRatio2" type="hidden" value='1'>
                            <input class="image_type" name="image_type" type="hidden" value='1'>
                            {{ Form::hidden('logo', null, ['id' => 'image', 'class' => 'qiniuUrl']) }}
                            <img src="{{empty($restaurant->logo) ? '../../../img/add_1_1.png' : $restaurant->logo}}" alt="Avatar">
                        </div>
                    </div>
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('name', trans('validation.attributes.backend.restaurant.name').":", ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::text('name', $restaurant->name, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.restaurant.name')]) }}
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('contact', trans('validation.attributes.backend.restaurant.contact').":", ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::text('contact', $restaurant->contact, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.restaurant.contact')]) }}
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('telephone', trans('validation.attributes.backend.restaurant.telephone').":", ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::text('telephone', $restaurant->telephone, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.restaurant.telephone')]) }}
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('city_name', trans('validation.attributes.backend.restaurant.city_name'), ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::hidden('ad_code', $restaurant->ad_code, ['id' => 'ad_code']) }}
                    {{ Form::text('city_name', $restaurant->city_name, ['class' => 'form-control', 'data-toggle'=>'city-picker', 'placeholder' => trans('validation.attributes.backend.restaurant.city_name')]) }}
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('address', trans('validation.attributes.backend.restaurant.address').":", ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::text('address', $restaurant->address, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.restaurant.address')]) }}
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('', '', ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    <button id="getLocation" class="btn btn-primary pull-right" type="button">{{trans('validation.attributes.backend.restaurant.getLocation')}}</button>
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

    @include('backend.includes.upload', ['uploadRoute' => 'admin.restaurant.uploadImage'])
@stop

@section('after-scripts')
    {{ Html::script('https://webapi.amap.com/maps?v=1.3&key=203fcb60e034eb36d73d0c2ef3485ea4') }}

    {{ Html::script('js/backend/city/city-picker.data.all.js') }}
    {{ Html::script('js/backend/city/city-picker.js') }}
    {{ Html::script('js/backend/city/script.js') }}
    {{ Html::style('css/city-picker.css') }}

    {{ Html::script('js/backend/upload/upload.js') }}
    {{ Html::style('css/backend/upload/upload.css') }}
    {{ Html::script('js/backend/plugin/cropper/cropper.js') }}
    {{ Html::style('css/backend/plugin/cropper/cropper.css') }}

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
            marker.setDraggable(true);

            AMap.plugin(['AMap.ToolBar','AMap.Scale'],function(){
                var toolBar = new AMap.ToolBar();
                var scale = new AMap.Scale();
                map.addControl(toolBar);
                map.addControl(scale);
            });

            $("#getLocation").click(function(e){
                var city_name = $('#city_name').val();
                city_name = city_name.replace(/\//g, '');

                var detail_address = city_name + $('#address').val();

                AMap.service('AMap.Geocoder',function(){//回调函数
                    //实例化Geocoder
                    geocoder = new AMap.Geocoder({
                    });
                    //TODO: 使用geocoder 对象完成相关功能

                    var detailAddress = detail_address;
                    geocoder.getLocation(detailAddress, function(status, result) {
                        if (status === 'complete' && result.info === 'OK') {
                            marker.setPosition(result.geocodes[0].location);
                            map.setCenter(marker.getPosition());
                        }else{
                            console.log(status);
                            console.log(result);
                            alert("获取经纬度失败");
                        }
                    });
                })
            });

            // Handle form submission event
            $('#edit-restaurant-form').on('submit', function(e){

                var location = marker.getPosition();
                $('#lng').val(location.getLng());
                $('#lat').val(location.getLat());

                var form = this;
                var str = JSON.stringify(table.rows().data().toArray());
                $(form).append(
                        $('<input>')
                                .attr('type', 'hidden')
                                .attr('name', 'time')
                                .val(str)
                );
            });
        });

    </script>
@stop