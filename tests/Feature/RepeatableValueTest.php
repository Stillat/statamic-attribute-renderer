<?php

use function Stillat\StatamicAttributeRenderer\isRepeatable;

test('repeatable values repeat tag template for each value', function () {
    $config = [
        [
            'name' => 'description',
            'content' => [
                'value' => isRepeatable([
                    'Hello World',
                    'Hello Universe',
                    'Hello Galaxy',
                ]),
            ],
        ],
    ];

    expect(renderMetaTags($config))->toBe('<meta name="description" content="Hello World"><meta name="description" content="Hello Universe"><meta name="description" content="Hello Galaxy">');
});
