@extends('layouts.app')

@section('content')
<div>
<h1>Comments about how {{$order->taker}} is doing?</h1>
    <div class="row">
      <div class="col-md-8">
        <form method="post" action="/orders">
          
          <label for="comment">Comment</label>
          <div class="form-group">
              <textarea  class="form-control" name="comment" id="" rows="5"  placeholder="Any good words would help people to know how professional this taker is:)"></textarea>
          </div>
          {{csrf_field()}}
          <input class="btn btn-primary" type="submit" name="submit">
        </form>
      </div>
    </div>
</div>
@endsection

