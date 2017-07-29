<?php

namespace Hexagonal\Task;


use Hexagonal\Common\FactoryException;
use Hexagonal\Common\IntegrityConstraintException;
use Hexagonal\Common\NotFoundException;
use Illuminate\Support\Collection;

class TaskRepository
{
    private $gateway;

    /**
     * ReleaseRepository constructor.
     * @param TaskGatewayInterface $gateway
     */
    public function __construct(TaskGatewayInterface $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * @return Collection
     */
    public function findAll()
    {
        return $this->gateway->findAll();
    }

    /**
     * @param $id
     * @return Task
     */
    public function find($id)
    {
        return $this->gateway->find($id);
    }

    /**
     * @param $description
     * @return Task
     * @throws NotFoundException
     */
    public function findLikeDescription($description)
    {
        return $this->gateway->findLikeDescription($description);
    }

    /**
     * @param Task $task
     * @return bool
     * @throws IntegrityConstraintException
     */
    public function save(Task $task)
    {
        if (!$this->find($task->getId())) {
            return $this->gateway->save($task);
        }
        throw new IntegrityConstraintException('Task already exists');
    }

    /**
     * @param Task $task
     * @return bool
     * @throws NotFoundException
     */
    public function update(Task $task)
    {
        return $this->gateway->update($task);
    }
}