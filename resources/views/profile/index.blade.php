@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="v-pills-baisc-info-tab" data-toggle="pill" href="#v-pills-basic-info" role="tab" aria-controls="v-pills-basic-info" aria-selected="true">Basic Info</a>
            <a class="nav-link" id="v-pills-order-history-tab" data-toggle="pill" href="#v-pills-order-history" role="tab" aria-controls="v-pills-order-history" aria-selected="false">Order History</a>
            <a class="nav-link" id="v-pills-delivery-history-tab" data-toggle="pill" href="#v-pills-delivery-history" role="tab" aria-controls="v-pills-delivery-history" aria-selected="false">Delivery History</a>
            <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
        </div>
    </div>

    <div class="col-md-7">
        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-basic-info" role="tabpanel" aria-labelledby="v-pills-baic-info-tab">
                <div class="card">
                    <div class="card-header">
                        Your Profile
                        @if (count($completedOrdersPostByUser) <=2 )
                            <span class="badge badge-pill badge-info">New user</span>
                        @endif
                        @if (count($completedOrdersPostByUser) >= 4)
                            <span class="badge badge-pill badge-primary">Order King</span>
                        @endif
                        @if (count($OrdersTakenByUser) >=3 )
                            <span class="badge badge-pill badge-success">Time savior</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <table class="table borderless">
                            <tbody>
                                <tr>
                                    <td scope="row"><h5 class="card-title"><b>User Name:</b></h5></td>
                                    <td><p class="card-text">{{$user->name}}</p></td>
                                </tr>
                                <tr>
                                    <td scope="row"><h5 class="card-title"><b class="mr-4">User Email:</b> </h5></td>
                                    <td><span class="card-text">{{$user->email}}</span></td>
                                </tr>
                                <tr>
                                    <td scope="row"><h5 class="card-title"><b class="mr-4">Total Complete Order:</b> </h5></td>
                                    <td><span class="card-text">{{count($completedOrdersPostByUser)}}</span></td>
                                </tr>
                                <tr>
                                    <td scope="row"><h5 class="card-title"><b class="mr-3">Total Complete Delivery:</b> </h5></td>
                                    <td><span class="card-text">{{count($completedOrdersTakenByUser)}}</span></td>
                                    </tr>
                            </tbody>
                        </table>                         
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="v-pills-order-history" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                <h2>Order History</h2>

                @if (count($ordersPostedByUser) == 0)
                    <p>You haven't post any order yet.</p>
                @endif

                <div class="list-group">
                    @foreach ($ordersPostedByUser as $order)
                        <div class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <h4 class="mb-1">
                                    <a href="{{route('orders.show', $order->id)}}">{{$order->title}}</a>
                                </h4>
                                <small>{{$order->created_at}}</small>
                            </div>
                            <div>
                                @if ($order->completed == 0)
                                    <span class="badge badge-pill badge-info">Not Dleivery yet</span>
                                @endif 
                                @if ($order->taker == NULL)
                                    <span class="badge badge-pill badge-info">No taker</span>
                                @endif 
                            </div>
                            <div class="d-flex w-150 justify-content-between">
                                <p class="mb-1">Description: {{$order->description}}</p>
                                <small>${{$order->price}}</small>
                            </div>
                            <div>
                                @if ($order->taker != '' && $order->taker != null && $order->completed == 1 )
                                    <a href="{{url('comment/' . $order->id)}}"><button type="button" class="btn btn-success btn-sm">Leave a comment for the taker</button></a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="v-pills-delivery-history" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                <h2>Delivery History</h2>

                @if (count($OrdersTakenByUser) == 0)
                    <p>You haven't delivery any order yet.</p>
                @endif

                <div class="list-group">
                    @foreach ($OrdersTakenByUser as $order)
                        <div class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <h4 class="mb-1">{{$order->title}}</h4>
                                <small>{{$order->created_at}}</small>
                            </div>
                            <div>
                                @if ($order->completed == 0)
                                    <span class="badge badge-pill badge-info">Not Dleivery yet</span>
                                @endif 
                            </div>
                            <div class="d-flex w-150 justify-content-between">
                                <p class="mb-1">Description: {{$order->description}}</p>
                                <small>${{$order->price}}</small>
                            </div>
                            <div>
                                @if ($order->completed == 1 )
                                    <a href="{{ url('/showDirection/'. $order->id) }}"><button type="button" class="btn btn-success btn-sm">Completed the order</button></a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                <h2>Setting</h2>
            </div>
        </div>
    </div>
</div>

@endsection