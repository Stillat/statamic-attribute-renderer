<?php

namespace Stillat\StatamicAttributeRenderer;

class AttributesWrapper
{
    protected AttributeRenderer $attributeRenderer;

    protected LinkTagRenderer $linkRenderer;

    protected MetaTagRenderer $metaTagRenderer;

    public function __construct(AttributeRenderer $attributeRenderer, LinkTagRenderer $linkRenderer, MetaTagRenderer $metaTagRenderer)
    {
        $this->attributeRenderer = $attributeRenderer;
        $this->linkRenderer = $linkRenderer;
        $this->metaTagRenderer = $metaTagRenderer;
    }

    public function renderAttributes(array $attributes, array $context = []): string
    {
        return $this->attributeRenderer->arrayToHtml($attributes, $context);
    }

    public function getMetaTags(array $attributes, array $context = []): array
    {
        return $this->metaTagRenderer->getTags($attributes, $context);
    }

    public function renderMetaTags(array $attributes, array $context = []): string
    {
        return implode("\n", $this->getMetaTags($attributes, $context));
    }

    public function getLinkTags(array $attributes, array $context = []): array
    {
        return $this->linkRenderer->getTags($attributes, $context);
    }

    public function renderLinkTags(array $attributes, array $context = []): string
    {
        return implode("\n", $this->getLinkTags($attributes, $context));
    }
}
