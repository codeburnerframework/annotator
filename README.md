# Codeburner Annotator

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE)
[![Build Status](https://travis-ci.org/codeburnerframework/annotator.svg?branch=master)](https://travis-ci.org/codeburnerframework/annotator)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/codeburnerframework/annotator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/codeburnerframework/annotator/?branch=master)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/bd481c37-a371-4e91-b2ad-546c5d00263c/big.png)](https://insight.sensiolabs.com/projects/bd481c37-a371-4e91-b2ad-546c5d00263c)

A simple and fast annotation support for PHP.

## Instalation
Add `codeburner/annotator` to your `composer.json` file.

```json
{
    "require": {
        "codeburner/annotator": "1.*"
    }
}
```
or via cli
```
$ composer require codeburner/annotator
```

Don't forget to install or update the composer and include the `vendor/autoload.php` file.

## Table of Content

- [Introduction](#introduction)
- [Syntax](#syntax)
- [Annotation Classes](#annotation-classes)
- [Filtering Values](#filtering-values)
- [Basic Usage](#basic-usage)
- [Real World Usage](#real-world-usage)

## Introduction

 Annotation is a form of metadata, provide data about a program but is not part of the program itself. Annotations have no direct effect on the operation of the code they annotate.
 It's frequently used on JAVA applications, in PHP there is no native implementation of annotations, but as example exists the Doctrine ORM that annotate the models using the PHPDoc comment style.

## Syntax

The annotations need to start with `@` and be inside a doc block `/**`. Annotation names receive the same rules of vars in PHP, and they value can be everything BUT it will be parsed as string, the annotator does not make any cast and arrays must be write as jsons.

```php
/**
 * @EmptyAnnotation
 * @OneAnnotation 1
 * @ComplexAnnotation {"key1": "value1", "key2": ["value2-1", "value2-2"]}
 */
```

## Annotation Classes

By default any annotation is a `Codeburner\Annotator\Annotation` but you can specialize one annotation adding logic to they. For it you must create a new class that extends the `Codeburner\Annotator\Annotation`. The annotation name will be the full class name, but can be affected by the `use` and `namespace` statements.

```php
namespace Foo\Bar;

use Foo\FooAnnotation;
use Foo\Bar\BarAnnotation as AliasedAnnotation;

/**
 * @BarAnnotation -f
 * @FooAnnotation -f
 * @AliasedAnnotation -f
 */
```
`BarAnnotation` is `Foo\Bar\BarAnnotation` class, `FooAnnotation` is `Foo\FooAnnotation` class and `AliasedAnnotation` is `Foo\Bar\BarAnnotation class`.
> **NOTE:** All defined annotations must have the `-f` flag in usage, this means that it's a file and can have a filter.

## Filtering Values

When defining a class for an annotation the arguments could be formmated or filtered by the implementation of method `public function filter()`. 

```php
class MyAnnotation extends Codeburner\Annotator\Annotation
{
	public function filter()
	{
		array_filter($this->arguments, 'strtoupper');
	}
}
```

## Basic Usage

```php

/**
 * @cook Crystals
 * @with {"local": "trailer", "clothes": ["apron", "briefs"]}
 */

class HeisenbergController
{

	/**
	 * @number 1000
	 */

	public function count()
	{

	}

}

$reflection = new Codeburner\Annotator\Reflection\ReflectionAnnotatedClass(HeisenbergController::class);

echo "I'll cook ", 
		$reflection->getMethod("count")->getAnnotation("number"), " ", 
		$reflection->getAnnotation("cook"), " in my ", 
		$reflection->getAnnotation("with")->getArgument("local"), " with wearing ",
		implode(", ", $reflection->getAnnotation("with")->getArgument("clothes"));

```

## Real World Usage

For example registering routes in the [codeburner router system](https://github.com/codeburnerframework/router) only using annotations in a controller.

```php
use Codeburner\Router\Annotations\RouteStrategyAnnotation as RouteStrategy;
use Codeburner\Router\Annotations\RoutePrefixAnnotation as RoutePrefix;
use Codeburner\Router\Annotations\RouteAnnotation as Route;

/**
 * @RouteStrategy -f \Codeburner\Router\Strategy\SimpleDispatchStrategy
 * @RoutePrefix -f /blog
 */

class ArticleController
{

	/**
	 * @Route -f /
	 */

	public function index()
	{

	}
}

```

In this code there is three annotations, `@RouteStrategy`, `@RoutePrefix` and `@Route`. The router system will read these annotations and build a route based on then.
