<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Log; // this is for writting logging messages to storage/logs. use it like Log::alert('goes through takeOrder action in orderController');


class AutocompleteController extends Controller
{
  // public function index()
  // {
  //  return view('autocomplete');
  // }

  public function fetch(Request $request)
  {
   if($request->get('query'))
   {
    $query = $request->get('query');
    $items = ['coffee', 'cake', 'latte', 'bubble tea', 'ice cream', 'waffle', 'energy bar', 'mocha', 'frappuccino'];
    
    $output = '<ul class="dropdown-menu" style="display:block; position:relative; padding-left: 10px;">';
    $flag = false;
    foreach($items as $item)
    {
      if (strpos($item, $query) !== false) {
        $flag = true;
        $output .= '
        <li><a href="#">'.$item.'</a></li>
        ';
      }
    }
    $output .= '</ul>';
    if($flag == false) {
      $output = '';
    }
    // echo $output;
    return \Response::json(['html' => $output], 200);
   }
  }

}
