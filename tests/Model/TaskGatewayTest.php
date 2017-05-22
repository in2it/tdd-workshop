<?php

namespace App\Test\Model;


use App\Model\TaskEntity;
use App\Model\TaskGateway;
use PHPUnit\Framework\TestCase;

class TaskGatewayTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $pdoMock;

    /**
     * @var array
     */
    protected $dataFixture;

    protected function setUp()
    {
        parent::setUp();
        $this->pdoMock = $this->getMockBuilder(\PDO::class)
            ->setConstructorArgs(['sqlite::memory:'])
            ->setMethods(['prepare', 'query', 'execute'])
            ->getMock();

        $this->dataFixture = [
            [
                'id' => '2340ee1c-499c-4c31-ac80-0da6f480a2bf',
                'label' => 'I am foo',
                'description' => 'This is a way to find your foo',
                'done' => false,
            ],
            [
                'id' => '8b005460-31c3-4c67-a098-9e5ec80ad3db',
                'label' => 'I am bar',
                'description' => 'This is a way to find your bar',
                'done' => true
            ],
        ];
    }

    /**
     * Test that we can fetch from the backend
     *
     * @covers TaskGateway::fetchAll
     */
    public function testFetchAllReturnsIteratorObject()
    {
        $pdoStmt = $this->getMockBuilder(\PDOStatement::class)
            ->setMethods(['fetchAll'])
            ->getMock();

        $pdoStmt->expects($this->once())
            ->method('fetchAll')
            ->willReturn($this->dataFixture);

        $this->pdoMock->expects($this->once())
            ->method('query')
            ->willReturn($pdoStmt);

        $taskGateway = new TaskGateway($this->pdoMock);
        $result = $taskGateway->fetchAll();

        $this->assertInstanceOf(\Iterator::class, $result);
        $this->assertSame(2, \iterator_count($result));
    }

    /**
     * Test that we can add a new task entity
     *
     * @covers TaskGateway::add
     */
    public function testGatewayCanAddTaskEntity()
    {
        $taskEntity = $this->getMockBuilder(TaskEntity::class)
            ->setMethods(['getId', 'getLabel', 'getDescription', 'isDone'])
            ->getMock();

        $taskEntity->expects($this->once())->method('getId')->willReturn('8b78b269-9876-4494-be1d-ed2c77ff0c26');
        $taskEntity->expects($this->once())->method('getLabel')->willReturn('This is a mock label');
        $taskEntity->expects($this->once())->method('getDescription')->willReturn('This is a mock description');
        $taskEntity->expects($this->once())->method('isDone')->willReturn(true);

        $pdoStmt = $this->getMockBuilder(\PDOStatement::class)
            ->setMethods(['execute'])
            ->getMock();

        $pdoStmt->expects($this->once())->method('execute')->willReturn(true);

        $this->pdoMock->expects($this->once())->method('prepare')->willReturn($pdoStmt);

        $taskGateway = new TaskGateway($this->pdoMock);
        $result = $taskGateway->add($taskEntity);

        $this->assertTrue($result);
    }

    /**
     * Test we receive a null value when no data is found in the
     * TaskGateway back-end
     *
     * @covers TaskGateway::find
     */
    public function testFindReturnsNullWhenNothingFound()
    {
        $pdoStmt = $this->getMockBuilder(\PDOStatement::class)
            ->setMethods(['execute', 'fetch'])
            ->getMock();

        $pdoStmt->expects($this->once())->method('fetch')->willReturn(false);
        $this->pdoMock->expects($this->once())->method('prepare')->willReturn($pdoStmt);

        $taskGateway = new TaskGateway($this->pdoMock);
        $this->assertNull($taskGateway->find('abc-123'));
    }

    /**
     * Test we receive a null value when no data is found in the
     * TaskGateway back-end
     *
     * @covers TaskGateway::find
     */
    public function testFindReturnsTaskEntityWhenResultIsFound()
    {
        $data = [
            'id' => '8b78b269-9876-4494-be1d-ed2c77ff0c26',
            'label' => 'This is a fixture label',
            'description' => 'This is a fixture description',
            'done' => true,
        ];
        $pdoStmt = $this->getMockBuilder(\PDOStatement::class)
            ->setMethods(['execute', 'fetch'])
            ->getMock();

        $pdoStmt->expects($this->once())->method('fetch')->willReturn($data);
        $this->pdoMock->expects($this->once())->method('prepare')->willReturn($pdoStmt);

        $taskGateway = new TaskGateway($this->pdoMock);
        $result = $taskGateway->find($data['id']);

        $this->assertInstanceOf(TaskEntity::class, $result);
        $this->assertSame($data['id'], $result->getId());
        $this->assertSame($data['label'], $result->getLabel());
        $this->assertSame($data['description'], $result->getDescription());
        $this->assertSame($data['done'], $result->isDone());
    }



    /**
     * Test that we can remove an existing task entity
     *
     * @covers TaskGateway::remove
     */
    public function testGatewayCanRemoveTaskEntity()
    {
        $taskEntity = $this->getMockBuilder(TaskEntity::class)
            ->setMethods(['getId'])
            ->getMock();

        $taskEntity->expects($this->once())
            ->method('getId')
            ->willReturn('8b78b269-9876-4494-be1d-ed2c77ff0c26');

        $pdoStmt = $this->getMockBuilder(\PDOStatement::class)
            ->setMethods(['execute'])
            ->getMock();

        $pdoStmt->expects($this->once())->method('execute')->willReturn(true);

        $this->pdoMock->expects($this->once())->method('prepare')->willReturn($pdoStmt);

        $taskGateway = new TaskGateway($this->pdoMock);
        $result = $taskGateway->remove($taskEntity);

        $this->assertTrue($result);
    }

    /**
     * Test that we can update an existing task entity
     *
     * @covers TaskGateway::update
     */
    public function testGatewayCanUpdateTaskEntity()
    {
        $taskEntity = $this->getMockBuilder(TaskEntity::class)
            ->setMethods(['getId', 'getLabel', 'getDescription', 'isDone'])
            ->getMock();

        $taskEntity->expects($this->once())->method('getId')->willReturn('8b78b269-9876-4494-be1d-ed2c77ff0c26');
        $taskEntity->expects($this->once())->method('getLabel')->willReturn('This is a mock label');
        $taskEntity->expects($this->once())->method('getDescription')->willReturn('This is a mock description');
        $taskEntity->expects($this->once())->method('isDone')->willReturn(true);

        $pdoStmt = $this->getMockBuilder(\PDOStatement::class)
            ->setMethods(['execute'])
            ->getMock();

        $pdoStmt->expects($this->once())->method('execute')->willReturn(true);

        $this->pdoMock->expects($this->once())->method('prepare')->willReturn($pdoStmt);

        $taskGateway = new TaskGateway($this->pdoMock);
        $result = $taskGateway->add($taskEntity);

        $this->assertTrue($result);
    }
}