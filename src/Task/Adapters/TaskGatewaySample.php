<?php

namespace Hexagonal\Task\Adapters;


use App\Task as EloquentTask;
use Hexagonal\Common\NotFoundException;
use Hexagonal\Task\Task;
use Hexagonal\Task\TaskFactory;
use Hexagonal\Task\TaskGatewayInterface;

class TaskGatewaySample implements TaskGatewayInterface
{

    /**
     * @return \Illuminate\Support\Collection
     * @throws \Hexagonal\Common\FactoryException
     */
    public function findAll()
    {
        return TaskFactory::createAllFromAttributes(EloquentTask::all());
    }

    /**
     * @param $id
     * @return Task
     * @throws \Hexagonal\Common\FactoryException
     */
    public function find($id)
    {
        return TaskFactory::createFromAttributes(EloquentTask::find($id));
    }

    /**
     * @param string $description
     * @return Task
     * @throws NotFoundException
     */
    public function findLikeDescription($description)
    {
        return TaskFactory::createAllFromAttributes(EloquentTask::where('description', 'LIKE', '%' . $description . '%')->get());
    }

    /**
     * @param Task $task
     * @return bool
     */
    public function save(Task $task)
    {
        $eloquentTask = (new EloquentTask([
            'description' => $task->getDescription()
        ]));

        return $eloquentTask->save();
    }
    
    /**
     * @param Task $task
     * @return mixed
     */
    public function update(Task $task)
    {
        /** @var EloquentTask $eloquentTask */
        $eloquentTask = EloquentTask::find($task->getId());
        $eloquentTask->description = $task->getDescription();

        return $eloquentTask->save();
    }
    
}