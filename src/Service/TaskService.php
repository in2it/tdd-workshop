<?php

namespace App\Service;


class TaskService
{
    /**
     * @var TaskGatewayInterface
     */
    protected $taskGateway;

    /**
     * TaskService constructor.
     * @param TaskGatewayInterface $taskGateway
     */
    public function __construct(TaskGatewayInterface $taskGateway)
    {
        $this->taskGateway = $taskGateway;
    }

    /**
     * Retrieve all tasks from the back-end
     *
     * @return \Iterator
     */
    public function getAllTasks()
    {
        return $this->taskGateway->fetchAll();
    }

}