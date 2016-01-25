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

	/**
	 * The annotation token.
	 *
	 * @var string
	 */

	protected $name;

	/**
	 * Formmated arguments, but not casted.
	 *
	 * @var array
	 */

	protected $arguments;

	/**
	 * @param string $name
	 * @param string $arguments
	 */

	public function __construct($name, $arguments)
	{
		$this->name = $name;

		if (strpos($arguments, "{") === 0) {
			   $this->arguments = json_decode($arguments, true);
		} else $this->arguments = (array) trim($arguments);

		$this->filter();
	}

	/**
	 * @return string
	 */

	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return array
	 */

	public function getArguments()
	{
		return $this->arguments;
	}

	/**
	 * @return string
	 */

	public function getArgument($name)
	{
		return isset($this->arguments[$name]) ? $this->arguments[$name] : null;
	}

	/**
	 * @return string
	 */

	public function getArgumentCount()
	{
		return count($this->arguments);
	}

	/**
	 * @return boolean
	 */

	public function hasArgument($name)
	{
		return isset($this->arguments[$name]);
	}

	/**
	 * Overwrite this method to parse and validate the arguments in a
	 * new Annotation definition.
	 *
	 * @return void
	 */

	protected function filter()
	{
		// void
	}

}
