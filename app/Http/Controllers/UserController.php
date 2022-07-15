<?php
    
namespace App\Http\Controllers;
    
use DB;
use Auth;
use Hash;
use DataTables;
use App\Models\User;
use App\Models\Worktype;
use App\Models\Timesheet;
use App\Models\CashAdvance;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
    
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
         $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data1 = User::orderBy('id','DESC')->where('parent_id',auth()->user()->id)->get();

        $data2 = [
           'page_name' => 'UserList',
           'data' => $data1
        ];

        if ($request->ajax()) {
            $data =  $data1;
            return Datatables::of($data)
                    ->addIndexColumn()

                    ->addColumn('roles', function($data){

                        if(!empty($data->getRoleNames())){
                            $label = '';
                            foreach($data->getRoleNames() as $v){
                              $label .=  '<label class="badge text-white bg-success p-1">'.$v.'</label>';
                            }

                            return $label;
                        }

                    })

                    ->addColumn('created_at', function($data){

                        $date = date('d-m-Y',strtotime($data->created_at));
                        return $date;

                    })

                    ->addColumn('action', function($data){
                        
                        $btn = '';

                        $btn .= '<a href="'.route('users.show',$data->id).'" class="btn btn-sm btn-primary show-user"><i class="las la-eye"></i></a> ';

                        if(auth()->user()->can('user-edit')){

                            $btn .= '<a href="'.route('users.edit',$data->id).'" class="btn btn-sm btn-primary edit-user"><i class="las la-edit"></i></a> ';

                        }

                        if(auth()->user()->can('user-delete')){

                            $btn .= '<a href="'.route('users.destroy',$data->id).'" class="btn btn-sm btn-primary edit-user"><i class="las la-trash"></i></a> ';

                        }

                        $btn .= '<button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#assign_work_to_'.$data->id.'"><i class="las la-plus"></i></button>';

                        return $btn;
                    })

                    ->rawColumns(['roles'],['created_at'],['action'])

                    ->make(true);
        }


        return view('users.index')
            ->with($data2);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $roles = Role::pluck('name','name')->all();

        $worktypes = Worktype::all();
        
        $data = [
           'page_name' => 'Create User',
           'roles' => $roles,
           'worktypes' => $worktypes
        ];
        return view('users.create')->with($data);
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();

        $user = new User();
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = Hash::make($input['password']);
        $user->parent_id = auth()->user()->id;
        if($request->has('work_type')){
            $user->work_type = $input['work_type'];
        }else{
            $user->work_type = null;
        }
        $user->save();
        $user->assignRole($request->input('roles'));
        
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show(Request $request,$id)
    {
        $user = User::find($id);
        
        if(!$user->hasRole('Manager')){
            
            $data1 = Timesheet::query()->where('user_id',$id)
                           ->orderBy('date');

            $total = Timesheet::where('user_id',$id)
            ->whereBetween('date', array(date('Y-m-01'), date('Y-m-t')))
            ->sum('total');
    
            $advancecash = CashAdvance::where('user_id',$id)
            ->whereBetween('date_advance',array(date('Y-m-01'),date('Y-m-t')))
            ->sum('amount');

            $advancecash = number_format((float)$advancecash, 2, '.', '');
              
            $total = ($total - $advancecash);

            $total = number_format((float)$total, 2, '.', '');

            $user = User::withCount('timesheets')->find($id);
    
            $worktype = Worktype::where('id',$user->work_type)->first();
    
            $qtysum = Timesheet::where('user_id',$id)->whereMonth('date', date('m'))->sum('qty');

            $current_worktype_name = $worktype->name;
    
            $current_worktype_price = $worktype->price;
    
            $data = [
                'user' => $user,
                'page_name' => 'ShowUser',
                'total' => $total,
                'qtysum' => $qtysum,
                'current_worktype_name' => $current_worktype_name,
                'current_worktype_price' => $current_worktype_price,
                'advancecash' => $advancecash
            ];
    
            if ($request->ajax()) {
                $data =  $data1;
                return Datatables::of($data)
                        ->addIndexColumn()
    
                        ->addColumn('work_type',function($data){
                            $user = User::find($data->user_id);
                            $worktype = Worktype::where('id',$user->work_type)->first();
                            return $worktype->name;
                        })
    
                        ->addColumn('assign_date',function($data){
                            $date = date('d-m-Y',strtotime($data->date));
                            return $date;
                        })
    
                        ->filter(function ($query) use ($request) {
                            if (!empty($request->get('from_date') || $request->get('to_date'))){
                                $query->whereBetween('date', array($request->get('from_date'),$request->get('to_date')));
                            }
                        })
                        
    
                        ->rawColumns(['work_type'],['assign_date'])
                        ->make(true);
            }
    
            if($user->parent_id == auth()->user()->id OR auth()->user()->hasRole('SuperAdmin')){
            return view('users.show')->with($data);
            }else{
                return abort(404);
            }

        }else{
             
            $user = User::find($id);

            $data = [
                'user' => $user,
                'page_name' => 'ShowUser',
            ];

            return view('users.specialshow')->with($data);
             
        }
        

    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $user = User::find($id);
        
        if($user->parent_id == auth()->user()->id){
            $roles = Role::pluck('name','name')->all();
            $userRole = $user->roles->pluck('name','name')->all();
            $worktypes = Worktype::all();
            $data = [
               'page_name' => 'EditUser',
               'user' => $user,
               'roles' => $roles,
               'userRole' => $userRole,
               'worktypes' => $worktypes
            ];
            return view('users.edit')->with($data);
        }else{
            return abort(404);
        }
    
    }

    public function advcashlist(Request $request,$id){

        $user = User::find($id);

        $advancecash = CashAdvance::select('*');

        $advancecash = CashAdvance::query()->where('user_id',$id)
        ->orderBy('date_advance');

        $total = CashAdvance::query()->where('user_id',$id)
        ->whereBetween('date_advance', array(date('Y-m-01'), date('Y-m-t')))->sum('amount');

        $total = '₹ '.number_format((float)$total, 2, '.', '');

        $data1 = [
            'user' => $user,
            'page_name' => 'UserAdvanceCashList',
            'advancecash' => $advancecash,
            'total' => $total
        ];

        if ($request->ajax()) {
            $data =  $advancecash;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('date_advance',function($data){
                        $date = date('d-m-Y',strtotime($data->date_advance));
                        return $date;
                    })

                    ->filter(function ($query) use ($request) {
                        if (!empty($request->get('from_date') || $request->get('to_date'))){
                            $query->whereBetween('date_advance', array($request->get('from_date'),$request->get('to_date')));
                        }
                    })
                    ->rawColumns(['date_advance'])
                    ->make(true);
        }

        return view('users.advancelist')->with($data1);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        
        $user = User::find($id);
        $user->name = $input['name'];
        $user->email = $input['email'];
        if(!empty($input['password'])){ 
            $user->password = Hash::make($input['password']);
        }
        $user->parent_id = auth()->user()->id;
        $user->work_type = $input['work_type']; 
        $user->update();
        
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy(Request $request,$id)
    {
        User::find($id)->delete();

        return redirect()->route('users.index')
        ->with('success','User deleted successfully');
    }
}