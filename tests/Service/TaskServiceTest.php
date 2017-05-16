<?php

namespace App\Test\Service;


use App\Service\TaskService;
use PHPUnit\Framework\TestCase;

/**
 * Class TaskServiceTest
 *
 * @package App\Test\Service
 * @group Service
 */
class TaskServiceTest extends TestCase
{
    /**
     * @var TaskGateway
     */
    protected $taskGateway;

    protected function setUp()
    {
        parent::setUp();

        // We create a mock object
        $taskEntity = $this->getMockBuilder('App\Entity\TaskEntity')
            ->setMethods(['getId', 'getLabel', 'getDescription', 'isDone', 'getCreated', 'getModified'])
            ->getMock();

        $taskEntry1 = clone $taskEntity;
        $taskEntry1->method('getId')->willReturn('123');
        $taskEntry1->method('getLabel')->willReturn('Task #123');
        $taskEntry1->method('getDescription')->willReturn('#123: This is task 123');
        $taskEntry1->method('isDone')->willReturn(false);
        $taskEntry1->method('getCreated')->willReturn(new \DateTime('2017-03-21 07:53:24'));
        $taskEntry1->method('getModified')->willReturn(new \DateTime('2017-03-21 08:16:53'));

        $taskEntry2 = clone $taskEntity;
        $taskEntry2->method('getId')->willReturn('456');
        $taskEntry2->method('getLabel')->willReturn('Task #456');
        $taskEntry2->method('getDescription')->willReturn('#456: This is task 456');
        $taskEntry2->method('isDone')->willReturn(true);
        $taskEntry2->method('getCreated')->willReturn(new \DateTime('2017-03-22 07:53:24'));
        $taskEntry2->method('getModified')->willReturn(new \DateTime('2017-03-22 08:16:53'));

        $taskEntry3 = clone $taskEntity;
        $taskEntry3->method('getId')->willReturn('789');
        $taskEntry3->method('getLabel')->willReturn('Task #789');
        $taskEntry3->method('getDescription')->willReturn('#789: This is task 789');
        $taskEntry3->method('isDone')->willReturn(false);
        $taskEntry3->method('getCreated')->willReturn(new \DateTime('2017-04-23 07:53:24'));
        $taskEntry3->method('getModified')->willReturn(new \DateTime('2017-04-23 08:16:53'));

        $taskCollection = new \SplObjectStorage();
        $taskCollection->attach($taskEntry1);
        $taskCollection->attach($taskEntry2);
        $taskCollection->attach($taskEntry3);

        $taskGateway = $this->getMockBuilder('App\Model\TaskGateway')
            ->setMethods(['getAllTasks'])
            ->getMock();

        $taskGateway->expects($this->any())
            ->method('getAllTasks')
            ->willReturn($taskCollection);

        $this->taskGateway = $taskGateway;
    }

    protected function tearDown()
    {
        unset ($this->taskGateway);
    }

    /**
     * List open tasks sorted newest to oldest
     *
     * @covers TaskService::fetchAll
     */
    public function testServiceReturnsListOfTasks()
    {
        $taskService = new TaskService($this->taskGateway);
        $taskList = $taskService->getAllTasks();

        $this->assertInstanceOf(\Iterator::class, $taskList);
        $this->assertGreaterThan(0, count($taskList));
        $taskList->rewind();
        $previous = null;
        while ($taskList->valid()) {
            if (null !== $previous) {
                $current = $taskList->current();
                $this->assertTrue($previous->getCreated() > $current->getCreated());
            }
            $previous = $taskList->current();
            $taskList->next();
        }
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