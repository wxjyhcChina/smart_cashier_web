<div class="pull-right mb-10 hidden-sm hidden-xs" id="max_header">
    {{ link_to_route('admin.versionAndroid.index', trans('menus.backend.versionAndroid.all'), [], ['class' => 'btn btn-primary btn-xs']) }}
    {{ link_to_route('admin.versionAndroid.create', trans('menus.backend.versionAndroid.create'), [], ['class' => 'btn btn-success btn-xs']) }}


</div><!--pull right-->

<div class="pull-right mb-10 hidden-lg hidden-md" id="min_header">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            {{ trans('menus.backend.versionAndroid.title') }} <span class="caret"></span>
        </button>

        <ul class="dropdown-menu" role="menu">
            <li>{{ link_to_route('admin.versionAndroid.index', trans('menus.backend.versionAndroid.all')) }}</li>
            <li>{{ link_to_route('admin.versionAndroid.create', trans('menus.backend.versionAndroid.create')) }}</li>
        </ul>
    </div><!--btn group-->
</div><!--pull right-->

<div class="clearfix"></div>
