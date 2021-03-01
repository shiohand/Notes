@extends('layouts.helloapp')

@section('title', 'ユーザー認証')

@section('menubar')
@parent
ユーザー認証ページ
@endsection

@section('content')
<p>{{$message}}</p>

<form action="/hello/auth" method="post">
  @csrf
  <table>
    <tr>
      <th>mail: </th>
      <td><input type="text" name="mail"></td>
    </tr>
    <tr>
      <th>pass: </th>
      <td><input type="password" name="pass"></td>
    </tr>
    <tr>
      <th></th>
      <td><input type="submit" value="send"></td>
    </tr>
  </table>
</form>

@endsection

@section('footer')
copyright 2020 tuyano.
@endsection