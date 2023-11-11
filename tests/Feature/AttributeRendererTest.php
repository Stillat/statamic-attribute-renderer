<?php

use function Stillat\StatamicAttributeRenderer\attributes;
use function Stillat\StatamicAttributeRenderer\isIgnorable;

test('attributes can be rendered', function () {
    $config = [
        'author' => [
            'value' => 'John Doe',
        ],
        'name' => 'Something',
        'description' => 'Hello World',
    ];

    expect(renderAttributes($config))->toBe('author="John Doe" name="Something" description="Hello World"');
});

test('attributes can pull from the context', function () {
    $config = [
        'author' => [
            'value' => '$author',
        ],
        'name' => '$name',
        'description' => '$description',
    ];

    $context = [
        'author' => 'John Doe',
        'name' => 'Something',
        'description' => 'Hello World',
    ];

    expect(renderAttributes($config, $context))->toBe('author="John Doe" name="Something" description="Hello World"');
});

test('attributes can be rendered using the helper functions', function () {
    expect(attributes([
        'name' => '$name',
        'description' => isIgnorable('$description'),
    ], ['name' => 'John Doe']))->toBe('name="John Doe"');
});
