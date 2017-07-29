<?php


use Hexagonal\Task\Adapters\TaskGatewaySample;
use Hexagonal\Task\Adapters\TaskValitronValidator;
use Hexagonal\Task\Task;
use Hexagonal\Task\TaskGatewayInterface;
use Hexagonal\Task\TaskRepository;
use Hexagonal\Task\TaskService;

class TaskGatewayAdapterTest extends \PHPUnit_Framework_TestCase
{
    /** @var TaskGatewayInterface $gatewayMocked */
    private $gatewayMocked;

    /** @var  TaskValitronValidator $validatorMocked */
    private $validatorMocked;

    /** @var TaskService $taskService */
    private $taskService;

    public function setUp()
    {
        $this->gatewayMocked = $this->getMockBuilder(TaskGatewaySample::class)->getMock();
        $this->validatorMocked = $this->getMockBuilder(TaskValitronValidator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->validatorMocked->method('isValidFromAssoc')->willReturn(true);

        $repository = new TaskRepository($this->gatewayMocked);
        $this->taskService = new TaskService($repository, $this->validatorMocked);
    }

    public function testFind()
    {
        $this->gatewayMocked->expects($this->once())
            ->method('find')
            ->with($this->identicalTo(1));

        $this->taskService->find(1);
    }

    public function testFindAll()
    {
        $this->gatewayMocked->expects($this->once())
            ->method('findAll');

        $this->taskService->findAll();
    }

    public function testFindLikeDescription()
    {
        $this->gatewayMocked->expects($this->once())
            ->method('findLikeDescription')
            ->with($this->identicalTo('SomeDescription'));

        $this->taskService->findLikeDescription('SomeDescription');
    }

    public function testSave()
    {
        /** @var Task $taskMocked */
        $taskMocked = $this->getMockBuilder(Task::class)
            ->disableOriginalConstructor()
            ->getMock();

        $taskMocked->method('getId')
            ->willReturn(false);

        $this->gatewayMocked->expects($this->once())
            ->method('save')
            ->with($this->identicalTo($taskMocked));

        $this->taskService->save($taskMocked);
    }

    /**
     * @expectedException Hexagonal\Common\IntegrityConstraintException
     */
    public function testSaveFails()
    {
        /** @var Task $taskMocked */
        $taskMocked = $this->getMockBuilder(Task::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->gatewayMocked->expects($this->once())
            ->method('find')
            ->willReturn(1);

        $this->taskService->save($taskMocked);
    }

    public function testUpdate()
    {
        /** @var Task $taskMocked */
        $taskMocked = $this->getMockBuilder(Task::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->gatewayMocked->expects($this->once())
            ->method('update')
            ->with($this->identicalTo($taskMocked));

        $this->taskService->update($taskMocked);
    }

    public function testSaveFromAssoc()
    {
        $assocTask = ['description' => 'TestDescription'];
        $task = new Task('TestDescription');

        $this->gatewayMocked->expects($this->once())
            ->method('find')
            ->with($this->equalTo(null));

        $this->gatewayMocked->expects($this->once())
            ->method('save')
            ->with($this->equalTo($task));

        $this->taskService->saveFromAssoc($assocTask);
    }

    public function testUpdateFromAssoc()
    {
        $assocTask = ['id' => 10, 'description' => 'TestDescription'];
        $task = new Task('TestDescription', 10);

        $this->gatewayMocked->expects($this->once())
            ->method('update')
            ->with($this->equalTo($task));

        $this->taskService->updateFromAssoc($assocTask);
    }

    /**
     * @expectedException Hexagonal\Common\ValidationException
     */
    public function testUpdateFromAssocFails()
    {
        $gatewayMocked = $this->getMockBuilder(TaskGatewaySample::class)->getMock();
        $validatorMocked = $this->getMockBuilder(TaskValitronValidator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $validatorMocked->method('isValidFromAssoc')->willReturn(false);

        $repository = new TaskRepository($gatewayMocked);
        $taskService = new TaskService($repository, $validatorMocked);
        $taskService->updateFromAssoc([]);
    }

    /**
     * @expectedException Hexagonal\Common\ValidationException
     */
    public function testSaveFromAssocFails()
    {
        $gatewayMocked = $this->getMockBuilder(TaskGatewaySample::class)->getMock();
        $validatorMocked = $this->getMockBuilder(TaskValitronValidator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $validatorMocked->method('isValidFromAssoc')->willReturn(false);

        $repository = new TaskRepository($gatewayMocked);
        $taskService = new TaskService($repository, $validatorMocked);
        $taskService->saveFromAssoc([]);
    }
}
