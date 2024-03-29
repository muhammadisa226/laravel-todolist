<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
  private UserService $userService;
  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
  }
  public function login(): Response
  {
    return response()->view('user.login', ["title" => "Login Page"]);
  }
  public function doLogin(Request $request)
  {
    $user = $request->input('user');
    $password = $request->input('password');

    if (empty($user) || empty($password)) {
      return response()->view("user.login", ["title" => "Login Page", "error" => "
      User Or Password Is Required"]);
    }
    if ($this->userService->login($user, $password)) {
      $request->session()->put("user", $user);
      return redirect('/');
    }
    return response()->view('user.login', ['title' => 'Login Page', 'error' => "User Or Password Is Wrong"]);
  }
  public function doLogout(Request $request)
  {
    $request->session()->forget("user");
    return redirect('/');
  }
}
