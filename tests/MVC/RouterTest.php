<?php

require realpath(__DIR__ . '/../../framework/boot.php');


class RouterTest extends PHPUnit_Framework_TestCase
{

    public function testSplitPath()
    {

        $router = \T4\MVC\Router::getInstance();
        $reflector = new ReflectionMethod($router, 'splitPath');
        $reflector->setAccessible(true);

        $url = '/mod/ctrl/act';
        $this->assertEquals(
            ['module' => 'mod', 'controller' => 'ctrl', 'action' => 'act', 'params' => []],
            $reflector->invoke($router, $url)
        );
        $url = '//ctrl/act';
        $this->assertEquals(
            ['module' => '', 'controller' => 'ctrl', 'action' => 'act', 'params' => []],
            $reflector->invoke($router, $url)
        );
        $url = '/mod//act';
        $this->assertEquals(
            ['module' => 'mod', 'controller' => 'index', 'action' => 'act', 'params' => []],
            $reflector->invoke($router, $url)
        );
        $url = '/mod/ctrl/';
        $this->assertEquals(
            ['module' => 'mod', 'controller' => 'ctrl', 'action' => 'default', 'params' => []],
            $reflector->invoke($router, $url)
        );
        $url = '///act';
        $this->assertEquals(
            ['module' => '', 'controller' => 'index', 'action' => 'act', 'params' => []],
            $reflector->invoke($router, $url)
        );
        $url = '///';
        $this->assertEquals(
            ['module' => '', 'controller' => 'index', 'action' => 'default', 'params' => []],
            $reflector->invoke($router, $url)
        );

        $url = '/mod/ctrl/act(a=1)';
        $this->assertEquals(
            ['module' => 'mod', 'controller' => 'ctrl', 'action' => 'act', 'params' => ['a' => 1]],
            $reflector->invoke($router, $url)
        );
        $url = '/mod/ctrl/act(a=1,b=2)';
        $this->assertEquals(
            ['module' => 'mod', 'controller' => 'ctrl', 'action' => 'act', 'params' => ['a' => 1, 'b' => 2]],
            $reflector->invoke($router, $url)
        );
        $url = '//ctrl/act(a=1,b=2)';
        $this->assertEquals(
            ['module' => '', 'controller' => 'ctrl', 'action' => 'act', 'params' => ['a' => 1, 'b' => 2]],
            $reflector->invoke($router, $url)
        );
        $url = '/mod//act(a=1,b=2)';
        $this->assertEquals(
            ['module' => 'mod', 'controller' => 'index', 'action' => 'act', 'params' => ['a' => 1, 'b' => 2]],
            $reflector->invoke($router, $url)
        );
        $url = '/mod/ctrl/(a=1,b=2)';
        $this->assertEquals(
            ['module' => 'mod', 'controller' => 'ctrl', 'action' => 'default', 'params' => ['a' => 1, 'b' => 2]],
            $reflector->invoke($router, $url)
        );
        $url = '///act(a=1,b=2)';
        $this->assertEquals(
            ['module' => '', 'controller' => 'index', 'action' => 'act', 'params' => ['a' => 1, 'b' => 2]],
            $reflector->invoke($router, $url)
        );
        $url = '///(a=1,b=2)';
        $this->assertEquals(
            ['module' => '', 'controller' => 'index', 'action' => 'default', 'params' => ['a' => 1, 'b' => 2]],
            $reflector->invoke($router, $url)
        );
    }

}