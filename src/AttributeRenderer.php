<?php

namespace Stillat\StatamicAttributeRenderer;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Stillat\StatamicAttributeRenderer\Contracts\ClassBasedValueResolver;

class AttributeRenderer
{
    /**
     * Indicates if any attribute was rejected.
     *
     * A rejected attributed will cause the entire tag
     * to be rejected, and no HTML will be rendered.
     */
    protected bool $wasAttributeRejected = false;

    /**
     * The shared value resolver instance.
     */
    protected ValueResolver $valueResolver;

    public function __construct(ValueResolver $valueResolver)
    {
        $this->valueResolver = $valueResolver;
    }

    /**
     * Converts an array of attribute values to HTML.
     *
     * @param  AttributeValue[]  $values
     */
    public function valuesToHtml(array $values): string
    {
        return collect($values)->map(fn ($value) => (string) $value)->implode(' ');
    }

    /**
     * Converts an array of attributes to HTML.
     *
     * The context array is passed to the value resolver.
     * This method accepts attributes in the "array format".
     *
     * @param  array  $attributes The attributes to convert.
     * @param  array  $context The context array.
     */
    public function arrayToHtml(array $attributes, array $context): string
    {
        $values = $this->getAttributeValues($attributes, $context);

        return $this->valuesToHtml($values);
    }

    /**
     * Converts attributes in "array syntax" to AttributeValue instances.
     *
     * @param  array  $attributes The attributes to convert.
     * @param  array  $context The context array.
     */
    public function getAttributeValues(array $attributes, array $context): array
    {
        $this->wasAttributeRejected = false;

        $values = [];

        foreach ($attributes as $key => $value) {
            if (Str::startsWith($key, '_')) {
                continue;
            }

            $attributeValue = $this->getAttributeValue($key, $value, $context, $attributes);

            if ($this->wasAttributeRejected) {
                return [];
            }

            if ($attributeValue->wasEmpty) {
                continue;
            }

            $values[] = $attributeValue;
        }

        return $values;
    }

    /**
     * Tests if the provided value is a valid attribute value.
     *
     * @param  mixed  $value The value to check.
     */
    protected function isValidType(mixed $value): bool
    {
        return is_string($value) || is_numeric($value) || is_callable($value) || (is_object($value) && (method_exists($value, '__toString') || $value instanceof RepeatableValue));
    }

    /**
     * Converts a single array attribute to an AttributeValue instance.
     *
     * @param  string  $key The attribute name.
     * @param  mixed  $value The attribute value.
     * @param  array  $context The context array.
     * @param  array  $allAttributes A reference to all configured attributes.
     */
    private function getAttributeValue(string $key, mixed $value, array $context, array $allAttributes): AttributeValue
    {
        $ignoreOnEmpty = false;
        $rejectOnEmpty = false;
        $classBasedResolver = null;

        if ($value instanceof ConfigurationBuilder) {
            $value = $value->build();
        }

        if (is_array($value)) {
            if (! array_key_exists('value', $value)) {
                if (array_key_exists('class', $value) && class_exists($value['class'])) {
                    $classBasedResolver = $value['class'];
                } else {
                    return new AttributeValue('', true);
                }
            } else {
                if (! $this->isValidType($value['value'])) {
                    if (array_key_exists('reject_empty', $value)) {
                        $this->wasAttributeRejected = true;
                    }

                    return new AttributeValue('', true);
                }
            }

            if (array_key_exists('ignore_empty', $value)) {
                $ignoreOnEmpty = $value['ignore_empty'];
            }

            if (array_key_exists('reject_empty', $value)) {
                $rejectOnEmpty = $value['reject_empty'];
            }

            if (array_key_exists('value', $value) && $classBasedResolver == null) {
                $value = $value['value'];
            }
        }

        if ($classBasedResolver != null) {
            $resolver = app($classBasedResolver);

            if (! $resolver instanceof ClassBasedValueResolver) {
                $value = null;
            } else {
                $value = $resolver->getValue($context, new AttributeDetails(
                    key: $key,
                    value: $value,
                    attributes: $allAttributes
                ));
            }
        } elseif ($value instanceof Closure) {
            $value = $value($context, new AttributeDetails(
                key: $key,
                value: $value,
                attributes: $allAttributes
            ));
        } else {
            if (is_string($value) && Str::startsWith($value, '$')) {
                $value = mb_substr($value, 1);

                // If we don't start with $ again, we can assume it's a context value.
                if (! Str::startsWith($value, '$')) {
                    if ($this->valueResolver->has($value)) {
                        $value = $this->valueResolver->get($value, $context);
                    } else {
                        $value = Arr::get($context, $value, '');
                    }
                }
            }
        }

        if (is_bool($value)) {
            return new AttributeValue(
                name: $key,
                value: $value
            );
        }

        if ($value instanceof RepeatableValue) {
            if (count($value->values) == 0 && ($ignoreOnEmpty || $rejectOnEmpty)) {
                if ($rejectOnEmpty) {
                    $this->wasAttributeRejected = true;
                }

                return new AttributeValue($key, '', true);
            }

            return new AttributeValue($key, $value->values);
        }

        $value = (string) $value;

        if (($ignoreOnEmpty || $rejectOnEmpty) && mb_strlen(trim($value)) == 0) {
            if ($rejectOnEmpty) {
                $this->wasAttributeRejected = true;
            }

            return new AttributeValue($key, $value, true);
        }

        return new AttributeValue($key, $value);
    }
}
