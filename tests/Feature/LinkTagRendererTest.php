<?php

test('link tags can be rendered', function () {
    $expected = '<link rel="stylesheet" href="https://example.com/css/main.css">';

    expect(renderLinkTags([
        [
            'rel' => 'stylesheet',
            'href' => 'https://example.com/css/main.css',
        ],
    ]))->toBe($expected);
});

test('link tags can pull rom the context', function () {
    $config = [
        [
            'rel' => 'stylesheet',
            'href' => 'https://example.com/css/main.css',
        ],
        [
            'rel' => 'stylesheet',
            'href' => '$css',
        ],
    ];
    $context = [
        'css' => 'https://example.com/css/main.min.css',
    ];

    $expected = <<<'EXP'
<link rel="stylesheet" href="https://example.com/css/main.css">
<link rel="stylesheet" href="https://example.com/css/main.min.css">
EXP;

    expect(renderLinkTags($config, $context))->toBe($expected);
});
