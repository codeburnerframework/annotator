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
use Codeburner\Annotator\Exceptions\WildcardNotAllowedException;

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

trait AnnotationTrait
{

	abstract public function getDocComment();
    abstract public function getNamespaceName();
    abstract public function getStartLine();

    /**
     * @var string
     */

    private $useStatementsCache;

    /**
     * Get an annotation by it literal name.
     * 
     * @param  Annotation|null
     * @throws MultipleAnnotationException
     * @return string
     */

    public function getAnnotation($name)
    {
        $annotations = $this->getMatchedAnnotations($name);

        if (empty($annotations)) {
            return null;
        }

        if (count($annotations) > 1) {
            throw new WildcardNotAllowedException("getAnnotation");
        }

        return $this->getAnnotationObject($annotations[0]);
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
               $annotations = $this->getMatchedAnnotations("[\w]+");
        } else $annotations = $this->getMatchedAnnotations(implode("|", $names));

        $bucket = [];

        foreach ($annotations as $annotation) {
            $bucket[$annotation[1]] = $this->getAnnotationObject($annotation);
        }

        return $bucket;
    }
    
    /**
     * Check if an annotation exists
     *
     * @return bool
     */

    public function hasAnnotation($name)
    {
        return (bool) preg_match("~@" . $this->getAnnotationName($name) . "~", $this->getDocComment());
    }

    /**
     * Find all annotations that the name match the $pattern
     *
     * @return array
     */

    protected function getMatchedAnnotations($pattern)
    {
        preg_match_all("~@(" . $this->getAnnotationName($pattern) . ")(\s(-f\s?)?(.*))?~i", $this->getDocComment(), $annotations, PREG_SET_ORDER);
        return (array) $annotations;
    }

    /**
     * Instantiate a new Annotation object, if the annotation has a specific object
     * then resolve the name and create it.
     *
     * @param array $annotation The getMatchedAnnotation annotation return.
     * @return Annotation
     */

    protected function getAnnotationObject($annotation)
    {
        $name = $annotation[1];
        $value = $annotation[4];
        $flag = $annotation[3];

        if (trim($flag) === "-f") {
            $uses = $this->getUseStatements();

            if (!isset($uses[$name])) {
                   $class = $this->getNamespaceName() . "\\$name";
                   return new $class($name, $value);
            } else return new $uses[$name]($name, $value);
        }

        return new Annotation($name, $value);
    }

    /**
     * Get all use statements from the annotated reflection file.
     *
     * @return array
     */

    protected function getUseStatements()
    {
        if ($this->useStatementsCache) {
            return $this->useStatementsCache;
        }

        preg_match_all("~use\s([\w\\\\]+)(\sas\s(\w+))?;~i", $this->getClassFileHeader(), $matches, PREG_SET_ORDER);

        foreach ((array) $matches as $match) {
            // if an alias exists.
            if (isset($match[3])) {
                $this->useStatementsCache[$match[3]] = $match[1];
            }

            $this->useStatementsCache[$match[1]] = $match[1];
        }

        return $this->useStatementsCache;
    }

    /**
     * Get a fraction of the annotated reflection file.
     *
     * @return string
     */

    private function getClassFileHeader()
    {
        $file   = fopen($this->getFileName(), "r");
        $until  = $this->getStartLine();
        $line   = 0;
        $source = "";

        while ($line < $until) {
            $source .= fgets($file);
            ++$line;
        }

        fclose($file);
        return $source;
    }

    /**
     * Resolve annotation name.
     *
     * @return string
     */

    private function getAnnotationName($name)
    {
        // if it is a pattern like [\w]+
        if ($name[0] === "[") {
            return $name;
        }

        return str_replace("\\", "\\\\", $name);
    }

}
