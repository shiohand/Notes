@extends('layouts.helloapp')

@section('title', 'Show')

@section('menubar')
@parent
詳細ページ
@endsection

@section('content')

@if ($items != null)
<table width="400px">
@foreach ($items as $item)
  <tr>
    <th width="50px">id:</th>
    <td width="50px">{{$item->id}}</td>
    <th width="50px">name:</th>
    <td>{{$item->name}}</td>
  </tr>
@endforeach
</table>
@endif
@endsection

@section('footer')
copyright 2020 tuyano.
@endsection