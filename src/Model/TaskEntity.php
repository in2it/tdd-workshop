<?php
declare(strict_types=1);

namespace App\Model;


class TaskEntity implements TaskEntityInterface
{
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $label;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var bool
     */
    protected $done;
    /**
     * @var \DateTime
     */
    protected $created;
    /**
     * @var \DateTime
     */
    protected $modified;

    /**
     * TaskEntity constructor.
     *
     * @param string $id
     * @param string $label
     * @param string $description
     * @param bool $done
     */
    public function __construct($id = '', $label = '', $description = '', $done = false)
    {
        if ('' !== $id) {
            $this->setId($id);
        }
        if ('' !== $label) {
            $this->setLabel($label);
        }
        if ('' !== $description) {
            $this->setDescription($description);
        }
        $this->setDone($done);
    }

    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        if (null === $this->id) {
            $this->id = '';
        }
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getLabel(): string
    {
        if (null === $this->label) {
            $this->label = '';
        }
        return $this->label;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        if (null === $this->description) {
            $this->description = '';
        }
        return $this->description;
    }

    /**
     * @inheritDoc
     */
    public function isDone(): bool
    {
        if (null === $this->done) {
            $this->done = false;
        }
        return $this->done;
    }

    /**
     * @inheritDoc
     */
    public function getCreated(): \DateTime
    {
        if (null === $this->created) {
            $this->created = new \DateTime();
        }
        return $this->created;
    }

    /**
     * @inheritDoc
     */
    public function getModified(): \DateTime
    {
        if (null === $this->modified) {
            $this->modified = new \DateTime();
        }
        return $this->modified;
    }

    /**
     * @param string $id
     * @return TaskEntity
     */
    public function setId(string $id): TaskEntity
    {
        if (false === ($id = filter_var($id, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH))) {
            throw new \InvalidArgumentException('Expecting an UUID identifier here');
        }
        if (1 !== (preg_match('/^([a-z0-9]{8})\-([a-z0-9]{4})\-([a-z0-9]{4})\-([a-z0-9]{4})\-([a-z0-9]{12})$/', $id))) {
            throw new \InvalidArgumentException('Expecting an UUID identifier here');
        }
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $label
     * @return TaskEntity
     */
    public function setLabel(string $label): TaskEntity
    {
        if (false === ($label = filter_var($label, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH))) {
            throw new \InvalidArgumentException('Expecting a string representing a label');
        }
        if (1 !== preg_match('/^([a-zA-Z]).*$/', $label)) {
            throw new \InvalidArgumentException('Label must begin with a letter');
        }
        $this->label = (string) $label;
        return $this;
    }

    /**
     * @param string $description
     * @return TaskEntity
     */
    public function setDescription(string $description): TaskEntity
    {
        if (false === ($description = filter_var($description, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH))) {
            throw new \InvalidArgumentException('Expecting a string representing a description');
        }
        if (1 !== preg_match('/^([a-zA-Z]).*$/', $description)) {
            throw new \InvalidArgumentException('Description must begin with a letter');
        }
        $this->description = $description;
        return $this;
    }

    /**
     * @param bool $done
     * @return TaskEntity
     */
    public function setDone(bool $done): TaskEntity
    {
        if (null === ($done = filter_var($done, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))) {
            throw new \InvalidArgumentException('Expecting a TRUE or FALSE');
        }
        if (!is_bool($done)) {
            throw new \InvalidArgumentException('Expecting a TRUE or FALSE');
        }
        $this->done = $done;
        return $this;
    }

    /**
     * @param \DateTime $created
     * @return TaskEntity
     */
    public function setCreated(\DateTime $created): TaskEntity
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @param \DateTime $modified
     * @return TaskEntity
     */
    public function setModified(\DateTime $modified): TaskEntity
    {
        $this->modified = $modified;
        return $this;
    }

}