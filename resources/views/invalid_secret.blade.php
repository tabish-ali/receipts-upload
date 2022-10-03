@extends('layouts.app')
@section('content')
<div class="container">
  <div class="d-flex justify-content-center mt-5 flex-column align-items-center p-2 bg-white border border-warning rounded">
    <h1 class="fw-bold text-center">
      You've entered invalid secret,
      you're unable to become admin. Please consult your
      developer for secret code.
    </h1>
  </div>
</div>
@endsection