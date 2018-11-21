@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Administrator's Page</h1>
        <div class="row">
            <h2>View All Orders of user name: {{$user->name}}, id: {{$user->id}}</h2>
            <table class="table">
                <tr>
                    <th>order id</th>
                    <th>title</th>
                    <th>item</th>
                    <th>owner</th>
                    <th>taker</th>
                    <th>latitude</th>
                    <th>longitude</th>
                    <th>Operations</th>
                </tr>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{$order->id}}</td>
                        <td>{{$order->title}}</td>
                        <td>{{$order->item}}</td>
                        <td>{{$order->owner}}</td>
                        <td>{{$order->taker}}</td>
                        <td>{{$order->latitude}}</td>
                        <td>{{$order->longitude}}</td>
                        <td>
                            <a href="{{route('orders.show', $order->id)}}">
                                <button type="button" class="btn btn-info btn-sm">View</button>
                            </a>
                            <a href="{{route('orders.edit', $order->id)}}">
                                <button type="button" class="btn btn-success btn-sm">Edit</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
            <a href="/admin">
                <button type="button" class="btn btn-secondary btn-sm">Back</button>
            </a>
        </div>

@endsection