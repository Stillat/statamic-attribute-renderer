<?php

use Stillat\StatamicAttributeRenderer\AttributeDetails;
use Stillat\StatamicAttributeRenderer\Contracts\ClassBasedValueResolver;

use function Stillat\StatamicAttributeRenderer\usesClass;

class SimpleResolver implements ClassBasedValueResolver
{
    public function getValue(array $context, AttributeDetails $attributesDetails): mixed
    {
        if (array_key_exists('title', $context)) {
            return $context['title'];
        }

        if (array_key_exists('ignore', $context)) {
            return null;
        }

        return 'Hello, world.';
    }
}

test('class based resolvers can be used', function () {
    $config = [
        'name' => usesClass(SimpleResolver::class),
    ];

    expect(renderAttributes($config))->toBe('name="Hello, world."');
});

test('class based resolvers can be used with context', function () {
    $config = [
        'name' => usesClass(SimpleResolver::class),
    ];

    expect(renderAttributes($config, [
        'title' => 'The context title',
    ]))->toBe('name="The context title"');
});

test('class based resolvers can be easily ignored', function () {
    $config = [
        'name' => 'John Doe',
        'title' => usesClass(SimpleResolver::class)->isIgnorable(),
    ];

    expect(renderAttributes($config, [
        'ignore' => true,
    ]))->toBe('name="John Doe"');
});

test('class based resolvers can be easily rejected', function () {
    $config = [
        'name' => 'John Doe',
        'title' => usesClass(SimpleResolver::class)->rejectsOnEmpty(),
    ];

    expect(renderAttributes($config, [
        'ignore' => true,
    ]))->toBe('');
});
