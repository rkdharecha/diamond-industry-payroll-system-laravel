@extends('layouts.app')
@section('title')
Show Role
@endsection
@section('content')
<div class="page-header">
   <div class="row align-items-center">
      <div class="col">
         <h3 class="page-title">Show Role</h3>
      </div>
      <div class="col-auto float-right ml-auto">
         <a href="{{ route('roles.index') }}" class="btn add-btn"> Back </a>
      </div>
   </div>
</div>
<div class="row p-4" style="border: 1px solid;">
   <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="form-group">
         <strong>Name : </strong>
         {{ $role->name }}
      </div>
   </div>
   <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="form-group">
         <strong>Permissions : </strong>
         @if(count($rolePermissions) > 0)
         @foreach($rolePermissions as $v)
         <label class="label label-success"><span class="text-danger">[</span> {{ $v->name }} <span class="text-danger">]</span></label>
         @endforeach
         @else
         <label class="label"><span class="text-danger">[</span> No permissions assigned to this role. <span class="text-danger">]</span></label>
         @endif
      </div>
   </div>
</div>
@endsection