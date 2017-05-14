<?php

namespace App\Test;

use App\HelloWorld;
use PHPUnit\Framework\TestCase;

/**
 * Class HelloWorldTest
 *
 * This test class will test our simple example testcase
 * for HelloWorld class.
 *
 * @package App\Test
 * @group HelloWorld
 */
class HelloWorldTest extends TestCase
{
    /**
     * This test will check our HelloWorld class for method
     * sayHello to assert that this method will return the
     * string "Hello World!"
     *
     * @covers HelloWorld::sayHello
     */
    public function testAppOutputsHelloWorld()
    {
        $helloWorld = new HelloWorld();
        $expectedAnswer = $helloWorld->sayHello();
        $this->assertSame('Hello World!', $expectedAnswer);
    }

    /**
     * This test will check our HelloWorld class for method
     * sayHello to assert that this method will return a string
     * "Hello <arg>!" where <arg> is the argument given to the
     * sayHello method
     *
     * @covers HelloWorld::sayHello
     */
    public function testAppOutputsHelloArgument()
    {
        $helloWorld = new HelloWorld();
        $expectedAnswer = $helloWorld->sayHello('unit testers');
        $this->assertSame('Hello unit testers!', $expectedAnswer);
    }
}
