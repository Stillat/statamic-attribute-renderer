<?php

namespace Stillat\StatamicAttributeRenderer\Concerns;

use Stillat\StatamicAttributeRenderer\LinkTagRenderer;

trait CreatesLinksTags
{
    private ?LinkTagRenderer $linkTagRenderer = null;

    /**
     * Returns the link tag renderer instance.
     */
    public function getLinkTagRenderer(): LinkTagRenderer
    {
        if ($this->linkTagRenderer === null) {
            $this->linkTagRenderer = app(LinkTagRenderer::class);
        }

        return $this->linkTagRenderer;
    }

    /**
     * Converts a list of link attributes in array form to an HTML string.
     *
     * @param  array  $linkConfig The link configuration.
     * @param  array  $context The context.
     */
    public function createLinkTags(array $linkConfig, array $context = []): array
    {
        return $this->getLinkTagRenderer()->getTags($linkConfig, $context);
    }
}
