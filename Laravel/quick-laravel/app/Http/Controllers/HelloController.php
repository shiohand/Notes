<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class HelloController extends Controller
{
  public function view(Request $request)
  {
    $data = [
      'msg' => 'こんにちは、世界！'
    ];
    return view('hello.view', $data);
  }
  public function list(Request $request)
  {
    $data = [
      'records' => Book::all()
    ];
    return view('hello.list', $data);
  }
}
