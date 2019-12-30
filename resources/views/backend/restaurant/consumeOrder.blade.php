@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.restaurant.management'))

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
    {{ Html::style("css/backend/plugin/datepicker/daterangepicker.css") }}
@endsection

@section('page-header')
    <h1>
        {{ trans('labels.backend.restaurant.management') }}
        <small>{{ trans('labels.backend.restaurant.consumeOrder') }}</small>
    </h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.restaurant.consumeOrder') }}</h3>
        </div><!-- /.box-header -->

        <div class="box-body">
            {{ Form::open(['route' => ['admin.restaurant.consumeOrderExport', $restaurant], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) }}

                <div class="row">
                    {{ Form::label('search_time', trans('labels.backend.restaurant.searchTime'), ['class' => 'control-label', 'style'=>'float: left;padding-left: 35px;padding-right: 15px;']) }}

                    <div class="col-lg-4">
                        {{ Form::text('search_time', null, ['class' => 'form-control', 'id'=>'search_time', 'placeholder' => trans('labels.backend.restaurant.searchTime')]) }}
                    </div><!--col-lg-10-->

                    <button type="button" class="btn btn-primary" id="search_btn">{{trans('labels.backend.restaurant.searchTime')}}</button>
                    <button class="btn btn-primary" id="export_btn">{{trans('labels.backend.restaurant.export')}}</button>
                </div>
            </form>

            <div class="row" style="margin-top: 20px">

            </div>
        </div>
    </div>

    <div class="box box-success">
        <div class="box-body">
            <div class="table-responsive">
                <table id="statistics-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>{{ trans('labels.backend.restaurant.consume_order_table.id') }}</th>
                        <th>{{ trans('labels.backend.restaurant.consume_order_table.dinningTime') }}</th>
                        <th>{{ trans('labels.backend.restaurant.consume_order_table.cash') }}</th>
                        <th>{{ trans('labels.backend.restaurant.consume_order_table.cash_count') }}</th>
                        <th>{{ trans('labels.backend.restaurant.consume_order_table.card') }}</th>
                        <th>{{ trans('labels.backend.restaurant.consume_order_table.card_count') }}</th>
                        <th>{{ trans('labels.backend.restaurant.consume_order_table.alipay') }}</th>
                        <th>{{ trans('labels.backend.restaurant.consume_order_table.alipay_count') }}</th>
                        <th>{{ trans('labels.backend.restaurant.consume_order_table.wechat') }}</th>
                        <th>{{ trans('labels.backend.restaurant.consume_order_table.wechat_count') }}</th>
                        <th>{{ trans('labels.backend.restaurant.consume_order_table.total') }}</th>
                        <th>{{ trans('labels.backend.restaurant.consume_order_table.total_count') }}</th>
                    </tr>
                    </thead>

                    <tbody id="statistics_container">

                    </tbody>
                </table>
            </div><!--table-responsive-->
        </div>
    </div>

    <div class="box box-success">

        <div class="box-body">
            <div class="table-responsive">
                <table id="consume-order-table" class="table table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.consumeOrder.table.id') }}</th>
{{--                            <th>{{ trans('labels.backend.consumeOrder.table.order_id') }}</th>--}}
                            <th>{{ trans('labels.backend.consumeOrder.table.customer') }}</th>
                            <th>{{ trans('labels.backend.consumeOrder.table.card_id') }}</th>
                            <th>{{ trans('labels.backend.consumeOrder.table.price') }}</th>
                            <th>{{ trans('labels.backend.consumeOrder.table.consume_category') }}</th>
                            <th>{{ trans('labels.backend.consumeOrder.table.pay_method') }}</th>
                            <th>{{ trans('labels.backend.consumeOrder.table.dinning_time') }}</th>
                            <th>{{ trans('labels.backend.consumeOrder.table.created_at') }}</th>
                            <th>{{ trans('labels.backend.consumeOrder.table.restaurant_user_id') }}</th>
                            <th>{{ trans('labels.backend.consumeOrder.table.status') }}</th>
                        </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->
@stop

@section('after-scripts')
    {{ Html::style('css/backend/ionicons/css/ionicons.min.css') }}
    {{ Html::script("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.js") }}
    {{ Html::script("js/backend/plugin/datatables/dataTables-extend.js") }}
    {{ Html::script("js/backend/plugin/datatables/dataTables_locale.js") }}
    {{ Html::script("js/backend/plugin/datatables/page_select_with_ellipses.js") }}

    {{ Html::script("js/backend/plugin/moment/moment.js") }}
    {{ Html::script("js/backend/plugin/moment/locale/zh-cn.js") }}
    {{ Html::script("js/backend/plugin/daterangepicker/daterangepicker.js") }}

    <script>
        $(function() {
            var startDate = '{{$startTime}}';
            var endDate = '{{$endTime}}';

            var table = $('#consume-order-table').DataTable({
                dom: 'lfrtip',
                pagingType: "page_select_with_ellipses",
                processing: false,
                serverSide: true,
                autoWidth: false,
                stateSave: true,
                ajax: {
                    url: '{{ route("admin.restaurant.getConsumeOrder", $restaurant) }}',
                    data: function ( d ) {
                        d.start_time = startDate;
                        d.end_time = endDate;
                        d.restaurant_user_id = $('#restaurant_user_id').val();
                    },
                    type: 'get',
                    error: function (xhr, err) {
                        if (err === 'parsererror')
                            location.reload();
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    // {data: 'order_id', name: 'order_id'},
                    {data: 'customer_name', name: 'customers.user_name'},
                    {data: 'card_number', name: 'cards.number'},
                    {data: 'discount_price', name: 'discount_price'},
                    {data: 'consume_category_name', name: 'consume_categories.name'},
                    {data: 'show_pay_method', name: 'pay_method'},
                    {data: 'dinning_time_name', name: 'dinning_time.name'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'restaurant_user_name', name: 'restaurant_users.username'},
                    {data: 'show_status', name: 'status'},
                    {data: 'restaurant_last_name', name: 'restaurant_users.last_name', visible:false},
                    {data: 'restaurant_first_name', name: 'restaurant_users.first_name', visible:false},
                ],
                order: [[0, "asc"]],
                searchDelay: 500
            });

            $('#search_time').daterangepicker(
                {
                    "timePicker": true,
                    "timePicker24Hour": true,
                    "timePickerSeconds": true,
                    "startDate": startDate,
                    "endDate": endDate,
                    "locale": {
                        format: 'YYYY-MM-DD HH:mm:ss'
                    },
                },

                function(start, end) {
                    console.log("Callback has been called!");
                    startDate = start.format('YYYY-MM-DD HH:mm:ss');
                    endDate = end.format('YYYY-MM-DD HH:mm:ss');
                }
            );

            getSearchResult();

            $('#search_btn').click(function(e){
                table.ajax.reload();
                getSearchResult();
            });

            function getSearchResult() {
                $.ajax({
                    type: "GET",
                    url: '{{ route("admin.restaurant.getConsumeOrderStatistics", $restaurant) }}',
                    data: {
                        start_time: startDate,
                        end_time: endDate,
                        restaurant_user_id: $('#restaurant_user_id').val()
                    },
                    dataType: "json",
                    success: function (items) {
                        console.log(items);
                        $('#statistics_container').empty();

                        items.forEach(function (e) {
                            $('#statistics_container').append('<tr>' +
                                '<td>' + e.id + '</td>' +
                                '<td>' + e.name + '</td>' +
                                '<td>' + e.cash + '</td>' +
                                '<td>' + e.cash_count  + '</td>' +
                                '<td>' + e.card + '</td>' +
                                '<td>' + e.card_count  + '</td>' +
                                '<td>' + e.alipay + '</td>' +
                                '<td>' + e.alipay_count  + '</td>' +
                                '<td>' + e.wechat + '</td>' +
                                '<td>' + e.wechat_count  + '</td>' +
                                '<td>' + e.total + '</td>' +
                                '<td>' + e.total_count + '</td>' +
                                '</tr>')
                        })
                    },
                    fail: function () {
                    }
                });
            }
        });
    </script>
@stop