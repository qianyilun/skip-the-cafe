@extends('layouts.app')

@section('content')

    <private-chat-box :user="{{auth()->user()}}"></private-chat-box>

@endsection
