<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // this is for writting logging messages to storage/logs. use it like Log::alert('goes through takeOrder action in orderController');
use Illuminate\Support\Facades\DB;
use GuzzleHttp; // this package is used to make HTTP request to external api
use App\Order;
use Response;
// use function GuzzleHttp\json_decode;

class DirectionController extends Controller
{
    
    public function showDirection($id) {
      Log::alert('get in showDirection action');

      return view('directions.showDirection', compact('id'));
    }
}
