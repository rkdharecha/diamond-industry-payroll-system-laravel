@extends('layouts.app')
@section('title')
Edit User
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
         <h3 class="page-title">Edit User</h3>
      </div>
      <div class="col-auto float-right ml-auto">
         <a href="{{ route('users.index') }}" class="btn add-btn add-user"> Back </a>
      </div>
   </div>
</div>
{!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
<div class="row">
   <div class="col-xs-12 col-sm-12 col-md-6 mb-2">
      <div class="form-group">
         <strong>Name:</strong>
         {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
      </div>
   </div>
   <div class="col-xs-12 col-sm-12 col-md-6 mb-2">
      <div class="form-group">
         <strong>Email:</strong>
         {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
      </div>
   </div>
   <div class="col-xs-12 col-sm-12 col-md-6 mb-2">
      <div class="form-group">
         <strong>Password:</strong>
         {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
      </div>
   </div>
   <div class="col-xs-12 col-sm-12 col-md-6 mb-2">
      <div class="form-group">
         <strong>Confirm Password:</strong>
         {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
      </div>
   </div>
   <div class="col-xs-12 col-sm-12 col-md-6">
      <div class="form-group">
         <strong>WorkType:</strong>
         <select name="work_type" class="form-control select">
         @foreach ($worktypes as $worktype)
         <option value="{{ $worktype->id }}" {{ $worktype->id == $user->work_type ? 'selected' : '' }}>{{ $worktype->name }}</option>
         @endforeach
         </select>
      </div>
   </div>
   <div class="col-xs-12 col-sm-12 col-md-6">
      <div class="form-group">
         <strong>Role:</strong>
         {!! Form::select('roles[]', $roles,$userRole, array('class' => 'select')) !!}
      </div>
   </div>
   <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
      <button type="submit" class="btn btn-primary">Submit</button>
   </div>
</div>
{!! Form::close() !!}
@endsection