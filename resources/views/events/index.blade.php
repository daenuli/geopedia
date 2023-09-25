@extends('layouts.app')

@push('styles')
	<link rel="stylesheet" href="{{asset('AdminLTE-2.4.18/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush

@push('scripts')
    <script src="{{asset('AdminLTE-2.4.18/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('AdminLTE-2.4.18/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script>
    var table;
    $(function() {
        table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{$ajax}}',
            order: [[7,'desc']],
            columns: [
                { data: 'id', searchable: false, orderable: false},
                { data: 'name', searchable: true, orderable: false},
                { data: 'type_id', searchable: true, orderable: false},
                { data: 'city_id', searchable: true, orderable: false},
                { data: 'image', searchable: false, orderable: false},
                { data: 'start_date', searchable: true, orderable: true},
                { data: 'price', searchable: true, orderable: true},
                { data: 'created_at', searchable: true, orderable: true},
                { data: 'action', searchable: false, orderable: false}
            ],
            columnDefs: [{
                "targets": 0,
                "data": null,
                "render": function (data, type, full, meta) {
                    return meta.settings._iDisplayStart + meta.row + 1;
                }
            }],
        });
    });
    $(document).on('click', '.delete', function () {
		if (!confirm("Do you want to delete")){
	        return false;
	    }
	});
    </script>
@endpush

@section('content')

@if (session()->has('success'))
<div class="callout callout-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <p>{!!session('success')!!}</p>
</div>
@endif

@if (session()->has('error'))
<div class="callout callout-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <p>{!!session('error')!!}</p>
</div>
@endif

<div class="box">
    <div class="box-header with-border">
        <a href="{{$create}}" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i> Create</a>
    </div>
    <div class="box-body">
        <table id="dataTable" class="table table-bordered table-hover">
            <thead>
	            <tr>
					<th>#</th>
					<th>Name</th>
					<th>Type</th>
					<th>Location</th>
					<th>Image</th>
					<th>Start Date</th>
					<th>Price</th>
					<th>Created At</th>
					<th>Action</th>
	            </tr>
            </thead>
            <tbody>
	        </tbody>
	    </table>
    </div>
</div>
@endsection