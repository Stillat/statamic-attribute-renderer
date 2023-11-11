<?php

namespace Stillat\StatamicAttributeRenderer;

/**
 * Represents a repeatable value.
 *
 * Repeatable values may be returned from the AttributeRenderer.
 * The default AbstractTagRenderer will render each value as a
 * separate tag instance. Nested array data is not supported.
 */
class RepeatableValue
{
    public function __construct(
        public readonly array $values
    ) {
    }
}
