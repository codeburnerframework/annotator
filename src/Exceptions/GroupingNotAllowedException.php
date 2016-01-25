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
 * Exception throwed when a annotation method cannot support
 * regex or grouping in annotation name.
 *
 * @author Alex Rohleder <contato@alexrohleder.com.br>
 */

class GroupingNotAllowedException extends AnnotationException
{

	public function __construct($method)
	{
		parent::__construct("Annotator method `$method` does not allow grouping or regex in annotation name.");
	}

}
