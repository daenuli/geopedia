<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Payment;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use DataTables;
use Form;

class DiscoverController extends Controller
{
    public $title = 'Discover Event';
    public $uri = 'discovers';
    public $folder = 'discovers';

    public function __construct(Event $table)
    {
        $this->table = $table;
    }

    public function index()
    {
        $data['title'] = $this->title;
        $data['desc'] = 'List';
        $data['ajax'] = route($this->uri.'.data');
        $data['create'] = route($this->uri.'.create');
        return view($this->folder.'.index', $data);
    }

    public function data(Request $request)
    {
        if (!$request->ajax()) { return; }
        $data = $this->table->where('user_id', '!=', auth()->user()->id)->select([
            'id', 'name', 'type_id', 'city_id', 'user_id',
            'image', 'start_date', 'price', 'created_at'
        ]);
        return DataTables::of($data)
        ->addColumn('start_date', function ($index) {
            return Carbon::parse($index->start_date)->format('d F Y');
        })
        ->editColumn('image', function ($index) {
            return ($index->image) ? "<img src='/images/$index->image' width='100' class='margin'>" : '-';
        })
        ->editColumn('type_id', function ($index) {
            return $index->type->name ?? '-';
        })
        ->editColumn('city_id', function ($index) {
            return $index->city->name ?? '-';
        })
        ->editColumn('user_id', function ($index) {
            return $index->user->name ?? '-';
        })
        ->editColumn('price', function ($index) {
            return number_format($index->price);
        })
        ->editColumn('created_at', function ($index) {
            return isset($index->created_at) ? $index->created_at->format('d F Y') : '-';
        })
        ->addColumn('action', function ($index) {
            $tag = Form::open(array("url" => route($this->uri.'.destroy',$index->id), "method" => "DELETE"));
            $tag .= "<div class='btn-group'>";
            $tag .= "<a href=".route($this->uri.'.buy',$index->id)." class='btn btn-primary btn-xs'><i class='fa fa-shopping-cart'></i></a>";
            // $tag .= "<a href=".route($this->uri.'.show',$index->id)." class='btn btn-success btn-xs'><i class='fa fa-eye'></i></a>";
            // $tag .= "<button type='submit' class='delete btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></button>";
            $tag .= "</div>";
            $tag .= Form::close();
            return $tag;
        })
        ->rawColumns(['id', 'image', 'action'])
        ->make(true);
    }

    public function buy($id)
    {
        $data['payment'] = Payment::all();
        $data['event'] = Event::where([
                            ['user_id', '!=', auth()->user()->id],
                            ['id', $id]
                        ])->first();
        return view($this->folder.'.buy', $data);
    }

    public function order(Request $request, $id)
    {
        $order = Order::create([
            'user_id' => auth()->user()->id,
            'payment_id' => $request->payment_id,
            'amount' => $request->amount,
            'status' => 'paid',
        ]);

        $event = Event::find($id);

        OrderItem::create([
            'order_id' => $order->id,
            'event_id' => $id,
            'quantity' => 1,
            'unit_price' => $event->price,
        ]);

        return redirect(route($this->uri.'.index'))->with('success', 'Events has been ordered');
    }

}
