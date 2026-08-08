# Internals

## Unit testing

The package is tested with [PHPUnit](https://phpunit.de/). To run tests:

```shell
./vendor/bin/phpunit
```

## Mutation testing

The package tests are checked with [Infection](https://infection.github.io/) mutation framework. To run it:

```shell
./vendor/bin/infection
```

## Static analysis

The code is statically analyzed with [Psalm](https://psalm.dev/). To run static analysis:

```shell
./vendor/bin/psalm
```

## Code style

Use [Rector](https://github.com/rectorphp/rector) to make codebase follow some specific rules or
use either newest or any specific version of PHP:

```shell
./vendor/bin/rector
```

## Dependencies

Use [Composer Dependency Analyser](https://github.com/shipmonk-rnd/composer-dependency-analyser) to detect unknown,
shadow, and unused [Composer](https://getcomposer.org) dependencies:

```shell
./vendor/bin/composer-dependency-analyser
```

## Themes' preview

This package ships with the demo for built-in themes featuring all available fields.

Prerequisites:

- Docker.

Generating HTML files:

```shell
cd themes-preview
make
```

The generated files will be available at the following paths:

- `themes-preview/bootstrap5/bootstrap5-horizontal.html`;
- `themes-preview/bootstrap5/bootstrap5-vertical.html`;

Use the interner browser of your choice to view them. 
