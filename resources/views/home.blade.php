@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Hi {{$user->name}}</h1>
<h1>You have placed theseoOrders: </h1>
<ul>
  @foreach ($orders as $order)
    <li>id: {{$order->id}},title: {{$order->title}}, description: {{$order->description}}</li>
  @endforeach
</ul>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
