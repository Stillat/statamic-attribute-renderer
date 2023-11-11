<?php

namespace Stillat\StatamicAttributeRenderer;

use Stillat\StatamicAttributeRenderer\Support\Facades\Attributes;

function attributes(array $attributes, array $context = []): string
{
    return Attributes::renderAttributes($attributes, $context);
}

function metaTags(array $attributes, array $context = []): string
{
    return Attributes::renderMetaTags($attributes, $context);
}

function linkTags(array $attributes, array $context = []): string
{
    return Attributes::renderLinkTags($attributes, $context);
}

/**
 * Creates a new attribute configuration item for the given value.
 *
 * If the provided value is empty, the attribute will be ignored.
 *
 * @param  mixed  $value The value.
 */
function isIgnorable(mixed $value): ConfigurationBuilder
{
    return (new ConfigurationBuilder())->isIgnorable()->withValue($value);
}

/**
 * Creates a new attribute configuration item for the given value.
 *
 * If the provided value is empty, no attributes will be rendered.
 *
 * @param  mixed  $value The value.
 */
function rejectsOnEmpty(mixed $value): ConfigurationBuilder
{
    return (new ConfigurationBuilder())->rejectsOnEmpty()->withValue($value);
}

/**
 * Creates a new, repeatable, attribute configuration item for the given values.
 *
 * The provided values must be a list of strings, or
 * objects that implement the __toString method.
 *
 * Nested or multidimensional arrays are not supported.
 *
 * @param  array  $values The values.
 */
function isRepeatable(array $values): RepeatableValue
{
    return new RepeatableValue($values);
}

/**
 * Creates a new attribute configuration item for the given value using a class-based resolver.

 *
 * @param  string  $className The class name.
 * @return string[]
 */
function usesClass(string $className): ConfigurationBuilder
{
    return (new ConfigurationBuilder())->useClass($className);
}
