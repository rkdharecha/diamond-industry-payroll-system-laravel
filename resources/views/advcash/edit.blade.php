@extends('layouts.app')

@section('title')
    Edit Advance Cash
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
              <h3 class="page-title">Edit Advance Cash</h3>
            </div>
            <div class="col-auto float-right ml-auto">
              <a href="{{ route('cash.index') }}" class="btn add-btn"> Back </a>
            </div>
          </div>
    </div>

    {!! Form::model($CashAdvance, ['method' => 'POST','route' => ['cash.update', $CashAdvance->id]]) !!}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 mb-2">
            <div class="form-group">
                <strong id="user">User:</strong>
                <select name="user" id="user" class="form-control select">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $user->id == $CashAdvance->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 mb-2">
            <div class="form-group">
                <strong id="date_advance">Date:</strong>
                <input type="date" name="date_advance" id="date_advance" class="form-control" value="{{ $CashAdvance->date_advance }}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 mb-2">
            <div class="form-group">
              <strong>Amount:</strong>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">₹</span>
                </div>
                <input type="number" step="0.01" class="form-control" name="amount" value="{{ $CashAdvance->amount }}">
                <div class="input-group-append">
                  <span class="input-group-text">.00</span>
                </div>
              </div>
             
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
          <div class="form-group">
              <strong id="notes">Notes :</strong>
              <textarea class="form-control" name="notes" id="notes">{{ $CashAdvance->notes }}</textarea>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </div>
    {!! Form::close() !!}
@endsection