<?php
require_once (dirname(__FILE__) . '/../../../../QtiSmTestCase.php');

use qtism\common\datatypes\QtiBoolean;
use qtism\common\datatypes\QtiFloat;
use qtism\common\datatypes\QtiString;
use qtism\common\datatypes\QtiPoint;
use qtism\runtime\expressions\operators\OrProcessor;
use qtism\runtime\expressions\operators\OperandsCollection;
use qtism\common\enums\BaseType;
use qtism\runtime\common\MultipleContainer;
use qtism\runtime\common\RecordContainer;

class OrProcessorTest extends QtiSmTestCase {
	
	public function testNotEnoughOperands	() {
		$expression = $this->createFakeExpression();
		$operands = new OperandsCollection();
		$this->setExpectedException('qtism\\runtime\\expressions\\ExpressionProcessingException');
		$processor = new OrProcessor($expression, $operands);
		$result = $processor->process();
	}
	
	public function testWrongBaseType() {
		$expression = $this->createFakeExpression();
		$operands = new OperandsCollection(array(new QtiPoint(1, 2)));
		$processor = new OrProcessor($expression, $operands);
		$this->setExpectedException('qtism\\runtime\\expressions\\ExpressionProcessingException');
		$result = $processor->process();
	}
	
	public function testWrongCardinalityOne() {
		$expression = $this->createFakeExpression();
		$operands = new OperandsCollection(array(new RecordContainer(array('a' => new QtiString('string!')))));
		$processor = new OrProcessor($expression, $operands);
		$this->setExpectedException('qtism\\runtime\\expressions\\ExpressionProcessingException');
		$result = $processor->process();
	}
	
	public function testWrongCardinalityTwo() {
		$expression = $this->createFakeExpression();
		$operands = new OperandsCollection(array(new MultipleContainer(BaseType::FLOAT, array(new QtiFloat(25.0)))));
		$processor = new OrProcessor($expression, $operands);
		$this->setExpectedException('qtism\\runtime\\expressions\\ExpressionProcessingException');
		$result = $processor->process();
	}
	
	public function testNullOperands() {
	    $expression = $this->createFakeExpression();
	    
	    // As per specs, If one or more sub-expressions are NULL and all the others 
	    // are false then the operator also results in NULL.
	    $operands = new OperandsCollection(array(new QtiBoolean(false), null));
	    $processor = new OrProcessor($expression, $operands);
	    $result = $processor->process();
	    $this->assertSame(null, $result);
	    
	    $operands = new OperandsCollection(array(new QtiBoolean(false), null, new QtiBoolean(false)));
	    $processor->setOperands($operands);
	    $result = $processor->process();
	    $this->assertSame(null, $result);
	    
	    // On the other hand...
	    $operands = new OperandsCollection(array(new QtiBoolean(false), null, new QtiBoolean(true)));
	    $processor->setOperands($operands);
	    $result = $processor->process();
	    $this->assertTrue($result->getValue());
	}
	
	public function testTrue() {
		$expression = $this->createFakeExpression();
		$operands = new OperandsCollection(array(new QtiBoolean(true)));
		$processor = new OrProcessor($expression, $operands);
		$result = $processor->process();
		$this->assertInstanceOf(QtiBoolean::class, $result);
		$this->assertSame(true, $result->getValue());
		
		$operands = new OperandsCollection(array(new QtiBoolean(false), new QtiBoolean(true), new QtiBoolean(false)));
		$processor->setOperands($operands);
		$result = $processor->process();
		$this->assertInstanceOf(QtiBoolean::class, $result);
		$this->assertSame(true, $result->getValue());
	}
	
	public function testFalse() {
		$expression = $this->createFakeExpression();
		$operands = new OperandsCollection(array(new QtiBoolean(false)));
		$processor = new OrProcessor($expression, $operands);
		$result = $processor->process();
		$this->assertInstanceOf(QtiBoolean::class, $result);
		$this->assertSame(false, $result->getValue());
		
		$operands = new OperandsCollection(array(new QtiBoolean(false), new QtiBoolean(false), new QtiBoolean(false)));
		$processor->setOperands($operands);
		$result = $processor->process();
		$this->assertInstanceOf(QtiBoolean::class, $result);
		$this->assertSame(false, $result->getValue());
	}
	
	public function createFakeExpression() {
		return $this->createComponentFromXml('
			<or>
				<baseValue baseType="boolean">false</baseValue>
			</or>
		');
	}
}
