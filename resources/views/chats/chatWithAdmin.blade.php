@extends('layouts.app')

@section('content')

    <chat-with-admin :user="{{auth()->user()}}"></chat-with-admin>

@endsection