@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Administrator's Page</h1>
        <h2>Create a New User</h2>

        <form method="post" action="/admin/user/store">
            {{csrf_field()}}
            <div class="form-group">
                <label for="title">User Name</label>
                <input class="form-control" type="text" name="name" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label for="email">User Email</label>
                <input class="form-control" type="text" name="email" placeholder="Enter email">
            </div>

            <div class="form-group">
                <label for="type">User Type</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="type" id="default" value="default" checked>
                    <label class="form-check-label" for="default">
                        Default
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="type" id="admin" value="admin">
                    <label class="form-check-label" for="admin">
                        Admin
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
            </div>

            {{csrf_field()}}
            <input class="btn btn-primary" type="submit" name="submit">
        </form>

    </div>
@endsection