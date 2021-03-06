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

if (!trait_exists('Codeburner\Annotator\Reflection\AnnotationTrait', false)) {
    include __DIR__ . '/AnnotationTrait.php';
}

/**
 * Implements the annotation methods into the reflection.
 *
 * @author Alex Rohleder <contato@alexrohleder.com.br>
 */

class ReflectionAnnotatedProperty extends \ReflectionProperty
{
    use AnnotationTrait;

    /**
     * @return string
     */

    public function getNamespaceName()
    {
        return $this->class->getNamespaceName();
    }

    /**
     * Get the property class start line.
     *
     * @return int
     */

    public function getStartLine()
    {
        return $this->class->getStartLine();
    }

}
