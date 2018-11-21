@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Administrator's Page</h1>
        <h2>Edit User Information Here</h2>

        <form method="post" action="/admin/user/{{$user->id}}/update">
            {{csrf_field()}}
            <div class="form-group">
                <label for="title">User Name</label>
                <input class="form-control" type="text" name="name" value="{{$user->name}}">
            </div>
            <div class="form-group">
                <label for="email">User Email</label>
                <input class="form-control" type="text" name="email" value="{{$user->email}}">
            </div>

            <div class="form-group">
                <label for="type">User Type</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="type" id="default" value="default" {{$user->type === 'default' ? "checked" : ""}}>
                    <label class="form-check-label" for="default">
                        Default
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="type" id="admin" value="admin" {{$user->type === 'admin' ? "checked" : ""}}>
                    <label class="form-check-label" for="admin">
                        Admin
                    </label>
                </div>
            </div>

            {{csrf_field()}}
            <input class="btn btn-primary btn-sm" type="submit" name="UPDATE">
            <a href="/admin">
            <button type="button" class="btn btn-secondary btn-sm">Back</button>
        </a>
        </form>        
        @if ($user->id !== auth()->user()->id)
            <form method="post" action="/admin/user/{{$user->id}}/delete">
                {{csrf_field()}}
                <input style="margin-top: 8px" class="btn btn-danger btn-sm" type="submit" value="Delete">
            </form>
        @endif

        
    </div>
@endsection