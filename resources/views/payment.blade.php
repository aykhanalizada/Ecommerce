@extends('app')
@section('title','Payment')

@section('content')

    <form action="{{route('checkout')}}" method="POST">
        @csrf
        <button class="btn btn-success">Checkout</button>
    </form>
@endsection
