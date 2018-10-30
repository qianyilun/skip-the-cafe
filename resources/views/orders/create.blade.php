@extends('layouts.app')

@section('content')
<div>
    <h1>New Order</h1>
    <div class="row">
      <div class="col-md-6">
        <form method="post" action="/orders">
          <div class="form-group">
            <input type="text" name="title" placeholder="Title">
          </div>
          <div class="form-group">
            <input type="text" name="item" placeholder="item">
          </div>
          <textarea class="form-control" name="description" id="" cols="30" rows="10"  placeholder="description"></textarea>
          <div class="form-group">
              <input type="textarea" name="address" placeholder="address(be specific)">
          </div>
          <div class="form-group">
              <input type="number" name="price" placeholder="price" step="0.01">
          </div>
          {{csrf_field()}}
          <input type="submit" name="submit">
        </form>
      </div>
    </div>
</div>
@endsection