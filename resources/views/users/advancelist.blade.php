@extends('layouts.app')
@section('title')
{{ $user->name }}'s Advance Cash Debit history
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
         <h3 class="page-title">{{ $user->name }}'s Advance Cash Debit history</h3>
         <input type="hidden" name="user_id" value="{{ $user->id }}" id="user_id">
      </div>
      <div class="col-auto float-right ml-auto">
         <button onclick="history.back()" class="btn add-btn"> Back </button>
      </div>
   </div>
</div>
<div class="col-md-12 col-sm-12 col-lg-12 col-xl-12 mb-1">
   <div class="stats-info" style="border: 1px solid black;">
      <h6>Total Advance Debit Cash</h6>
      <h4 id="total_amount">{{ $total }}</h4>
   </div>
</div>
<div class="container box">
   <div class="panel panel-default">
      <div class="panel-heading">
         <div class="row">
            <div class="col-xs-4 form-inline">
               <div class="input-daterange input-group" id="datepicker">
                  <input type="text" class="input-sm form-control" id="start" name="start" value="{{ date('Y-m-01') }}"/>
                  <span class="input-group-addon mt-3 ml-2 mr-2">to</span>
                  <input type="text" class="input-sm form-control" id="end"  name="end" value="{{ date('Y-m-t') }}"/>
               </div>
               <button type="button" id="dateSearch" class="btn btn-sm btn-primary ml-2"><i class="las la-search"></i></button>
               <button type="button" id="refresh" class="btn btn-sm btn-primary ml-2"><i class="las la-redo-alt"></i></button>
            </div>
         </div>
      </div>
      <div class="panel-body mt-3">
         <div class="table-responsive">
            <div class="table-responsive">
               <table class="data-table table table-stripped">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Reason</th>
                        <th>Amount</th>
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('scripts')

<script>
   $(document).ready(function(){
      $('.input-daterange').datepicker({
         todayBtn: 'linked',
         format: 'yyyy-mm-dd',
         autoclose: true
      });
   });
</script>

<script>
   
    $(function () {

    var id = $('#user_id').val();
    var makeurl = '{{ route("users.advcashlist",":id") }}';
    var ajaxurl = makeurl.replace(':id', id);

    var table = $('.data-table').DataTable({
         processing: true,
         serverSide: true,
         pageLength: 10,
         scrollY: false,
         scrollX: false,
         ajax: {
          url: ajaxurl,
          data: function (d) {
                d.user_id = $('#user_id').val(),
                d.from_date = $('input[name=start]').val(),
                d.to_date = $('input[name=end]').val(),
                d.search = $('input[type="search"]').val()
            }
          },
         columns: [
             {data: 'DT_RowIndex',name: 'DT_RowIndex',orderable: false, searchable: false},
             {data: 'date_advance',orderable: false},
             {data: 'notes',orderable: false},
             {data: 'amount', orderable: false},
         ]
     });

      jQuery(document).on('click', '#dateSearch', function() {

         var _token = $("input[name='_token']").val();
         var user_id = $('#user_id').val();
         var from_date = $('input[name=start]').val();
         var to_date = $('input[name=end]').val();
         var url = '{{ route("cash.fetch_data") }}';
         var ajaxtype = 'filter';

         $.ajax({
            url: url,
            type:'POST',
            data: {_token:_token,"user_id":user_id,"from_date":from_date,"to_date":to_date,"ajaxtype":ajaxtype},
            success: function(data) {
               var response = data;
               $('#total_amount').html(response.advancecash);
               table.draw();
            }
         });

          return false;

      });

      jQuery(document).on('click', '#refresh', function() {

         var _token = $("input[name='_token']").val();
         var user_id = $('#user_id').val();
         var from_date = $('input[name=start]').val();
         var to_date = $('input[name=end]').val();
         var url = '{{ route("cash.fetch_data") }}';
         var ajaxtype = 'refresh';

         $.ajax({
            url: url,
            type:'POST',
            data: {_token:_token,"user_id":user_id,"from_date":from_date,"to_date":to_date,"ajaxtype":ajaxtype},
            success: function(data) {
               var from = "{{ date('Y-m-01') }}";
               var to = "{{ date('Y-m-t') }}";
               var response = data;
               $('#total_amount').html(response.advancecash);
               $('#start').val(from);
               $('#end').val(to);
               table.draw();
            }
         });

          return false;

      });
     
   });
</script>
@endsection