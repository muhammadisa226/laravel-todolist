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
      "user" => "muhisa",
      "todolist" => [
        [
          "id" => "1",
          "todo" => "laravel",
        ],
        [
          "id" => "2",
          "todo" => "javascript"
        ]
      ]
    ])->get('/todolist')->assertSeeText("1")->assertSeeText("laravel");
  }
  public function testAddTodoFailed()
  {
    $this->withSession([
      "user" => "muhisa",
    ])->post('/todolist', [])->assertSeeText("Todo Is Required");
  }
  public function testAddTodoSuccess()
  {
    $this->withSession([
      "user" => "muhisa",
    ])->post('/todolist', ["todo" => "tes1"])->assertRedirect("/todolist");
  }
  public function testRemoveTodo()
  {
    $this->withSession([
      "user" => "muhisa",
      "todolist" => [
        [
          "id" => "1",
          "todo" => "laravel",
        ],
        [
          "id" => "2",
          "todo" => "javascript"
        ]
      ]
    ])->post('/todolist/1/delete')->assertRedirect("/todolist");
  }
}
