<div class="row">
    <div class="col-md-12">
       <div class="card-group m-b-30">
          <div class="card">
             <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                   <div>
                      <span class="d-block">Current Worktype :</span>
                   </div>
                </div>
                <h3 class="mb-3">{{ $current_worktype_name }}</h3>
                <div class="progress mb-2" style="height: 5px;">
                   <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
             </div>
          </div>
          <div class="card">
             <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                   <div>
                      <span class="d-block">Current Worktype Price :</span>
                   </div>
                </div>
                <h3 class="mb-3">{{ $current_worktype_price }}</h3>
                <div class="progress mb-2" style="height: 5px;">
                   <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
             </div>
          </div>
          <div class="card">
             <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                   <div>
                      <span class="d-block">Advance Debit <a href="{{ route('users.advcashlist',$user->id) }}"><span class="badge badge-primary ml-1 p-1">Full list</span></a></span>
                   </div>
                </div>
                <h3 class="mb-3">₹ <span class="advance">{{ $advancecash }}</span></h3>
                <div class="progress mb-2" style="height: 5px;">
                   <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
             </div>
          </div>
          <div class="card">
             <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                   <div>
                      <span class="d-block">Total Qty :</span>
                   </div>
                </div>
                <h3 class="mb-3 total_qty">{{ $qtysum }}</h3>
                <div class="progress mb-2" style="height: 5px;">
                   <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
             </div>
          </div>
          <div class="card">
             <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                   <div>
                      <span class="d-block">Net Payable Amount :</span>
                   </div>
                </div>
                <h3 class="mb-3">₹ <span class="net_amount">{{ $total }}</span></h3>
                <div class="progress mb-2" style="height: 5px;">
                   <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>