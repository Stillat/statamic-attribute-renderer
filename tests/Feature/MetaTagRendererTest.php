<?php

test('meta tags can be rendered', function () {
    $config = [
        [
            'name' => 'description',
            'content' => 'Hello World',
        ],
    ];

    expect(renderMetaTags($config))->toBe('<meta name="description" content="Hello World">');
});

test('meta tags can pull from the context', function () {
    $config = [
        [
            'name' => 'description',
            'content' => '$description',
        ],
    ];

    $context = [
        'description' => 'Hello World',
    ];

    expect(renderMetaTags($config, $context))->toBe('<meta name="description" content="Hello World">');
});
