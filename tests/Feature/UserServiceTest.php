<?php

namespace Tests\Feature;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
  private UserService $userService;
  protected function setUp(): void
  {
    parent::setUp();

    $this->userService = $this->app->make(UserService::class);
  }
  public function testLoginSuccess()
  {
    self::assertTrue($this->userService->login("muhisa", 'rahasia'));
  }
  public function testLoginUserNotFOund()
  {
    self::assertFalse($this->userService->login("muhammadIsa", '12345'));
  }
  public function testLoginWrongPassword()
  {
    self::assertFalse($this->userService->login("muhisa", '12345'));
  }
}
