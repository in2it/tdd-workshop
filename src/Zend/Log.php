<?php
class Zend_Log
{
    const DEBUG = 7;
    const INFO = 6;
    const WARN = 5;
    const CRIT = 1;

    /**
     * @var Zend_Log_Writer_Abstract
     */
    protected $_writer;
    /**
     * @var int The priority for the logger
     */
    protected $_priority;

    /**
     * @return Zend_Log_Writer_Abstract
     */
    public function getWriter()
    {
        if (null === $this->_writer) {
            throw new DomainException('Log writer not set yet');
        }
        return $this->_writer;
    }

    /**
     * @param Zend_Log_Writer_Abstract $writer
     */
    public function setWriter($writer)
    {
        $this->_writer = $writer;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        if (null === $this->_priority) {
            $this->setPriority(self::INFO);
        }
        return $this->_priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority($priority)
    {
        $this->_priority = $priority;
    }

    public function log($message, $priority = self::INFO)
    {
        if ($this->getPriority() >= $priority) {
            $this->getWriter()->write($message);
        }
    }
}