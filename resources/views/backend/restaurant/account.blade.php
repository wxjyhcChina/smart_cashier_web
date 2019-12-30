@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.restaurant.management'))

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
@endsection

@section('page-header')
    <h1>
        {{ trans('labels.backend.restaurant.management') }}
        <small>{{ $restaurant->name.trans('labels.backend.restaurant.account') }}</small>
    </h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $restaurant->name.trans('labels.backend.restaurant.account') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.restaurant.includes.partials.header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="users-table" class="table table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.restaurant.account_table.username') }}</th>
                            <th>{{ trans('labels.backend.restaurant.account_table.first_name') }}</th>
                            <th>{{ trans('labels.backend.restaurant.account_table.last_name') }}</th>
                            <th>{{ trans('labels.backend.restaurant.account_table.roles') }}</th>
                            <th>{{ trans('labels.backend.restaurant.account_table.created') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->
@stop

@section('after-scripts')
    {{ Html::script("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.js") }}
    {{ Html::script("js/backend/plugin/datatables/page_select_with_ellipses.js") }}
    {{ Html::script("js/backend/plugin/datatables/dataTables-extend.js") }}
    {{ Html::script("js/backend/plugin/datatables/dataTables_locale.js") }}

    <script>
        $(function() {
            $('#users-table').DataTable({
                dom: 'lfrtip',
                pagingType: "page_select_with_ellipses",
                processing: false,
                serverSide: true,
                autoWidth: false,
                stateSave: true,
                ajax: {
                    url: '{{ route("admin.restaurant.getAccounts", $restaurant->id) }}',
                    type: 'get',
                    error: function (xhr, err) {
                        if (err === 'parsererror')
                            location.reload();
                    }
                },
                columns: [
                    {data: 'username', name: 'username'},
                    {data: 'first_name', name: 'last_name', defaultContent:''},
                    {data: 'last_name', name: 'last_name', defaultContent:''},
                    {data: 'roles', name: 'roles', defaultContent:''},
                    {data: 'created_at', name: 'created_at', defaultContent:''},
                    {data: 'actions', name: 'actions', orderable: false, 'searchable':false}
                ],
                order: [[0, "asc"]],
                searchDelay: 500
            });
        });
    </script>
@stop