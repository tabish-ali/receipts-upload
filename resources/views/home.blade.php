@extends('layouts.app')
@section('content')
<div class="container">
    <receipt-upload :settings="{{$settings}}" />
</div>
@endsection