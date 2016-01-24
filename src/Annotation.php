<?php

/**
 * Codeburner Framework.
 *
 * @author Alex Rohleder <contato@alexrohleder.com.br>
 * @copyright 2016 Alex Rohleder
 * @license http://opensource.org/licenses/MIT
 */

namespace Codeburner\Annotator;

/**
 * The annotation representation.
 *
 * @author Alex Rohleder <contato@alexrohleder.com.br>
 */

class Annotation
{

	protected $name;
	protected $arguments;

	public function __construct(array $annotation)
	{
		$this->name = $annotation[1];
		$arguments  = $annotation[2];

		if (strpos($arguments, "{") === 0) {
			   $this->arguments = json_decode($arguments, true);
		} else $this->arguments = trim($arguments);
	}

	public function getName()
	{
		return $this->name;
	}

	public function getArguments()
	{
		return $this->arguments;
	}

	public function getArgument($name)
	{
		return $this->arguments[$name];
	}

	public function getArgumentCount()
	{
		return count($this->arguments);
	}

	public function hasArgument($name)
	{
		return isset($this->arguments[$name]);
	}

}
