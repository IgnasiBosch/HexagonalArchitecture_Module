<?php

namespace Hexagonal\Task;


interface TaskGatewayInterface
{
    public function findAll();
    
    public function find($id);

    public function findLikeDescription($name);

    public function save(Task $task);

    public function update(Task $task);
}