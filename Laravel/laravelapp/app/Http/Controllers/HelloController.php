<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\HelloRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HelloController extends Controller
{
  public function welcome()
  {
    return view('welcome');
  }

  public function index(Request $request)
  {
    $user = Auth::user();
    $sort = $request->sort ?? 'id';
    $order = $request->order ?? 'asc';
    $items = Person::orderBy($sort, $order)->paginate(5);

    $appends = array();
    if ($sort != 'id') {
      $appends['sort'] = $sort;
    }
    if ($order != 'asc') {
      $appends['order'] = $order;
    }
    $param = [
      'user' => $user,
      'items' => $items->appends($appends),
    ];

    return view('hello.index', $param);
  }

  public function show(Request $request)
  {
    $page = $request->page ?? 0;
    $items = DB::table('people')
      ->offset($page * 3)
      ->limit(3)
      ->get();
    return view('hello.show', ['items' => $items]);
  }

  public function add(Request $request)
  {
    return view('hello.add');
  }

  public function create(Request $request)
  {
    $param = [
      'name' => $request->name,
      'mail' => $request->mail,
      'age' => $request->age,
    ];
    DB::table('people')->insert($param);
    return redirect('/hello');
  }

  public function edit(Request $request)
  {
    $item = DB::table('people')
      ->where('id', $request->id)->first();
    return view('hello.edit', ['form' => $item]);
  }

  public function update(Request $request)
  {
    $param = [
      'name' => $request->name,
      'mail' => $request->mail,
      'age' => $request->age,
    ];
    $item = DB::table('people')
      ->where('id', $request->id)
      ->update($param);
    return redirect('/hello');
  }

  public function del(Request $request)
  {
    $item = DB::table('people')
      ->where('id', $request->id)
      ->first();
    return view('hello.del', ['form' => $item]);
  }

  public function remove(Request $request)
  {
    DB::table('people')
      ->where('id', $request->id)
      ->delete();
    return redirect('/hello');
  }
  /* ----------------------------------------
    REST
  ---------------------------------------- */
  public function rest(Request $request)
  {
    return view('hello.rest');
  }
  /* ----------------------------------------
    SESSION
  ---------------------------------------- */
  public function ses_get(Request $request)
  {
    $sesdata = $request->session()->get('msg');
    return view('hello.session', ['session_data' => $sesdata]);
  }
  public function ses_put(Request $request)
  {
    $msg = $request->input;
    $request->session()->put('msg', $msg);
    return redirect('hello/session');
  }
  /* ----------------------------------------
    Auth
  ---------------------------------------- */
  public function getAuth(Request $request)
  {
    $param = ['message' => 'ログインして下さい。'];
    return view('hello.auth', $param);
  }
  public function postAuth(Request $request)
  {
    $email = $request->mail;
    $password = $request->pass;
    if (Auth::attempt(['email' => $email, 'password' => $password])) {
      $msg = 'ログインしました。('.Auth::user()->name.')';
    } else {
      $msg = 'ログインに失敗しました。';
    }
    $param = ['message' => $msg];
    return view('hello.auth', $param);
  }
}
