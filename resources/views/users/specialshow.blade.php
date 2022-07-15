@extends('layouts.app')
@section('title')
Show User    
@endsection
@section('content')
<!-- Page Header -->
<div class="page-header">
   <div class="row align-items-center">
      <div class="col">
         <h3 class="page-title">{{ $user->name }}'s Details :</h3>
         <input type="hidden" name="user_id" value="{{ $user->id }}" id="user_id">
      </div>
   </div>
</div>
<!-- /Page Header -->
<div class="row p-4" style="border: 1px solid;">
   <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="form-group">
         <strong>Name:</strong>
         {{ $user->name }}
      </div>
   </div>
   <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="form-group">
         <strong>Email:</strong>
         {{ $user->email }}
      </div>
   </div>
   <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="form-group">
         <strong>Roles:</strong>
         @if(!empty($user->getRoleNames()))
         @foreach($user->getRoleNames() as $v)
         <label class="badge bg-success p-1">{{ $v }}</label>
         @endforeach
         @endif
      </div>
   </div>
</div>
@endsection