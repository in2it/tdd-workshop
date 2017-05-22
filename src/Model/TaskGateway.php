<?php
declare(strict_types=1);

namespace App\Model;


class TaskGateway implements TaskGatewayInterface
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * TaskGateway constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @inheritDoc
     */
    public function fetchAll(): \Iterator
    {
        $stmt = $this->pdo->query('SELECT * FROM `task`');

        $store = new \SplObjectStorage();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($result as $entry) {
            $store->attach(new TaskEntity(
                $entry['id'],
                $entry['label'],
                $entry['description'],
                $entry['done']
            ));
        }
        return $store;
    }

    /**
     * @inheritDoc
     */
    public function add(TaskEntityInterface $taskEntity): bool
    {
        $date = new \DateTime();
        $data = [
            'id' => $taskEntity->getId(),
            'label' => $taskEntity->getLabel(),
            'description' => $taskEntity->getDescription(),
            'done' => $taskEntity->isDone(),
            'created' => $date->format('Y-m-d H:i:s'),
            'modified' => $date->format('Y-m-d H:i:s'),
        ];
        $stmt = $this->pdo->prepare('INSERT INTO `task` VALUES (?, ?, ?, ?, ?, ?)');
        return $stmt->execute(array_values($data));
    }

    /**
     * @inheritDoc
     */
    public function find(string $taskId): ?TaskEntityInterface
    {
        $stmt = $this->pdo->prepare('SELECT * FROM `task` WHERE `id` = ?');
        $stmt->execute([$taskId]);
        if (false === ($data = $stmt->fetch(\PDO::FETCH_ASSOC))) {
            return null;
        }
        return new TaskEntity(
            $data['id'],
            $data['label'],
            $data['description'],
            $data['done']
        );
    }

    /**
     * @inheritDoc
     */
    public function remove(TaskEntityInterface $taskEntity): bool
    {
        $stmt = $this->pdo->prepare('DELETE * FROM `task` WHERE `id` = ?');
        return $stmt->execute([$taskEntity->getId()]);
    }

    /**
     * @inheritDoc
     */
    public function update(TaskEntityInterface $taskEntity): bool
    {
        $date = new \DateTime();
        $data = [
            'label' => $taskEntity->getLabel(),
            'description' => $taskEntity->getDescription(),
            'done' => $taskEntity->isDone(),
            'modified' => $date->format('Y-m-d H:i:s'),
            'id' => $taskEntity->getId(),
        ];
        $stmt = $this->pdo->prepare('UPDATE `task` SET `label` = ?, `description` = ?, `done` = ?, `modified` = ? WHERE `id` = ?');
        return $stmt->execute(array_values($data));
    }

}