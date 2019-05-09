<?php

namespace Encore\Selecty;

use Encore\Admin\Admin;
use Encore\Admin\Form;
use Illuminate\Support\ServiceProvider;

class SelectyServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(SelectyExtension $extension)
    {
        if (! SelectyExtension::boot()) {
            return ;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'laravel-admin-selecty');
        }

        Admin::booting(function () {
            Form::extend('selecty', Selecty::class);

            if ($alias = SelectyExtension::config('alias')) {
                Form::alias('selecty', $alias);
            }
        });
    }
}