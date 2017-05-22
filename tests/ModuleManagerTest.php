<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/ModuleManager.php';

class ModuleManagerTest extends TestCase
{
    protected function setUp()
    {
        ModuleManager::$modules_install = [];
    }

    /**
     * @covers ModuleManager::include_install
     */
    public function testReturnImmediatelyWhenModuleAlreadyLoaded()
    {
        $module = 'Foo_Bar';
        ModuleManager::$modules_install[$module] = 1;
        $result = ModuleManager::include_install($module);
        $this->assertTrue($result);
        $this->assertCount(1, ModuleManager::$modules_install);
    }

    /**
     * @covers ModuleManager::include_install
     */
    public function testReturnWhenModuleIsNotFound()
    {
        $module = 'Foo_Bar';
        $result = ModuleManager::include_install($module);
        $this->assertFalse($result);
        $this->assertEmpty(ModuleManager::$modules_install);
    }

    /**
     * @covers ModuleManager::include_install
     */
    public function testTriggerErrorWhenInstallClassDoesNotExists()
    {
        $module = 'EssClient';
        $result = ModuleManager::include_install($module);
        $this->assertFalse($result);
    }

    /**
     * @covers ModuleManager::include_install
     * @expectedException PHPUnit\Framework\Error\Error
     */
    public function testTriggerErrorWhenInstallClassIsNotRegistered()
    {
        $module = 'IClient';
        $result = ModuleManager::include_install($module);
        $this->fail('Expecting loading module ' . $module . ' would trigger an error');
    }

    /**
     * @covers ModuleManager::include_install
     */
    public function testModuleManagerCanLoadMailModule()
    {
        $result = \ModuleManager::include_install('Mail');
        $this->assertTrue($result);
    }
}