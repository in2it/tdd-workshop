<?php

namespace App;

/**
 * Class HelloWorld
 *
 * Example code that will say Hello
 *
 * @package App
 */
class HelloWorld
{
    /**
     * SayHello will return a string containing the given
     * argument
     *
     * @param string $arg
     * @return string
     */
    public function sayHello(string $arg = 'World'): string
    {
        return 'Hello ' . $arg . '!';
    }
}
