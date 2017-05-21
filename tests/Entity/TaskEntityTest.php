<?php

namespace App\Test\Entity;


use App\Model\TaskEntity;
use App\Model\TaskEntityInterface;
use PHPUnit\Framework\TestCase;

class TaskEntityTest extends TestCase
{
    /**
     * Test to see that defaults are correctly set when instantiating
     * a new task entity.
     *
     * @covers TaskEntity::__construct
     */
    public function testTaskEntityIsEmptyAtConstruction()
    {
        $task = new TaskEntity();
        $this->assertInstanceOf(TaskEntityInterface::class, $task);
        $this->assertSame('', $task->getId());
        $this->assertSame('', $task->getLabel());
        $this->assertSame('', $task->getDescription());
        $this->assertFalse($task->isDone());
        $this->assertInstanceOf(\DateTime::class, $task->getCreated());
        $this->assertInstanceOf(\DateTime::class, $task->getModified());
    }
}