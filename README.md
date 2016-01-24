# Codeburner Annotator

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
- [Basic Usage](#basic-usage)

## Introduction

 Annotation is a form of metadata, provide data about a program but is not part of the program itself. Annotations have no direct effect on the operation of the code they annotate.
 It's frequently used on JAVA applications, in PHP there is no native implementation of annotations, but as example exists the Doctrine ORM that annotate the models using the PHPDoc comment style.

## Syntax

The annotations need to start with `@` and be inside a doc block `/**`. Annotation names receive the same rules of vars in PHP, and they value are everything after the first space. There is support three types of data. 

- Empty annotations with no value, only representation. 
- Simple annotations are strings and numerics.
- Complex annotations is composed by a json with no rule about the deep.

```php
/**
 * @EmptyAnnotation
 * @SimpleAnnotation 1
 * @ComplexAnnotation {"key1": "value1", "key2": ["value2-1", "value2-2"]}
 */
```

## Basic Usage

For example registering routes in the (codeburner router system)[https://github.com/codeburnerframework/router] only using annotations in a controller.

```php
/**
 * @RouteStrategy \Codeburner\Router\Strategy\SimpleDispatchStrategy
 * @RoutePrefix /blog
 */

class ArticleController
{

	/**
	 * @Route /
	 */

	public function index()
	{

	}
}
}
```

In this code there is three annotations, `@RouteStrategy`, `@RoutePrefix` and `@Route`. The router system will read these annotations and build a route based on then.
