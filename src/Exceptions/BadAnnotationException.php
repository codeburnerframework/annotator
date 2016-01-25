<?php

/**
 * Codeburner Framework.
 *
 * @author Alex Rohleder <contato@alexrohleder.com.br>
 * @copyright 2016 Alex Rohleder
 * @license http://opensource.org/licenses/MIT
 */

namespace Codeburner\Annotator\Exceptions;

/**
 * Exception throwed when a annotation was used wrong.
 *
 * @author Alex Rohleder <contato@alexrohleder.com.br>
 */

class BadAnnotationException extends AnnotationException
{

	public function __construct($annotation)
	{
		parent::__construct("The `$annotation` annotation was used wrong. Please check the arguments.");
	}

}
