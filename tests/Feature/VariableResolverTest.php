<?php

use Stillat\StatamicAttributeRenderer\ValueResolver;

test('variables can be resolved', function () {
    /** @var ValueResolver $resolver */
    $resolver = app(ValueResolver::class);

    $resolver->addResolver('title', function () {
        return 'Hello, world.';
    });

    $config = [
        'name' => '$title',
    ];

    expect(renderAttributes($config))->toBe('name="Hello, world."');
});

test('variables can be escaped', function () {
    /** @var ValueResolver $resolver */
    $resolver = app(ValueResolver::class);

    $resolver->addResolver('title', function () {
        return 'Hello, world.';
    });

    $config = [
        'name' => '$$title',
    ];

    expect(renderAttributes($config))->toBe('name="$title"');
});

test('variable resolvers can access the context', function () {
    /** @var ValueResolver $resolver */
    $resolver = app(ValueResolver::class);

    $resolver->addResolver('title', function ($context) {
        return $context['title'];
    });

    $config = [
        'name' => '$title',
    ];

    expect(renderAttributes($config, [
        'title' => 'The context title',
    ]))->toBe('name="The context title"');
});
