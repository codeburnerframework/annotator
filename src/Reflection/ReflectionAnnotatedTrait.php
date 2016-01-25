<?php

/**
 * Codeburner Framework.
 *
 * @author Alex Rohleder <contato@alexrohleder.com.br>
 * @copyright 2016 Alex Rohleder
 * @license http://opensource.org/licenses/MIT
 */

namespace Codeburner\Annotator\Reflection;

use Codeburner\Annotator\Annotation;
use Codeburner\Annotator\Group;

/**
 * Avoid the autoload by manually including the required files.
 * This bust significantly the performance.
 */

if (!class_exists('Codeburner\Annotator\Annotation', false)) {
	include __DIR__ . '/../Annotation.php';
}

/**
 * Implements the annotation methods into a reflection.
 *
 * @author Alex Rohleder <contato@alexrohleder.com.br>
 */

trait ReflectionAnnotatedTrait
{

	abstract public function getDocComment();
	protected $docComment;

	public function getAnnotation($name)
	{
		preg_match_all("~@(" . implode("|", (array) $name) . ')\s?(.*)?~i', $this->getDoc(), $annotations, PREG_SET_ORDER);
		
		if (empty($annotations)) {
			return null;
		}

		if (count($annotations) > 1) {
			   return new Group($annotations);
		} else return new Annotation($annotations[0]);
	}

	public function getAnnotations()
	{
		return $this->getAnnotation("[\w]+");
	}

	public function hasAnnotation($name)
	{
		return (bool) preg_match("~@$name~", $this->getDoc());
	}

	protected function getDoc()
	{
		if ($this->docComment) {
			   return $this->docComment;
		} else return $this->docComment = $this->getDocComment();
	}

}
