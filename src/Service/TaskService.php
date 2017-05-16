<?php

namespace App\Service;

use App\Model\TaskEntityInterface;
use App\Model\TaskGatewayInterface;

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
    public function getAllTasks(): \Iterator
    {
        return $this->taskGateway->fetchAll();
    }

    /**
     * Adds a new task to the back-end
     *
     * @param TaskEntityInterface $taskEntity
     * @return TaskEntityInterface
     * @throws \InvalidArgumentException
     */
    public function addTask(TaskEntityInterface $taskEntity): TaskEntityInterface
    {
        if (!$this->taskGateway->add($taskEntity)) {
            throw new \InvalidArgumentException('Wrong task added');
        }
        return $taskEntity;
    }
}