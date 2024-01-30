<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
  public function testLoginPage()
  {
    $this->get('/login')->assertSeeText("Login Page");
  }

  public function testLoginForMember()
  {
    $this->withSession(["user" => "muhisa"])->get('/login')->assertRedirect('/');
  }
  public function testLoginForUserALreadyLogin()
  {
    $this->withSession(["user" => "muhisa"])->post(
      '/login',
      [
        "user" => "muhisa",
        "password" => "rahasia"
      ]
    )
      ->assertRedirect('/');
  }
  public function testLoginSuccess()
  {
    $this->post('/login', [
      "user" => "muhisa",
      "password" => "rahasia"
    ])->assertRedirect("/")->assertSessionHas("user", "muhisa");
  }
  public function testLoginValidationError()
  {
    $this->post('/login')->assertSeeText("User Or Password Is Required");
  }
  public function testLoginFailed()
  {
    $this->post('/login', ["user" => "muhissa", "password" => "rahasia"])->assertSeeText("User Or Password Is Wrong");
  }
  public function testLogout()
  {
    $this->withSession([
      "user" => "muhisa"
    ])->post('/logout')->assertRedirect('/')->assertSessionMissing('user');
  }
  public function testLogoutGuest()
  {
    $this->post('/logout')->assertRedirect('/login');
  }
}
