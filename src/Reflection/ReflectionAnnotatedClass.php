<?php

/**
 * Codeburner Framework.
 *
 * @author Alex Rohleder <contato@alexrohleder.com.br>
 * @copyright 2016 Alex Rohleder
 * @license http://opensource.org/licenses/MIT
 */

namespace Codeburner\Annotator\Reflection;

use ReflectionClass;
use ReflectionProperty;
use ReflectionMethod;

/**
 * Avoid the autoload by manually including the required files.
 * This bust significantly the performance.
 */

if (!trait_exists('Codeburner\Annotator\Reflection\AnnotationTrait', false)) {
	include __DIR__ . '/AnnotationTrait.php';
}

/**
 * Implements the annotation methods into the reflection.
 *
 * @author Alex Rohleder <contato@alexrohleder.com.br>
 */

class ReflectionAnnotatedClass extends ReflectionClass
{

	use AnnotationTrait;

	/**
	 * {inheritDoc}
	 */

	public function getProperties($filter = null)
	{
		$defaultFilter = ReflectionProperty::IS_STATIC    | ReflectionProperty::IS_PUBLIC | 
						 ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE 
		$properties = parent::getProperties($filter === null ? $defaultFilter : $filter);
		$annotatedProperties = [];

		foreach ($properties as $property) {
			$annotatedProperties[] = new ReflectionAnnotatedProperty($this->name, $property->name);
		}

		return $annotatedProperties;
	}

	/**
	 * {inheritDoc}
	 */

	public function getProperty($name)
	{
		return new ReflectionAnnotatedProperty($this->name, $name);
	}

	/**
	 * {inheritDoc}
	 */

	public function getMethods($filter = null)
	{
		$defaultFilter = ReflectionMethod::IS_STATIC  | ReflectionMethod::IS_PUBLIC   | ReflectionMethod::IS_PROTECTED | 
						 ReflectionMethod::IS_PRIVATE | ReflectionMethod::IS_ABSTRACT | ReflectionMethod::IS_FINAL;
		$methods = parent::getMethods($filter === null ? $defaultFilter : $filter);
		$annotatedMethods = [];

		foreach ($methods as $method) {
			$annotatedMethods[] = new ReflectionAnnotatedMethod($this->name, $method->name);
		}

		return $annotatedMethods;
	}

	/**
	 * {inheritDoc}
	 */

	public function getMethod($name)
	{
		return new ReflectionAnnotatedMethod($this->name, $name);
	}

	/**
	 * {inheritDoc}
	 */

	public function getTraits($filter = null)
	{
		$traits = parent::getTraits();
		$annotatedTraits = [];

		foreach ($traits as $trait) {
			$annotatedTraits[] = new ReflectionAnnotatedClass($trait->name);
		}

		return $annotatedTraits;
	}

}
