<div class="pull-right mb-10 hidden-sm hidden-xs" id="max_header">
    {{ link_to_route('admin.outerDevice.index', trans('menus.backend.outerDevice.all'), [], ['class' => 'btn btn-primary btn-xs']) }}
    {{ link_to_route('admin.outerDevice.create', trans('menus.backend.outerDevice.create'), [], ['class' => 'btn btn-success btn-xs']) }}
</div><!--pull right-->

<div class="pull-right mb-10 hidden-lg hidden-md" id="min_header">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            {{ trans('menus.backend.outerDevice.title') }} <span class="caret"></span>
        </button>

        <ul class="dropdown-menu" role="menu">
            <li>{{ link_to_route('admin.outerDevice.index', trans('menus.backend.outerDevice.all')) }}</li>
            <li>{{ link_to_route('admin.outerDevice.create', trans('menus.backend.outerDevice.create')) }}</li>
        </ul>
    </div><!--btn group-->
</div><!--pull right-->

<div class="clearfix"></div>