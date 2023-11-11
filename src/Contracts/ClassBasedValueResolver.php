<?php

namespace Stillat\StatamicAttributeRenderer\Contracts;

use Stillat\StatamicAttributeRenderer\AttributeDetails;

interface ClassBasedValueResolver
{
    public function getValue(array $context, AttributeDetails $attributesDetails): mixed;
}
