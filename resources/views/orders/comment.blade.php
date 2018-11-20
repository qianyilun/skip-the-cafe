@extends('layouts.app')
<style>
    *{
        margin:0;
        padding:0;
    }

    .box{
        height: 50px;
        width: 300px;
    }
    .box .comment{
        font-size: 30px;
        color: orange;
    }

    .comment li{
        float: left;
        cursor: pointer;
        zoom: 2;
    }

    ul{
        list-style: none;
    }

    #rating {
      margin-top: 45px;
    }
    #takerHighlight {
      color: red;
    }
    
</style>
@section('content')
<div>
  <div class="row">
    <div class="col-md-12">
      <h1>Comments: how <span id="takerHighlight">{{$userName}}</span> is doing this time?</h1>
    </div>
  </div>
    <div class="row">
      <div class="col-md-3">
        <h3 id="rating">Give a rating: </h3>
      </div>
      <div class="col-md-8">
          <div class="box">
            <ul class="comment" name="">
                <li value="1">☆</li>
                <li value="2">☆</li>
                <li value="3">☆</li>
                <li value="4">☆</li>
                <li value="5">☆</li>
            </ul>
          </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8">
        <form method="post" action="/comment">
          <input type="number" name="orderId" value="{{$order->id}}" hidden>
          <input type="number" name="rating" id="ratingInForm" value="" hidden>
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
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script>
  
$(function(){
  var solidStar = '★'; 
  var emptyStar = '☆';

  $(".comment li").on("mouseover",function(){
      $(this).text(solidStar).prevAll("li").
      text(solidStar).end().nextAll().text(emptyStar);
  });

  $(".comment li").on("mouseout",function(){
      if($("li.current").length === 0){
          $(".comment li").text(emptyStar);
      }else{
          $("li .current").text(solidStar).prevAll().text(solidStar).end().nextAll().text(emptyStar);
      }
  });

  $(".comment li").on("click",function(){
      $(this).attr("class","current").siblings().removeClass("current");
  });

  $(".comment li").click(function() {
    $('#ratingInForm').attr('value', $(this).attr('value'));
  });

});
</script>
