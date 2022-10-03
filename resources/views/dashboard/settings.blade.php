@extends('layouts.app')
@section('content')
<div class="container">
  @include('dashboard.side_menu')
  <div class="main">
    <settings :admin="{{Auth::user()}}" />
  </div>
</div>
@endsection