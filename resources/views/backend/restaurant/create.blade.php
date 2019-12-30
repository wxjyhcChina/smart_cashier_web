@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.restaurant.management') . ' | ' . trans('labels.backend.restaurant.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.restaurant.management') }}
        <small>{{ trans('labels.backend.restaurant.create') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.restaurant.store', 'class' => 'form-horizontal', 'role' => 'form', 'id'=>'store-restaurant-form', 'method' => 'post']) }}

    {{ Form::hidden('lat', null, ['id' => 'lat']) }}
    {{ Form::hidden('lng', null, ['id' => 'lng']) }}
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.restaurant.create') }}</h3>

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
                            {{ Form::hidden('image', null, ['id' => 'image', 'class' => 'qiniuUrl']) }}
                            <img src="../../img/add_1_1.png" alt="Avatar">
                        </div>
                    </div>
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('name', trans('validation.attributes.backend.restaurant.name').":", ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.restaurant.name')]) }}
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('contact', trans('validation.attributes.backend.restaurant.contact').":", ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::text('contact', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.restaurant.contact')]) }}
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('telephone', trans('validation.attributes.backend.restaurant.telephone').":", ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::text('telephone', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.restaurant.telephone')]) }}
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('city_name', trans('validation.attributes.backend.restaurant.city_name'), ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::hidden('ad_code', null, ['id' => 'ad_code']) }}
                    {{ Form::text('city_name', null, ['id' => 'city_name', 'class' => 'form-control', 'data-toggle'=>'city-picker', 'placeholder' => trans('validation.attributes.backend.restaurant.city_name')]) }}
                </div><!--col-lg-10-->
            </div><!--form control-->

            <div class="form-group">
                {{ Form::label('address', trans('validation.attributes.backend.restaurant.address').":", ['class' => 'col-lg-2 control-label']) }}

                <div class="col-lg-10">
                    {{ Form::text('address', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.restaurant.address')]) }}
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
                    <div id="container" style="width:100%;height: 400px;"></div>
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
                {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-success btn-xs']) }}
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

            AMap.plugin(['AMap.ToolBar','AMap.Scale', 'AMap.Geolocation'],function(){
                var toolBar = new AMap.ToolBar();
                var scale = new AMap.Scale();

                geolocation = new AMap.Geolocation({
                    enableHighAccuracy: true,//是否使用高精度定位，默认:true
                    timeout: 10000,          //超过10秒后停止定位，默认：无穷大
                    maximumAge: 0,           //定位结果缓存0毫秒，默认：0
                    convert: true,           //自动偏移坐标，偏移后的坐标为高德坐标，默认：true
                    showButton: true,        //显示定位按钮，默认：true
                    buttonPosition: 'LB',    //定位按钮停靠位置，默认：'LB'，左下角
                    buttonOffset: new AMap.Pixel(10, 20),//定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
                    showMarker: true,        //定位成功后在定位到的位置显示点标记，默认：true
                    showCircle: true,        //定位成功后用圆圈表示定位精度范围，默认：true
                    panToLocation: true,     //定位成功后将定位到的位置作为地图中心点，默认：true
                    zoomToAccuracy:true      //定位成功后调整地图视野范围使定位位置及精度范围视野内可见，默认：false
                });

                geolocation.getCurrentPosition();
                map.addControl(toolBar);
                map.addControl(scale);
                map.addControl(geolocation);
            });

            var marker = new AMap.Marker();

            marker.setMap(map);
            marker.setDraggable(true);

            $("#getLocation").click(function(e){
                var city_name = $('#city_name').val();
                city_name = city_name.replace(/\//g, '');

                var detail_address = city_name + $('#address').val();

                AMap.service('AMap.Geocoder',function(){//回调函数
                    //实例化Geocoder
                    geocoder = new AMap.Geocoder({
                    });

                    var detailAddress = detail_address;
                    geocoder.getLocation(detailAddress, function(status, result) {
                        if (status === 'complete' && result.info === 'OK') {
                            marker.setPosition(result.geocodes[0].location);
                            map.setCenter(marker.getPosition());
                        }else{
                            alert("获取经纬度失败");
                        }
                    });
                })
            });

            // Handle form submission event
            $('#store-restaurant-form').on('submit', function(e){

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