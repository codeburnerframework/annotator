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
 * Group several annotations.
 *
 * @author Alex Rohleder <contato@alexrohleder.com.br>
 */

class Group
{

	protected $annotations = [];

	public function __construct(array $annotations)
	{
		foreach ($annotations as $annotation) {
			$this->annotations[$annotation[1]] = new Annotation($annotation);
		}
	}

	public function count()
	{
		return count($this->annotations);
	}

	public function get($name)
	{
		return $this->annotations[$name];
	}

	public function all()
	{
		return $this->annotations;
	}

	public function has($name)
	{
		return isset($this->annotations);
	}

}
