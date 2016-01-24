<?php

class AnnotatorTest extends PHPUnit_Framework_TestCase
{

	public function testEmptyAnnotation()
	{
		$annotator = new Codeburner\Annotator\Reflection\ReflectionAnnotatedMethod($this, 'dummyAnnotatedMethod');
		$this->assertTrue($annotator->hasAnnotation('testEmptyAnnotation'));
	}

	public function testSimpleAnnotation()
	{
		$annotator = new Codeburner\Annotator\Reflection\ReflectionAnnotatedMethod($this, 'dummyAnnotatedMethod');
		$this->assertTrue($annotator->hasAnnotation('testAnnotation'));
		$this->assertEquals($annotator->getAnnotation('testAnnotation')->getArguments(), 'test');
	}

	public function testComplexAnnotation()
	{
		$annotator = new Codeburner\Annotator\Reflection\ReflectionAnnotatedMethod($this, 'dummyAnnotatedMethod');
		$this->assertTrue($annotator->hasAnnotation('testComplexAnnotation'));
		$this->assertTrue($annotator->getAnnotation('testComplexAnnotation')->getArguments() === ['test' => 'test', 'deep' => [1,2]]);
	}

	/**
	 * @testEmptyAnnotation
	 * @testAnnotation test
	 * @testComplexAnnotation {"test": "test", "deep": [1, 2]}
	 */

	public function dummyAnnotatedMethod()
	{
		//
	}

}
