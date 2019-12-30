@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.versionAndroid.management'))

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
@endsection

@section('page-header')
    <h1>
        {{ trans('labels.backend.versionAndroid.management') }}
        <small>{{ trans('labels.backend.versionAndroid.active') }}</small>
    </h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.versionAndroid.active') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.versionAndroid.includes.partials.header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">

            <div class="table-responsive">
                <table id="version-table" class="table table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.versionAndroid.table.id') }}</th>
                            <th>{{ trans('labels.backend.versionAndroid.table.forced') }}</th>
                            <th>{{ trans('labels.backend.versionAndroid.table.version_name') }}</th>
                            <th>{{ trans('labels.backend.versionAndroid.table.version_code') }}</th>
                            <th>{{ trans('labels.backend.versionAndroid.table.update_info') }}</th>
                            <th>{{ trans('labels.backend.versionAndroid.table.download_url') }}</th>
                            <th>{{ trans('labels.backend.versionAndroid.table.created_at') }}</th>
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
            $('#version-table').DataTable({
                dom: 'lfrtip',
                pagingType: "page_select_with_ellipses",
                processing: false,
                serverSide: true,
                autoWidth: false,
                stateSave: true,
                ajax: {
                    url: '{{ route("admin.versionAndroid.get") }}',
                    type: 'get',
                    error: function (xhr, err) {
                        if (err === 'parsererror')
                            location.reload();
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'forced', name:'forced', render: function (data, type, row, meta) {
                        if (data == true)
                        {
                            return '{{trans('labels.backend.versionAndroid.yes')}}';
                        }
                        else
                        {
                            return '{{trans('labels.backend.versionAndroid.no')}}';
                        }
                    }},
                    {data: 'version_name', name: 'version_name'},
                    {data: 'version_code', name: 'version_code'},
                    {data: 'update_info', name: 'update_info'},
                    {data: 'download_url', name: 'download_url'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'actions', name: 'actions', orderable: false, 'searchable':false}
                ],
                order: [[3, "desc"]],
                searchDelay: 500
            });
        });
    </script>
@stop