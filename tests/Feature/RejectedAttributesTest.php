<?php

use function Stillat\StatamicAttributeRenderer\rejectsOnEmpty;

test('reject attributes do not render any attributes when empty', function () {
    $config = [
        'name' => rejectsOnEmpty(null),
        'attribute_two' => 'attribute-value',
    ];

    expect(renderAttributes($config))->toBe('');
});

test('reject attributes render attributes when not empty', function () {
    $config = [
        'name' => rejectsOnEmpty('one'),
        'attribute_two' => 'attribute-value',
    ];

    expect(renderAttributes($config))->toBe('name="one" attribute_two="attribute-value"');
});
