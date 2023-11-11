<?php

namespace Stillat\StatamicAttributeRenderer;

class MetaTagRenderer extends AbstractTagRenderer
{
    protected string $tagTemplate = '<meta {attributes}>';
}
