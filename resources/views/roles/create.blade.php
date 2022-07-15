@extends('layouts.app')
@section('title')
Create Role
@endsection
@section('content')
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
<div class="page-header">
   <div class="row align-items-center">
      <div class="col">
         <h3 class="page-title">Create Role</h3>
      </div>
      <div class="col-auto float-right ml-auto">
         <a href="{{ route('roles.index') }}" class="btn add-btn add-role"> Back </a>
      </div>
   </div>
</div>
{!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
<div class="row">
   <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
      <div class="form-group">
         <strong>Name:</strong>
         {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
      </div>
   </div>
   <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="form-group">
         <strong>Permission:</strong>
         <br/>
         @foreach($permission as $value)
         <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
         {{ $value->name }}</label>
         <br/>
         @endforeach
      </div>
   </div>
   <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
      <button type="submit" class="btn btn-primary">Submit</button>
   </div>
</div>
{!! Form::close() !!}
@endsection