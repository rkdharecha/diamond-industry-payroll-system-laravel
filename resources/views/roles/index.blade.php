@extends('layouts.app')
@section('title')
Roles
@endsection
@section('content')
<div class="page-header">
   @if ($message = Session::get('success'))
   <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ $message }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
   </div>
   @endif
   <div class="row align-items-center">
      <div class="col">
         <h3 class="page-title">Roles</h3>
      </div>
      <div class="col-auto float-right ml-auto">
         @can('role-create')
         <a href="{{ route('roles.create') }}" class="btn add-btn add-role"> Add </a>
         @endcan
      </div>
   </div>
</div>
<div class="table-responsive">
   <table class="datatable table table-stripped data-table mb-0">
      <thead>
         <tr>
            <th>#</th>
            <th>Name</th>
            <th>Created At</th>
            <th>Action</th>
         </tr>
      </thead>
      <tbody>
      </tbody>
   </table>
</div>
@endsection

@section('scripts')
    <script>
       $(function () {
      
        var table = $('.data-table').DataTable({
            processing: false,
            serverSide: true,
            pageLength: 10,
            scrollY: false,
            destroy: true,
            scrollX: false,
            columns: [
                {data: 'DT_RowIndex',name: 'DT_RowIndex',orderable:false,searchable:false},
                {data: 'name', orderable: false},
                {data: 'created_at', orderable: false},
                {data: 'action', name: 'action', orderable: false,searchable: false},
            ]
        });
      });
    </script>
@endsection
