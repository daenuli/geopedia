@extends('layouts.app')

@push('select2')
    <link rel="stylesheet" href="{{asset('AdminLTE-2.4.18/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
@endpush

@push('scripts')
    <script src="{{asset('AdminLTE-2.4.18/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <script>
    $('.datepicker').datepicker({
        format:'yyyy-mm-dd',
        autoclose: true
    });
  </script>
@endpush

@section('content')
<div class="box">
	<div class="box-header with-border">
        <a href="{{$url}}" class="btn btn-warning"><i class="fa fa-fw fa-arrow-left"></i> Back</a>
	</div>
    <form action="{{$action}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
    @csrf
        <div class="box-body">
            <div class="form-group">
                <label class="col-sm-2 control-label">Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="Ex: RAMADHAN PENUH TAWA" autocomplete="off">
                    @error('name')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Type</label>
                <div class="col-sm-8">
                    <select class="form-control" name="type_id">
                        @foreach($types as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                    @error('type_id')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Location</label>
                <div class="col-sm-8">
                    <select class="form-control" name="city_id">
                        @foreach($cities as $city)
                        <option value="{{$city->id}}">{{$city->name}}</option>
                        @endforeach
                    </select>
                    @error('city_id')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Image</label>
                <div class="col-sm-8">
                    <input type="file" name="image_file">
                    @error('image_file')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Start Date</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control datepicker" name="start_date" value="{{old('start_date')}}" autocomplete="off">
                    @error('start_date')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Price</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="price" value="{{old('price')}}" placeholder="Ex: 150000" autocomplete="off">
                    @error('price')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Description</label>
                <div class="col-sm-8">
                    <textarea class="form-control" name="description">{{old('description')}}</textarea>
                    @error('description')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="col-sm-8 col-sm-offset-2">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>
@endsection