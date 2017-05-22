<?php
class Zend_Log_Writer_Mock extends Zend_Log_Writer_Abstract
{
    // is the mock object for testing purposes
    public $events = array ();
    public function write($message)
    {
        $this->events[] = $message;
    }
}