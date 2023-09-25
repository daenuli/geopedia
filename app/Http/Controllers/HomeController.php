<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class HomeController extends Controller
{
    public function index()
    {
        $data['total_order'] = OrderItem::whereHas('event', function ($query) {
            return $query->where('user_id', auth()->user()->id);
        })->count();
        $data['total_purchase'] = Order::where('user_id',auth()->user()->id)->count();
        return view('home.index', $data);
    }
}
