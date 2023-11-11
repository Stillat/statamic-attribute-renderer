<?php

use function Stillat\StatamicAttributeRenderer\isIgnorable;

test('ignorable attributes are ignored when empty', function () {
    $config = [
        'name' => isIgnorable(null),
        'attribute_two' => 'attribute-value',
    ];

    expect(renderAttributes($config))->toBe(' attribute_two="attribute-value"');
});

test('ignorable attributes are not ignored when they have a value', function () {
    $config = [
        'name' => isIgnorable('one'),
        'attribute_two' => 'attribute-value',
    ];

    expect(renderAttributes($config))->toBe('name="one" attribute_two="attribute-value"');
});
