<?php


use Hexagonal\Task\Task;
use Hexagonal\Task\TaskFactory;

class TaskFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testMappingAllFromAttributes()
    {
        $resultSet = [];
        $rsTask1 = new stdClass;
        $rsTask1->id = 1;
        $rsTask1->description = 'Description1';
        $resultSet[] = $rsTask1;

        $rsTask2 = new stdClass;
        $rsTask2->id = 2;
        $rsTask2->description = 'Description2';
        $resultSet[] = $rsTask2;

        $tasks = TaskFactory::createAllFromAttributes($resultSet);

        /** @var Task $task1 */
        $task1 = $tasks->get(1);
        $this->assertEquals(1, $task1->getId());
        $this->assertEquals('Description1', $task1->getDescription());

        /** @var Task $task2 */
        $task2 = $tasks->get(2);
        $this->assertEquals(2, $task2->getId());
        $this->assertEquals('Description2', $task2->getDescription());
    }

    public function testMappingFromAttributes()
    {
        $rsTask = new stdClass;
        $rsTask->id = 1;
        $rsTask->description = 'Description';

        /** @var Task $task */
        $task = TaskFactory::createFromAttributes($rsTask);

        $this->assertEquals(1, $task->getId());
        $this->assertEquals('Description', $task->getDescription());
    }

    /**
     * @expectedException Hexagonal\Common\FactoryException
     */
    public function testMappingFromAttributesNoDescription()
    {
        $rsTask = new stdClass;
         TaskFactory::createFromAttributes($rsTask);
    }

    /**
     * @expectedException Hexagonal\Common\FactoryException
     */
    public function testMappingFromAssocNoDescription()
    {
        $assocTask = [];
        TaskFactory::createFromAssoc($assocTask);
    }

    public function testMappingFromAssoc()
    {
        $assocTask = ['id' => 1, 'description' => 'Description'];
        /** @var Task $task */
        $task = TaskFactory::createFromAssoc($assocTask);

        $this->assertEquals(1, $task->getId());
        $this->assertEquals('Description', $task->getDescription());
    }

}
