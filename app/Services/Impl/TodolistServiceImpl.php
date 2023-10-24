<?php

namespace App\Services\Impl;

use App\Services\TodolistService;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Session;


class TodolistServiceImpl implements TodolistService
{
    public function saveTodolist(string $id, string $todo): void
    {
        if(!Session::exists('todolist')) {
            Session::put('todolist', []);
        }

        Session::push('todolist', [
            'id' => $id,
            'todo' => $todo
        ]);
    }

    public function getTodolist(): array
    {
        return Session::get('todolist', []);
    }

    public function removeTodolist(string $todoId)
    {
        $todolist = Session::get('todolist', []);

        foreach($todolist as $index => $val){
            if ($val['id'] == $todoId) {
                unset($todolist[$index]);
                break;
            }
        }

        Session::put('todolist', $todolist);
    }
}

?>