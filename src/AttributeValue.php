<?php

namespace Stillat\StatamicAttributeRenderer;

class AttributeValue
{
    public function __construct(
        public string $name,
        public mixed $value,
        public bool $wasEmpty = false
    ) {
    }

    /**
     * Returns a list of values that should be repeated.
     *
     * This method will return an array of strings
     * in the format: name="value".
     */
    public function getRepeatedValues(): array
    {
        if (! is_array($this->value)) {
            return [];
        }

        $values = [];

        foreach ($this->value as $value) {
            $values[] = $this->name.'="'.e($value).'"';
        }

        return $values;
    }

    /**
     * Returns the string representation of the attribute.
     */
    public function __toString(): string
    {
        // If the value is a boolean, we'll assume that the attribute
        // is a boolean attribute. If the value is true, we'll
        // render the attribute name only. i.e., "required".
        if ($this->value === true) {
            return $this->name;
        }

        if (is_array($this->value)) {
            return '';
        }

        return $this->name.'="'.e($this->value).'"';
    }
}
