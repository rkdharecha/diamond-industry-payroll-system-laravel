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
      <div class="col-auto float-right ml-auto">
         <button onclick="history.back()" class="btn add-btn"> Back </button>
      </div>
   </div>
</div>

@include('users.advcash-data-cards')

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
            <table class="table table-striped data-table table-bordered" id="try">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Work Type</th>
                     <th>Assign Date</th>
                     <th>Qty</th>
                     <th>Price</th>
                     <th>Total</th>
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

<script type="text/javascript">
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
        var makeurl = '{{ route("users.show",":id") }}';
        var ajaxurl = makeurl.replace(':id', id);

        var table = $('.data-table').DataTable({
          processing: false,
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
              {data: 'work_type', orderable: false},
              {data: 'assign_date', orderable: false},
              {data: 'qty', orderable: false},
              {data: 'price', orderable: false},
              {data: 'total', orderable: false},
          ]
      });

      jQuery(document).on('click', '#dateSearch', function() {
         var _token = $("input[name='_token']").val();
         var user_id = $('#user_id').val();
         var from_date = $('input[name=start]').val();
         var to_date = $('input[name=end]').val();
         var url = '{{ route("timesheets.fetch_data") }}';
         var ajaxtype = 'filter';

         $.ajax({
            url: url,
            type:'POST',
            data: {_token:_token,"user_id":user_id,"from_date":from_date,"to_date":to_date,"ajaxtype":ajaxtype},
            success: function(data) {
               var response = data;
               $('.advance').html(response.advancecash);
               $('.total_qty').html(response.qtysum);
               $('.net_amount').html(response.total);
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
         var url = '{{ route("timesheets.fetch_data") }}';
         var ajaxtype = 'refresh';

         $.ajax({
            url: url,
            type:'POST',
            data: {_token:_token,"user_id":user_id,"from_date":from_date,"to_date":to_date,"ajaxtype":ajaxtype},
            success: function(data) {
               var from = "{{ date('Y-m-01') }}";
               var to = "{{ date('Y-m-t') }}";
               var response = data;
               $('.advance').html(response.advancecash);
               $('.total_qty').html(response.qtysum);
               $('.net_amount').html(response.total);
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