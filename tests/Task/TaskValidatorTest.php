<?php


use Hexagonal\Task\Adapters\TaskValitronValidator;

class TaskValidatorTest extends \PHPUnit_Framework_TestCase
{

    /** @var  TaskValitronValidator $validator */
    private $validator;

    public function setUp()
    {
        $this->validator = new TaskValitronValidator;
    }

    public function testNoValues()
    {
        $values = [];
        $this->assertFalse($this->validator->isValidFromAssoc($values));
        $expected = [
            'description' => ['Description is required'],
        ];
        $this->assertEquals($expected, $this->validator->getErrors());
    }
    
    public function testValidValues()
    {
        $values = ['description' => 'testDescription'];
        $this->assertTrue($this->validator->isValidFromAssoc($values));
        $this->assertEquals([], $this->validator->getErrors());
    }

    public function testInvalidValues()
    {
        $values = ['description' => ''];
        $this->assertFalse($this->validator->isValidFromAssoc($values));
        $this->assertEquals(['description' => ['Description is required']], $this->validator->getErrors());
    }

}
