@extends('layouts.helloapp')

@section('title', 'Index')

@section('menubar')
@parent
インデックスページ
@endsection

@section('content')

@if (Auth::check())
<p>USER: {{$user->name.' ('.$user->email.')'}} </p>
@else
<p>※ログインしていません(<a href="/login">ログイン</a>|<a href="/register">登録</a>)</p>
@endif

<table>
  <tr>
    <th><a href="/hello?sort=name">Na</a><a href="/hello?sort=name&order=desc">me</a></th>
    <th>Mail</th>
    <th>Age</th>
  </tr>
  @foreach ($items as $item)
  <tr>
    <td>{{$item->name}}</td>
    <td>{{$item->mail}}</td>
    <td>{{$item->age}}</td>
  </tr>
  @endforeach
</table>
{{$items->links()}}
@endsection

@section('footer')
copyright 2020 tuyano.
@endsection