<?php

Breadcrumbs::register('admin.dashboard', function ($breadcrumbs) {
    $breadcrumbs->push('指示板', route('admin.dashboard'));
});

require __DIR__.'/Search.php';
require __DIR__.'/Access.php';
require __DIR__.'/LogViewer.php';