<?php

namespace App\Test\Service;


use PHPUnit\Framework\TestCase;

/**
 * Class TaskServiceTest
 *
 * @package App\Test\Service
 * @group Service
 */
class TaskServiceTest extends TestCase
{
    public function testServiceReturnsListOfTasks()
    {
        // List open tasks sorted newest to oldest
    }

    public function testServiceCanAddNewTask()
    {
        // Create a new task (label and description)
    }

    public function testServiceCanUpdateExistingTask()
    {
        // Update an existing task
    }

    public function testServiceCanMarkTaskAsDone()
    {
        // Mark task as done in the overview list
    }

    public function testServiceCanRemoveTaskMarkedAsDone()
    {
        // Remove task marked as done
    }

    public function testServiceWillThrowRuntimeExceptionWhenStorageFailsToFetchTaskList()
    {
        // Throw a runtime exception when connection to storage fails for fetching task list
    }

    public function testServiceWillThrowInvalidArgumentExceptionWhenInvalidTaskIsAdded()
    {
        // Throw an invalid argument exception for invalid task when adding
    }

    public function testServiceWillThrowRuntimeExceptionWhenStorageFails()
    {
        // Throw a runtime exception when storage of task fails
    }

    public function testServiceWillThrowDomainExceptionWhenTaskWasMarkedAsDoneWhenMarkingTaskAsDone()
    {
        // Throw a domain exception when a task was already marked as done
    }
}