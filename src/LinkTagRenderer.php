<?php

namespace Stillat\StatamicAttributeRenderer;

class LinkTagRenderer extends AbstractTagRenderer
{
    protected string $tagTemplate = '<link {attributes}>';
}
