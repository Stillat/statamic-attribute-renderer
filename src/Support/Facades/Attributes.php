<?php

namespace Stillat\StatamicAttributeRenderer\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Stillat\StatamicAttributeRenderer\AttributesWrapper;

/**
 * @method static string renderAttributes(array $attributes, array $context = [])
 * @method static array getMetaTags(array $attributes, array $context = [])
 * @method static string renderMetaTags(array $attributes, array $context = [])
 * @method static array getLinkTags(array $attributes, array $context = [])
 * @method static string renderLinkTags(array $attributes, array $context = [])
 */
class Attributes extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AttributesWrapper::class;
    }
}
