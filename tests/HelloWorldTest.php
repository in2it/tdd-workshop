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
     * This test will test our HelloWorld class for method
     * sayHello to assert that this method will return the
     * string "Hello World!"
     *
     * @covers HelloWorld::sayHello
     */
    public function testSayHelloReturnsHelloWorldAsString()
    {
        $helloWorld = new HelloWorld();
        $expectedAnswer = $helloWorld->sayHello();
        $this->assertSame('Hello World!', $expectedAnswer);
    }
}
