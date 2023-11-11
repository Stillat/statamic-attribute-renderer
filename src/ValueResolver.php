<?php

namespace Stillat\StatamicAttributeRenderer;

use Closure;

class ValueResolver
{
    /**
     * A list of variable resolvers.
     *
     * Variable names are stored as keys, and the resolving Closure as the value.
     * When a variable is being resolved and is present in this list, the Closure
     * will be used to locate the value instead of the default resolution process.
     *
     * @var array <string, Closure>
     */
    protected array $variableResolvers = [];

    /**
     * A cache of resolved variables.
     *
     * @var array <string, mixed>
     */
    protected array $resolvedVariables = [];

    /**
     * Adds a new variable resolver.
     *
     * Closures will receive an array of contextual data as the first parameter.
     *
     * @param  string  $variable The variable name.
     * @param  Closure  $resolver The resolver Closure.
     * @return $this
     */
    public function addResolver(string $variable, Closure $resolver): self
    {
        $this->variableResolvers[$variable] = $resolver;

        return $this;
    }

    /**
     * Determines if a variable resolver exists.
     *
     * @param  string  $variable The variable name.
     */
    public function has(string $variable): bool
    {
        return array_key_exists($variable, $this->variableResolvers);
    }

    /**
     * Gets a variable value.
     *
     * @param  string  $variable The variable name.
     * @param  array  $context The contextual data.
     */
    public function get(string $variable, array $context): mixed
    {
        if (! array_key_exists($variable, $this->variableResolvers)) {
            return null;
        }

        if (! array_key_exists($variable, $this->resolvedVariables)) {
            $this->resolvedVariables[$variable] = $this->variableResolvers[$variable]($context);
        }

        return $this->resolvedVariables[$variable] ?? null;
    }

    /**
     * Clears all resolved variables.
     *
     * @return $this
     */
    public function clear(): self
    {
        $this->resolvedVariables = [];

        return $this;
    }

    /**
     * Clears all variable resolvers.
     *
     * @return $this
     */
    public function clearVariableResolvers(): self
    {
        $this->variableResolvers = [];

        return $this;
    }

    /**
     * Clears all variable resolvers and resolved variables.
     *
     * @return $this
     */
    public function clearAll(): self
    {
        $this->resolvedVariables = [];
        $this->variableResolvers = [];

        return $this;
    }
}
