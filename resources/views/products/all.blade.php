@extends('layouts.app')
@section('sidebar')
  @parent
  <p>This is </p>
@endsection
@section('contents')
  @include('layouts.partials.product')
@endsection
