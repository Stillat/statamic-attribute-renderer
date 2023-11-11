<?php

namespace Stillat\StatamicAttributeRenderer;

use Closure;

class ConfigurationBuilder
{
    /**
     * The configuration array.
     */
    protected array $config = [];

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * Configures the builder to use a class-based resolver.
     *
     * @param  string  $className The class name.
     * @return $this
     */
    public function useClass(string $className): self
    {
        $this->config['class'] = $className;

        return $this;
    }

    /**
     * Configures the builder to be ignored if the value is empty.
     *
     * @param  bool  $isIgnorable Indicates if the attribute is ignorable.
     * @return $this
     */
    public function isIgnorable(bool $isIgnorable = true): self
    {
        if ($isIgnorable) {
            $this->config['ignore_empty'] = true;
        } else {
            unset($this->config['ignore_empty']);
        }

        return $this;
    }

    /**
     * Configures the builder to be rejected if the value is empty.
     *
     * @param  bool  $rejectsOnEmpty Indicates if the final HTML value should be rejected if the value is empty.
     * @return $this
     */
    public function rejectsOnEmpty(bool $rejectsOnEmpty = true): self
    {
        if ($rejectsOnEmpty) {
            $this->config['reject_empty'] = true;
        } else {
            unset($this->config['reject_empty']);
        }

        return $this;
    }

    /**
     * Configures the builder to use a custom value.
     *
     * @param  Closure|mixed  $value The value to use.
     * @return $this
     */
    public function withValue(mixed $value): self
    {
        $this->config['value'] = $value;

        return $this;
    }

    /**
     * Returns the configuration array.
     */
    public function build(): array
    {
        return $this->config;
    }
}
