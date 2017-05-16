<?php

namespace App\Model;


interface TaskGatewayInterface
{
    /**
     * Fetch all tasks from the back-end storage
     * @return \Iterator
     */
    public function fetchAll(): \Iterator;
}