<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Event;
use App\Models\Type;
use App\Models\City;
use Carbon\Carbon;
use DataTables;
use Form;

class EventController extends Controller
{
    public $title = 'My Event';
    public $uri = 'events';
    public $folder = 'events';

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
        $data = $this->table->where('user_id', auth()->user()->id)->select([
            'id', 'name', 'type_id', 'city_id', 
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
        ->editColumn('price', function ($index) {
            return number_format($index->price);
        })
        ->editColumn('created_at', function ($index) {
            return isset($index->created_at) ? $index->created_at->format('d F Y') : '-';
        })
        ->addColumn('action', function ($index) {
            $tag = Form::open(array("url" => route($this->uri.'.destroy',$index->id), "method" => "DELETE"));
            $tag .= "<div class='btn-group'>";
            $tag .= "<a href=".route($this->uri.'.edit',$index->id)." class='btn btn-primary btn-xs'><i class='fa fa-edit'></i></a>";
            // $tag .= "<a href=".route($this->uri.'.show',$index->id)." class='btn btn-success btn-xs'><i class='fa fa-eye'></i></a>";
            $tag .= "<button type='submit' class='delete btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></button>";
            $tag .= "</div>";
            $tag .= Form::close();
            return $tag;
        })
        ->rawColumns(['id', 'image', 'action'])
        ->make(true);
    }

    public function create()
    {
        $data['title'] = $this->title;
        $data['desc'] = 'Create';
        $data['action'] = route($this->uri.'.store');
        $data['url'] = route($this->uri.'.index');
        $data['types'] = Type::all();
        $data['cities'] = City::all();
        return view($this->folder.'.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'city_id' => 'required',
            'type_id' => 'required',
            'start_date' => 'required|date_format:Y-m-d',
            'price' => 'required|numeric',
            'description' => 'required',
            'image_file' => 'required|image'
        ]);

        if($request->hasFile('image_file')) {
            $path = $request->file('image_file')->storePublicly('image', 'public_upload');
            $request->merge([
                'image' => (isset($path) && !empty($path)) ? $path : null
            ]);
        }
        $request->merge([
            'user_id' => auth()->user()->id
        ]);
        $this->table->create($request->all());
        return redirect(route($this->uri.'.index'))->with('success', 'Events has been created');
    }

    public function edit($id)
    {
        $data['title'] = $this->title;
        $data['desc'] = 'Edit';
        $data['event'] = $this->table->where([
                            ['user_id', auth()->user()->id],
                            ['id', $id]
                        ])->first();
        $data['types'] = Type::all();
        $data['cities'] = City::all();
        $data['action'] = route($this->uri.'.update', $id);
        $data['url'] = route($this->uri.'.index');
        return view($this->folder.'.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'city_id' => 'required',
            'type_id' => 'required',
            'start_date' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'image_file' => 'nullable|image'
        ]);

        $event = $this->table
                ->where([
                    ['user_id', auth()->user()->id],
                    ['id', $id]
                ])->first();

        if($request->hasFile('image_file')) {
            Storage::disk('public_upload')->delete($event->image);
            $path = $request->file('image_file')->storePublicly('image', 'public_upload');
            $request->merge([
                'image' => (isset($path) && !empty($path)) ? $path : null
            ]);
        }

        $event->update($request->all());

        return redirect(route($this->uri.'.index'))->with('success', 'Event has been updated');
    }

    public function show($id)
    {
        $data['title'] = $this->title;
        $data['desc'] = 'Detail';
        $data['candidate'] = $this->table->find($id);
        $data['url'] = route($this->uri.'.index');
        return view($this->folder.'.show', $data);
    }

    public function destroy($id)
    {
        $tb = $this->table->find($id);
        $tb->delete();
        Storage::disk('public_upload')->delete($tb->image);
        return redirect(route($this->uri.'.index'))->with('success', 'Event has been deleted');
    }

}
