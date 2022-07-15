@extends('layouts.app')
@section('title')
Users
@endsection
@section('content')
<div class="page-header">
   @if (count($errors) > 0)
   <div class="alert alert-danger mt-2">
      <strong>Whoops!</strong>Something went wrong.<br><br>
      <ul>
         @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
         @endforeach
      </ul>
   </div>
   @endif
   @if ($message = Session::get('success'))
   <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ $message }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
   </div>
   @endif
   @if ($message = Session::get('failed'))
   <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ $message }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
   </div>
   @endif
   <div class="row align-items-center">
      <div class="col">
         <h3 class="page-title">Users</h3>
      </div>
      <div class="col-auto float-right ml-auto">
         @can('user-create')
         <a href="{{ route('users.create') }}" class="btn add-btn add-user"> Add </a>
         @endcan
      </div>
   </div>
</div>
@foreach ($data as $key => $user)
<div id="assign_work_to_{{ $user->id }}" class="modal custom-modal fade" role="dialog">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Add Addition</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form action="{{ route('timesheets.assign') }}" method="post">
               @csrf
               <input class="form-control" value="{{ $user->id }}" type="hidden" name="user_id">
               <input class="form-control" value="{{ $user->work_type }}" type="hidden" name="worktype_id">
               <div class="row">
                  <div class="form-group col-sm-6">
                     <label>Date <span class="text-danger">*</span></label>
                     <input type="date" id="date" class="form-control" name="date" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}">
                  </div>
                  <div class="form-group col-sm-6">
                     <label>Qty <span class="text-danger">*</span></label>
                     <input class="form-control" type="number" name="qty">
                  </div>
               </div>
               <div class="submit-section">
                  <button class="btn btn-primary submit-btn btn-sm">Submit</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endforeach
<div class="row">
   <div class="col-md-12">
      <div class="table-responsive">
         <table class="table table-striped custom-table mb-0 data-table">
            <thead>
               <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Roles</th>
                  <th>Created At</th>
                  <th class="text-center">Action</th>
               </tr>
            </thead>
            <tbody>
            </tbody>
         </table>
      </div>
   </div>
</div>
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
            scrollX: false,
            columns: [
                {data: 'DT_RowIndex',name: 'DT_RowIndex',orderable: false, searchable: false},
                {data: 'name', orderable: false},
                {data: 'email',orderable:false},
                {data: 'roles',orderable:false},
                {data: 'created_at', orderable: false},
                {data: 'action', name: 'action', orderable: false,searchable: false},
            ]
        });
      });
    </script>
@endsection