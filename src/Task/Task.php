<?php

namespace Hexagonal\Task;


class Task
{
    /**
     * @var string
     */
    private $description;
    
    /**
     * @var null
     */
    private $id;

    /**
     * Task constructor.
     * @param string $description
     * @param null $id
     */
    public function __construct(string $description, $id = null)
    {
        $this->description = $description;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * @return null|mixed
     */
    public function getId()
    {
        return $this->id;
    }

}