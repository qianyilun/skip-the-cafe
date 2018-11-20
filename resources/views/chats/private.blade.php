@extends('layouts.app')

@section('content')

    <private-chat :user="{{auth()->user()}}" :owner="{{$id}}"></private-chat>

@endsection

