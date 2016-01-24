<?php

/**
 * Codeburner Framework.
 *
 * @author Alex Rohleder <contato@alexrohleder.com.br>
 * @copyright 2016 Alex Rohleder
 * @license http://opensource.org/licenses/MIT
 */

namespace Codeburner\Annotator\Reflection;

/**
 * Avoid the autoload by manually including the required files.
 * This bust significantly the performance.
 */

if (!trait_exists('Codeburner\Annotator\Reflection\ReflectionAnnotatedTrait', false)) {
	include __DIR__ . '/ReflectionAnnotatedTrait.php';
}

/**
 * Implements the annotation methods into the reflection.
 *
 * @author Alex Rohleder <contato@alexrohleder.com.br>
 */

class ReflectionAnnotatedMethod extends \ReflectionMethod
{
	use ReflectionAnnotatedTrait;
}
