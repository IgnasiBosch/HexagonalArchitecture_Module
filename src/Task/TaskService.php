<?php

namespace Hexagonal\Task;


use Illuminate\Support\Collection;
use Hexagonal\Common\ValidationException;
use Hexagonal\Common\Validator;

class TaskService
{
    /** @var  TaskRepository */
    private $repository;

    /** @var Validator */
    private $validator;

    /**
     * @param TaskRepository $repository
     * @param Validator $validator
     */
    public function __construct(TaskRepository $repository, Validator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * @return Collection
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param $id
     * @return Collection
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param $description
     * @return mixed
     */
    public function findLikeDescription($description)
    {
        return $this->repository->findLikeDescription($description);
    }

    /**
     * @param Task $task
     * @return mixed
     */
    public function save(Task $task)
    {
        return $this->repository->save($task);
    }

    /**
     * @param Task $task
     * @return mixed
     */
    public function update(Task $task)
    {
        return $this->repository->update($task);
    }

    /**
     * @param array $assoc
     * @return mixed
     * @throws ValidationException
     */
    public function saveFromAssoc(array $assoc)
    {
        if (!$this->validator->isValidFromAssoc($assoc)) {
            throw new ValidationException($this->validator);
        }

        $task = TaskFactory::createFromAssoc($assoc);
        return $this->repository->save($task);
    }

    /**
     * @param array $assoc
     * @return mixed
     * @throws ValidationException
     */
    public function updateFromAssoc(array $assoc)
    {
        if (!$this->validator->isValidFromAssoc($assoc)) {
            throw new ValidationException($this->validator);
        }

        $task = TaskFactory::createFromAssoc($assoc);
        return $this->repository->update($task);
    }
}