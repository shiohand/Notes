<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
    public function __invoke() {
      return <<<EOF
      <h1>Index</h1>
      <p>Helloコントローラ(シングルアクション)</p>
      EOF;
    }
}
