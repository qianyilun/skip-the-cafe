@extends('layouts.app')
<style>
  #admintable td, #admintable th {
    padding: .23rem;
  }
</style>
@section('content')
    <div class="container">
        <h1>Administrator's Page</h1>
        <h2>View All Orders</h2>
        <table class="table" id="adminTable">
            <tr>
                <th>Order Id</th>
                <th>Title</th>
                <th>Item</th>
                <th>Owner</th>
                <th>Taker</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Completed</th>
                <th>Confirmed</th>
                <th>Operations</th>
            </tr>
            @foreach ($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->title}}</td>
                    <td>{{$order->item}}</td>

                    <td>
                    <a href="admin/user/{{$order->user->id}}/orders">{{$order->owner}}</a>
                    </td>

                    <td>{{$order->taker}}</td>
                    <td>{{$order->latitude}}</td>
                    <td>{{$order->longitude}}</td>
                    <td>{{$order->completed}}</td>
                    <td>{{$order->confirmed}}</td>
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
        <h2>View All Users      
        <a href="admin/user/create">
            <button type="button" class="btn btn-primary btn-sm">Create New User</button>
        </a>
        </h2>

        <table class="table">
            <tr>
                <th>User Id</th>
                <th>User Name</th>
                <th>User Email</th>
                <th>User Type</th>
                <th>Operations</th>
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->type}}</td>
                    <td>
                        <a href="admin/user/{{$user->id}}/orders">
                        <button type="button" class="btn btn-info btn-sm">View Orders</button>
                        </a>
                        <a href="admin/user/{{$user->id}}/edit">
                            <button type="button" class="btn btn-success btn-sm">Edit User</button>
                        </a>
                        @if ($user->type !== 'admin')
                        <a href="admin/user/{{$user->id}}/grantadmin">
                            <button type="button" class="btn btn-warning btn-sm">Grant Admin</button>
                        </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>

@endsection