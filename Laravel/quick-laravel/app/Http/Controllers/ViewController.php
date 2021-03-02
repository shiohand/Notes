<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
  public function master()
  {
    return view('view.master', ['msg' => 'こんにちは、世界！']);
  }
}
