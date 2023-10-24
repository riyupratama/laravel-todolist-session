<?php

namespace Tests\Feature;

use App\Services\TodolistService;
// use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Session\Store;

class TodolistServiceTest extends TestCase
{
    private TodolistService $todolistService;

    public function setUp():void
    {
        parent::setUp();

        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function testTodolistNotNull()
    {
        self::assertNotNull($this->todolistService);
    }

    public function testSaveTodolist()
    {
        $this->todolistService->saveTodolist("1", "riyu");

        $todolist = Session::get('todolist');
        foreach($todolist as $val){
            self::assertEquals("1", $val['id']);
            self::assertEquals('riyu', $val['todo']);
        }
    }

    public function testGetTodolistEmpty()
    {
        self::assertEquals([], $this->todolistService->getTodolist());
    }

    public function testGetTodolistNotEmpty()
    {
        $expected = [
            [
                "id" => "1",
                "todo" => "riyu"
            ],
            [
                "id" => "2",
                "todo" => "eko"
            ]
        ];

        $this->todolistService->saveTodolist('1', 'riyu');
        $this->todolistService->saveTodolist('2', 'eko');

        self::assertEquals($expected, $this->todolistService->getTodolist());
    }

    public function testRemoveTodolist()
    {
        $this->todolistService->saveTodolist('1', 'riyu');
        $this->todolistService->saveTodolist('2', 'rahmat');

        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));
        
        $this->todolistService->removeTodolist('1');
        self::assertEquals(1, sizeof($this->todolistService->getTodolist()));
        
        $this->todolistService->removeTodolist('2');
        self::assertEquals(0, sizeof($this->todolistService->getTodolist()));
    }
}
