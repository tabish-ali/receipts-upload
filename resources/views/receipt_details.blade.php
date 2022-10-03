@extends('layouts.app')
@section('content')
<div class="container">
  @include('dashboard.side_menu')
  <div class="main">
    <receipt-details :admin="{{Auth::user()}}" :receipt="{{$receipt}}" />
  </div>

</div>
@endsection