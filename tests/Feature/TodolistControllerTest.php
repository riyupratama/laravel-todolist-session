<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
            "user" => "Riyu",
            "todolist" => [
                "id" => "1",
                "todo" => "Rahmat"
            ],
            [
                "id" => "2",
                "todo" => "Pratama"
            ]
        ])->get('/todolist')
            ->assertSeeText('1')
            ->assertSeeText('rahmat')
            ->assertSeeText('2')
            ->assertSeeText('pratama');
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "Riyu"
        ])->post('/todolist', [])
            ->assertSeeText('Todo is required!');
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            "user" => "Riyu"
        ])->post('/todolist', [
            "todo" => "smith"
        ])->assertRedirect('/todolist');
    }
}
