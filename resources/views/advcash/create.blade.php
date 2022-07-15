@extends('layouts.app')

@section('title')
    Add Advance Cash
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
          <h3 class="page-title"> Add Advance Cash</h3>
        </div>
        <div class="col-auto float-right ml-auto">
          <a href="{{ route('cash.index') }}" class="btn add-btn add-cash"> Back </a>
        </div>
      </div>
</div>
{!! Form::open(array('route' => 'cash.store','method'=>'POST')) !!}
<div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 mb-2">
        <div class="form-group">
            <strong id="date_advance">User:</strong>
             <select name="user" id="user_id" class="form-control select selectsearch">
                 <option value="">--select--</option>
                 @foreach ($users as $user)
                 <option value="{{ $user->id }}">{{ $user->name }}</option>
                 @endforeach
             </select>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-4 mb-2">
        <div class="form-group">
            <strong id="date_advance">Date:</strong>
            <input type="date" class="form-control" name="date_advance" max="{{ date('Y-m-d') }}" id="date_advance">
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-4 mb-2">
      <div class="form-group">
        <strong>Amount:</strong>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">₹</span>
          </div>
          <input type="number" name="amount" step="0.01" class="form-control">
          <div class="input-group-append">
            <span class="input-group-text">.00</span>
          </div>
        </div>
      </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
        <div class="form-group">
            <strong id="notes">Notes :</strong>
            <textarea class="form-control" name="notes" id="notes"></textarea>
        </div>
      </div>
    <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
{!! Form::close() !!}
@endsection
