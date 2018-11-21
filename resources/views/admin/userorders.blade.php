@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Administrator's Page</h1>      
        <h3>User Info
            <a href="/admin/user/{{$user->id}}/edit">
                <button type="button" class="btn btn-success btn-sm">Edit User</button>
            </a>
        </h3>

        <dl class="row">
                <dt class="col-sm-3">User Name</dt>
                <dd class="col-sm-9">{{$user->name}}</dd>

                <dt class="col-sm-3">User Id</dt>
                <dd class="col-sm-9">{{$user->id}}</dd>

                <dt class="col-sm-3">User Email</dt>
                <dd class="col-sm-9">{{$user->email}}</dd>

                <dt class="col-sm-3">User Type</dt>
                <dd class="col-sm-9">{{$user->type}}</dd>                
        </dl>
        <h3>View All Orders Of User: {{$user->name}}</h3>    
        <div class="row">                
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
                <button style="margin-left: 8px" type="button" class="btn btn-secondary btn-sm">Back</button>
            </a>
        </div>

@endsection