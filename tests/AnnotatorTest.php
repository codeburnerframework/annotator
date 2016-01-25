<?php

use MyDeclaredAnnotation as DeclaredAnnotation;
use Codeburner\Annotator\Reflection\ReflectionAnnotatedMethod;
use Codeburner\Annotator\Annotation;

class MyDeclaredAnnotation extends Annotation
{
	protected function filter()
	{
		// $this->parameters
	}
}

class AnnotatorTest extends PHPUnit_Framework_TestCase
{

	public function setUp()
	{
		$this->annotator = new ReflectionAnnotatedMethod($this, 'dummyAnnotatedMethod');
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

	public function testAnnotationWildcardException()
	{
		$this->setExpectedException('Codeburner\Annotator\Exceptions\WildcardNotAllowedException');
		$this->annotator->getAnnotation('.*');
	}

	public function testAnnotationClass()
	{
		$this->assertTrue($this->annotator->hasAnnotation('DeclaredAnnotation'));
		$this->assertInstanceOf('MyDeclaredAnnotation', $this->annotator->getAnnotation('MyDeclaredAnnotation'));
	}

	public function testAnnotationAliasClass()
	{
		$this->assertTrue($this->annotator->hasAnnotation('DeclaredAnnotation'));
		$this->assertInstanceOf('MyDeclaredAnnotation', $this->annotator->getAnnotation('DeclaredAnnotation'));
	}

	/**
	 * @testEmptyAnnotation
	 * @testAnnotation test
	 * @testComplexAnnotation {"test": "test", "deep": [1, 2]}
	 * @MyDeclaredAnnotation -f
	 * @DeclaredAnnotation -f
	 */

	public function dummyAnnotatedMethod()
	{
		//
	}

}
