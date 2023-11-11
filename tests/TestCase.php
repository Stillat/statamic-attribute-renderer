<?php

namespace Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Statamic\Extend\Manifest;
use Stillat\StatamicAttributeRenderer\ServiceProvider;
use Stillat\StatamicAttributeRenderer\ValueResolver;

abstract class TestCase extends BaseTestCase
{
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app->make(Manifest::class)->manifest = [
            'stillat/statamic-attribute-renderer' => [
                'id' => 'stillat/statamic-attribute-renderer',
                'namespace' => 'Stillat\\StatamicAttributeRenderer',
            ],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        /** @var ValueResolver $valueResolver */
        $valueResolver = $this->app->make(ValueResolver::class);
        $valueResolver->clearAll();
    }

    protected function getPackageProviders($app)
    {
        return [
            \Statamic\Providers\StatamicServiceProvider::class,
            \Rebing\GraphQL\GraphQLServiceProvider::class,
            \Wilderborn\Partyline\ServiceProvider::class,
            \Archetype\ServiceProvider::class,
            ServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Statamic' => 'Statamic\Statamic',
        ];
    }
}
