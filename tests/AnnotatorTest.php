<?php

class AnnotatorTest extends PHPUnit_Framework_TestCase
{

	public function setUp()
	{
		$this->annotator = new Codeburner\Annotator\Reflection\ReflectionAnnotatedMethod($this, 'dummyAnnotatedMethod');
		parent::setUp();
	}

	public function testEmptyAnnotation()
	{
		$this->assertTrue($this->annotator->hasAnnotation('testEmptyAnnotation'));
	}

	public function testSimpleAnnotation()
	{
		$this->assertTrue($this->annotator->hasAnnotation('testAnnotation'));
		$this->assertEquals($this->annotator->getAnnotation('testAnnotation')->getArguments(), 'test');
	}

	public function testComplexAnnotation()
	{
		$this->assertTrue($this->annotator->hasAnnotation('testComplexAnnotation'));
		$this->assertTrue($this->annotator->getAnnotation('testComplexAnnotation')->getArguments() === ['test' => 'test', 'deep' => [1,2]]);
	}

	public function testAnnotationGroupingException()
	{
		$this->setExpectedException('Codeburner\Annotator\Exceptions\GroupingNotAllowedException');
		$this->annotator->getAnnotation('.*');
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
