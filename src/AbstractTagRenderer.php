<?php

namespace Stillat\StatamicAttributeRenderer;

use Statamic\Facades\Antlers;

abstract class AbstractTagRenderer extends AttributeRenderer
{
    /**
     * The tag template.
     */
    protected string $tagTemplate = '';

    /**
     * Converts the provided tag values to HTML.
     *
     * @param  array  $tagsConfig The attribute/tags to render.
     * @param  array  $context The array context.
     */
    public function getTags(array $tagsConfig, array $context): array
    {
        $tags = [];

        foreach ($tagsConfig as $configuration) {
            $result = $this->getTag($configuration, $context);

            if (! $result) {
                continue;
            }

            $tags[] = $result;
        }

        return $tags;
    }

    /**
     * Converts a single tag to HTML.
     *
     * @param  array  $tagConfiguration The tag configuration.
     * @param  array  $context The array context.
     */
    public function getTag(array $tagConfiguration, array $context): ?string
    {
        /** @var AttributeValue[] $values */
        $values = $this->getAttributeValues($tagConfiguration, $context);

        if (count($values) == 0) {
            return null;
        }

        if (array_key_exists('_template', $tagConfiguration)) {
            $template = $tagConfiguration['_template'];

            if (mb_strlen(trim($template)) == 0) {
                return null;
            }

            $variables = collect($values)->mapWithKeys(function ($value) {
                return [$value->name => $value->value];
            })->toArray();

            $result = (string) Antlers::parse($template, array_merge($context, $variables));

            if (mb_strlen(trim($result)) == 0) {
                return null;
            }

            return $result;
        }

        $regularValues = [];
        $repeatFor = null;

        foreach ($values as $value) {
            if (is_array($value->value)) {
                $repeatFor = $value;
            } else {
                $regularValues[] = $value;
            }
        }

        if ($repeatFor !== null) {

            $results = '';

            $baseAttributes = $this->valuesToHtml($regularValues);

            foreach ($repeatFor->getRepeatedValues() as $repeatedValue) {
                $results .= strtr($this->tagTemplate, [
                    '{attributes}' => $baseAttributes.' '.$repeatedValue,
                ]);
            }

            return $results;
        }

        return strtr($this->tagTemplate, [
            '{attributes}' => $this->valuesToHtml($regularValues),
        ]);
    }
}
