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

class ReflectionAnnotatedClass extends \ReflectionClass
{

	use ReflectionAnnotatedTrait;

	/**
	 * {inheritDoc}
	 */

	public function getProperties($filter = \ReflectionProperty::IS_STATIC | \ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED | \ReflectionProperty::IS_PRIVATE)
	{
		$properties = parent::getProperties($filter);
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

}
