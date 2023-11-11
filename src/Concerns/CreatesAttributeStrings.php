<?php

namespace Stillat\StatamicAttributeRenderer\Concerns;

use Stillat\StatamicAttributeRenderer\AttributeRenderer;

trait CreatesAttributeStrings
{
    private ?AttributeRenderer $attributeRenderer = null;

    /**
     * Returns the attribute renderer instance.
     */
    public function getAttributeRenderer(): AttributeRenderer
    {
        if ($this->attributeRenderer === null) {
            $this->attributeRenderer = app(AttributeRenderer::class);
        }

        return $this->attributeRenderer;
    }

    /**
     * Converts a list of attributes in array form to an HTML string.
     *
     * @param  array  $attributes The attributes to render.
     * @param  array  $context The context.
     */
    public function createAttributeString(array $attributes, array $context = []): string
    {
        return $this->getAttributeRenderer()->arrayToHtml($attributes, $context);
    }
}
