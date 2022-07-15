<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use App\Models\User;
use App\Models\Worktype;
use App\Models\Timesheet;
use App\Models\CashAdvance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class TimeSheetController extends Controller
{
    public function assign(Request $request){

        $this->validate($request, [
            'date' => 'required',
            'qty' => 'required'
        ]);
        
        $user = User::find($request->user_id);
         
        $worktype = Worktype::where('id',$user->work_type)->first();

        $price = $worktype->price;

        $type = $worktype->name;

        $Qty = $request->qty;

        $total = $price * $Qty;

        $total = number_format((float)$total,2,'.','');
        
        if (Timesheet::where('user_id',$request->user_id)->where('date', $request->date)->exists()) {
            return redirect()->back()->with('failed',"Timesheet with this date already exist.");
        }

        $input = $request->all();
        $timesheets = new Timesheet();
        $timesheets->user_id = $input['user_id'];
        $timesheets->date = $input['date'];
        $timesheets->qty = $input['qty'];
        $timesheets->price = $price;
        $timesheets->type = $type;
        $timesheets->total = $total;
        $timesheets->save();

        return redirect()->back()->with('success','Work Assigned To '.$timesheets->user->name.' for date ('.date('j F Y',strtotime($timesheets->date)).') with the quantity of '.$timesheets->qty.' Diamonds.');
    }
  
    public function fetch_data(Request $request){
        
        if($request->ajax())
        {
            if($request->from_date != '' && $request->to_date != '' && $request->ajaxtype == 'filter')
            {
                $id = $request->user_id;

                $qtysum = Timesheet::query()->where('user_id',$id)
                    ->whereBetween('date', array($request->from_date, $request->to_date))
                    ->sum('qty');

                $total = Timesheet::query()->where('user_id',$id)
                ->whereBetween('date', array($request->from_date, $request->to_date))
                ->sum('total');

                $advancecash = CashAdvance::query()->where('user_id',$id)
                ->whereBetween('date_advance', array($request->from_date, $request->to_date))
                ->sum('amount');

                $advancecash = number_format((float)$advancecash, 2, '.', '');

                $total = ($total - $advancecash);

                $total = number_format((float)$total, 2, '.', '');
                
                return Response::JSON(array('advancecash' => $advancecash,'total' => $total,'qtysum' => $qtysum));

            }else{

                $id = $request->user_id;

                $qtysum = Timesheet::query()->where('user_id',$id)
                    ->whereBetween('date', array(date('Y-m-01'), date('Y-m-t')))
                    ->sum('qty');

                $total = Timesheet::query()->where('user_id',$id)
                ->whereBetween('date', array(date('Y-m-01'), date('Y-m-t')))
                ->sum('total');

                $advancecash = CashAdvance::query()->where('user_id',$id)
                ->whereBetween('date_advance', array(date('Y-m-01'), date('Y-m-t')))
                ->sum('amount');

                $advancecash = number_format((float)$advancecash, 2, '.', '');

                $total = ($total - $advancecash);

                $total = number_format((float)$total, 2, '.', '');
                
                return Response::JSON(array('advancecash' => $advancecash,'total' => $total,'qtysum' => $qtysum));

            }
        }
    }
}
