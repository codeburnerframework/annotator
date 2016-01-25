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
use Codeburner\Annotator\Exceptions\GroupingNotAllowedException;

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

    /**
     * As this trait must be used in a Reflection object, this method
     * must return the doc from a class, method or function.
     *
     * @return string
     */

	abstract public function getDocComment();

    /**
     * A simple cache of getDocComment
     *
     * @var string
     */

	protected $docComment;

    /**
     * Get an annotation by it literal name.
     * 
     * @param Annotation|null
     *
     * @throws MultipleAnnotationException
     * @return string
     */

	public function getAnnotation($name)
	{
        $annotations = $this->findAnnotationPattern($name);

		if (empty($annotations)) {
			return null;
		}

        if (count($annotations) > 1) {
            throw new GroupingNotAllowedException("getAnnotation");
        }

        return new Annotation($annotations[0]);
	}

    /**
     * Get all annotations, or several of then. Note that here annotations can
     * have regex on they name.
     *
     * @param array $names if empty will return all annotations. Can have regex.
     * @return array ["AnnotationName" => Annotation]
     */

	public function getAnnotations(array $names = array())
	{
        if (empty($names)) {
               $annotations = $this->findAnnotationPattern("[\w]+");
        } else $annotations = $this->findAnnotationPattern(implode("|", $names));

        $bucket = [];

        foreach ($annotations as $annotation) {
            $bucket[$annotation[1]] = new Annotation($annotation);
        }

        return $bucket;
	}

    /**
     * @param string $name
     * @return bool
     */

	public function hasAnnotation($name)
	{
		return (bool) preg_match("~@$name~", $this->getDoc());
	}

    /**
     * @return string
     */

	protected function getDoc()
	{
		if ($this->docComment) {
			   return $this->docComment;
		} else return $this->docComment = $this->getDocComment();
	}

    /**
     * @param string $pattern
     * @return array|null
     */

    protected function findAnnotationPattern($pattern)
    {
        preg_match_all("~@(" . str_replace("\\", "\\\\", $pattern) . ")\s?(.*)?~i", $this->getDoc(), $annotations, PREG_SET_ORDER);
        return $annotations;
    }

}
