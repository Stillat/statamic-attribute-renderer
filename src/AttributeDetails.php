<?php

namespace Stillat\StatamicAttributeRenderer;

class AttributeDetails
{
    public function __construct(
        public string $key,
        public mixed $value,
        public array $attributes,
    ) {
    }
}
