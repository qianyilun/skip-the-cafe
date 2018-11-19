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
                <h3>User Name</h3>
                <p>{{$user->name}}</p>
                <h3>User Email</h3>
                <p>{{$user->email}}</p>
                <h3>Total Order</h3>
                <h3>Total Delivery</h3>
            </div>
            <div class="tab-pane fade" id="v-pills-order-history" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                <h2>Order History</h2>
            </div>
            <div class="tab-pane fade" id="v-pills-delivery-history" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                <h2>Delivery History</h2>
            </div>
            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                <h2>Setting</h2>
            </div>
        </div>
    </div>
</div>

@endsection