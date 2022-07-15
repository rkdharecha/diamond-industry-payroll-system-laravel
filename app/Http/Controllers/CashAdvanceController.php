<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use DataTables;
use App\Models\User;
use App\Models\Timesheet;
use App\Models\CashAdvance;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CashAdvanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:cash-list|cash-create|cash-edit|cash-delete', ['only' => ['index','store']]);
         $this->middleware('permission:cash-create', ['only' => ['create','store']]);
         $this->middleware('permission:cash-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:cash-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $advcashdata = CashAdvance::query()->with('user')->orderBy('id','desc');

        $advcashdata = $advcashdata->whereHas("user",function ($query){
            $query->where('parent_id','=',auth()->user()->id); 
        });

        $data = [
            'page_name' => 'AdvanceCashList',
        ];

        if ($request->ajax()) {
            $data =  $advcashdata;
            return Datatables::of($data)
                      
                    ->addIndexColumn()
                    
                    ->addColumn('user_name', function($data){
   
                           $user_name = '<a href="'.route('users.show',$data->user->id).'" style="color:black;"><span>'.$data->user->name.'</span></a>';
     
                          return $user_name;
                    })
                    ->addColumn('date_advance', function($data){
   
                           $date_advance = date('d-m-Y',strtotime($data->date_advance));
     
                          return $date_advance;
                    })

                    ->addColumn('action', function($data){
                        
                        $btn = '';

                        if(auth()->user()->can('cash-edit')){
                           $btn .= '<a  href="'.route('cash.edit',$data->id).'" class="btn btn-sm mr-2 btn-primary show-worktypes"><i class="las la-edit"></i></a>'; 
                        }

                        if(auth()->user()->can('cash-delete')){
                           $btn .= '<a  href="'.route('cash.destroy',$data->id).'" class="btn btn-sm btn-primary show-worktypes"><i class="las la-trash"></i></a>';
                        } 
     
                        return $btn;
                    })

                    ->rawColumns(['user_name'],['date_advance'],['action'])
                    
                    ->make(true);

                }
        
        return view('advcash.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {
        $users = User::where('parent_id',auth()->user()->id)->get();

        $data = [
           'page_name' => 'AddAdvanceCash',
           'users' => $users
        ];

        return view('advcash.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'user' => 'required',
            'date_advance' => 'required',
            'amount' => 'required'
        ]);

        $CashAdvance = new CashAdvance();
        $CashAdvance->user_id = $request->input('user');
        $CashAdvance->date_advance = $request->input('date_advance');
        $CashAdvance->amount = $request->input('amount');
        $CashAdvance->notes = $request->input('notes');
        $CashAdvance->save();


        return redirect()->route('cash.index')->with('success', 'Advance Cash added successfully'); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $CashAdvance = CashAdvance::findOrNew($id);

        $users = User::where('parent_id',auth()->user()->id)->get();

        $data = [
            'page_name' => 'EditAdvanceCash',
            'CashAdvance' => $CashAdvance,
            'users' => $users
        ];

        return view('advcash.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'user' => 'required',
            'date_advance' => 'required',
            'amount' => 'required'
        ]);

        $CashAdvance= CashAdvance::find($id);
        $CashAdvance->user_id = $request->input('user');
        $CashAdvance->amount = $request->input('amount');
        $CashAdvance->date_advance = $request->input('date_advance');
        $CashAdvance->notes = $request->input('notes');
        $CashAdvance->save();

            
        return redirect()->route('cash.index')->with('success', 'Advance Cash Emtry updated successfully');
        
    }


    public function fetch_data(Request $request){
        
        if($request->ajax())
        {
            if($request->from_date != '' && $request->to_date != '' && $request->ajaxtype == 'filter')
            {
                $id = $request->user_id;
                
                $advancecash = CashAdvance::query()->where('user_id',$id)
                ->whereBetween('date_advance', array($request->from_date, $request->to_date))
                ->sum('amount');

                $advancecash = '₹ '.number_format((float)$advancecash, 2, '.', '');

                return Response::JSON(array('advancecash' => $advancecash));

            }else{

                $id = $request->user_id;
                
                $advancecash = CashAdvance::query()->where('user_id',$id)
                ->whereBetween('date_advance', array(date('Y-m-01'),date('Y-m-t')))
                ->sum('amount');

                $advancecash = '₹ '.number_format((float)$advancecash, 2, '.', '');

                return Response::JSON(array('advancecash' => $advancecash));

            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request,$id)
    {
        CashAdvance::find($id)->delete();

        return redirect()->route('cash.index')
        ->with('success','Advance Cash Entry deleted successfully');
    }
}