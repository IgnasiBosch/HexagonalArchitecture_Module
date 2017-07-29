<?php

namespace Hexagonal\Task;

use Hexagonal\Common\EmailAddress;
use Hexagonal\Common\FactoryException;
use Illuminate\Support\Collection;

class TaskFactory
{
    /**
     * @param $tasks
     * @return Collection
     */
    static public function createAllFromAttributes($tasks)
    {
        $result = [];
        foreach ($tasks as $task) {
            $result[$task->id] = static::createFromAttributes($task);
        }

        return new Collection($result);
    }


    /**
     * @param $task
     * @return Task
     * @throws FactoryException
     */
    static public function createFromAttributes($task)
    {
        try {
            return new Task($task->description, $task->id);
        } catch (\Exception $exc) {
            throw new FactoryException($exc->getMessage());
        }
    }

    /**
     * @param array $assoc
     * @return Task
     * @throws FactoryException
     */
    static public function createFromAssoc(array $assoc)
    {
        try {
            return new Task(
                $assoc['description'],
                isset($assoc['id']) ? $assoc['id'] : null);
        } catch (\Exception $exc) {
            throw new FactoryException($exc->getMessage());
        }
    }
}