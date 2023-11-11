# Attribute Renderer for Statamic

Attribute Renderer is a utility addon that helps create HTML attribute strings from arrays.

At a high level, it allows you to convert something like this:

```php
<?php

use function Stillat\StatamicAttributeRenderer\attributes;

attributes([
    'name' => 'author',
    'content' => 'John Doe'
]);
```

to the following HTML attribute string:

```html
name="author" content="John Doe"
```

The attributes renderer is also context aware, and can do things like this:

```php
<?php

use function Stillat\StatamicAttributeRenderer\attributes;

attributes([
    'name' => 'author',
    'content' => '$author'
], [
    'author' => 'John Doe'
]);
```

These examples are basic, and Attribute Renderer supports even more complex scenarios.

## How to Install

Attribute Renderer can be installed by running the following command from the root of your project:

``` bash
composer require stillat/statamic-attribute-renderer
```

## Converting Arrays to Attribute Strings

The simplest way to convert a key/value array of attribute details to a string is using the `attributes` utility function:

```php
<?php

use function Stillat\StatamicAttributeRenderer\attributes;

attributes([
    'name' => 'author',
    'content' => 'John Doe'
]);
```

which produces the following result:

```html
name="author" content="John Doe"
```

## Resolving Variable Values

We can resolve variables from contextual data, which is supplied as the second argument to the `attributes` function. When specifying variable names, we simply prefix them with the `$` symbol:

```php
<?php

use function Stillat\StatamicAttributeRenderer\attributes;

attributes([
    'name' => 'author',
    'content' => '$author'
], [
    'author' => 'John Doe'
]);
```

We can use `$$` to escape the beginning of a variable string to emit string beginning with a single `$`:

```php
<?php

use function Stillat\StatamicAttributeRenderer\attributes;

attributes([
    'name' => 'author',
    'content' => '$author',
    'content_two' => '$$author',
    'content_three' => '$$$author',
], [
    'author' => 'John Doe'
]);
```

which produces the following output:

```html
name="author" content="John Doe" content_two="$author" content_three="$$author"
```

Attribute Renderer does not support more complicated variable paths, such as nested properties, or array indices. If you need something more complicated, consider using a closure based variable resolver.

## Closure Based Variable Resolvers

We can supply a `Closure` as the value of our attribute in order to resolve more complicated values. We will receive the context array as the first argument:

```php
<?php

use function Stillat\StatamicAttributeRenderer\attributes;

attributes([
    'name' => 'author',
    'content' => function (array $context) {
        return 'Hello, '.$context['author'];
    },
], [
    'author' => 'John Doe'
]);
```

which produces:

```html
name="author" content="Hello, John Doe"
```

## Skippable/Ignorable Properties

By default, Attribute Renderer will emit empty strings if a value returns `null`:

```php
<?php

use function Stillat\StatamicAttributeRenderer\attributes;

attributes([
    'name' => 'author',
    'content' => '$name'
]);
```

produces:

```html
name="author" content=""
```

we can let Attribute Renderer know its okay to ignore a property when producing the final result:

```php
<?php

use function Stillat\StatamicAttributeRenderer\attributes;
use function Stillat\StatamicAttributeRenderer\isIgnorable;

attributes([
    'name' => 'author',
    'content' => isIgnorable('$name')
]);
```

would now produce:

```html
name="author"
```

However, if the value did exist within the context:

```php
<?php

use function Stillat\StatamicAttributeRenderer\attributes;
use function Stillat\StatamicAttributeRenderer\isIgnorable;

attributes([
    'name' => 'author',
    'content' => isIgnorable('$name')
], [
    'name' => 'John Doe'
]);
```

the ignorable property is added to the output:

```html
name="author" content="John Doe"
```

## Rejectable Properties

Rejectable properties are similar to ignorable properties. However, if a `null` or empty string value is resolved for one of these values, an empty attribute string is returned, regardless of if other property values were matched:

```php
<?php

use function Stillat\StatamicAttributeRenderer\attributes;
use function Stillat\StatamicAttributeRenderer\rejectsOnEmpty;

attributes([
    'name' => 'author',
    'content' => rejectsOnEmpty('$name'),
    'first_name' => '$first_name'
], [
    'first_name' => 'John Doe'
]);
```

## License

Attribute Renderer is free software, released under the MIT license.
