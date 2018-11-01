@extends('layouts.app')

@section('content')
<div>
    <h1>New Order</h1>
    <div class="row">
      <div class="col-md-6">
        <form method="post" action="/orders">
          <div class="form-group">
            <input class="form-control" type="text" name="title" placeholder="Title">
          </div>
          <div class="form-group">
            <input class="form-control" type="text" name="Item" placeholder="Item (e.g. a coffee)">
          </div>
          <div class="form-group">
              <textarea  class="form-control" name="description" id="" rows="5"  placeholder="Order Description"></textarea>
          </div>
          <div class="form-group">
              <input class="form-control" type="textarea" name="address" placeholder="Address (e.g. SFU Burnaby campus library first floor)">
          </div>
          <div class="form-group">
              <input class="form-control" type="number" name="price" placeholder="Price" step="0.01">
          </div>
          {{csrf_field()}}
          <input class="btn btn-primary" type="submit" name="submit">
        </form>
      </div>
    </div>
</div>
@endsection