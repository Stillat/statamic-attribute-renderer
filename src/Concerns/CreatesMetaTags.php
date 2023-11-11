<?php

namespace Stillat\StatamicAttributeRenderer\Concerns;

use Stillat\StatamicAttributeRenderer\MetaTagRenderer;

trait CreatesMetaTags
{
    private ?MetaTagRenderer $metaTagRenderer = null;

    /**
     * Returns the meta tag renderer instance.
     */
    public function getMetaTagRenderer(): MetaTagRenderer
    {
        if ($this->metaTagRenderer === null) {
            $this->metaTagRenderer = app(MetaTagRenderer::class);
        }

        return $this->metaTagRenderer;
    }

    /**
     * Converts a list of meta attributes in array form to an HTML string.
     *
     * @param  array  $metaConfig The meta configuration.
     * @param  array  $context The context.
     */
    public function createMetaTags(array $metaConfig, array $context = []): array
    {
        return $this->getMetaTagRenderer()->getTags($metaConfig, $context);
    }
}
