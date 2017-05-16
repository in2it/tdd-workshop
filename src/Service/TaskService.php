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

    /**
     * Find a task by given task ID
     *
     * @param string $taskId
     * @return TaskEntityInterface
     * @throws \InvalidArgumentException
     */
    public function findTask(string $taskId): TaskEntityInterface
    {
        $result = $this->taskGateway->find($taskId);
        if (null === $result) {
            throw new \InvalidArgumentException('Cannot find task with ID ' . $taskId);
        }
        return $result;
    }

    /**
     * Remove a task by given task entity
     *
     * @param TaskEntityInterface $taskEntity
     * @return bool
     */
    public function removeTask(TaskEntityInterface $taskEntity): bool
    {
        $result = $this->taskGateway->remove($taskEntity);
        return $result;
    }

    /**
     * Update a task by given task entity
     *
     * @param TaskEntityInterface $taskEntity
     * @return bool
     */
    public function updateTask(TaskEntityInterface $taskEntity): bool
    {
        $result = $this->taskGateway->update($taskEntity);
        return $result;
    }

    /**
     * Mark a task as done by given task entity
     *
     * @param TaskEntityInterface $taskEntity
     * @return bool
     */
    public function markTaskDone(TaskEntityInterface $taskEntity): bool
    {
        $taskEntity->setDone(true);
        return $this->updateTask($taskEntity);
    }
}