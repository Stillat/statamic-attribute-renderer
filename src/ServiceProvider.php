<?php

namespace Stillat\StatamicAttributeRenderer;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    public function register()
    {
        $this->app->singleton(ValueResolver::class, function () {
            return new ValueResolver();
        });
    }
}
