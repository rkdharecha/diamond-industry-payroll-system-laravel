<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use DataTables;
use App\Models\Worktype;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class WorkTypeController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:worktype-list|worktype-create|worktype-edit|worktype-delete', ['only' => ['index','store']]);
         $this->middleware('permission:worktype-create', ['only' => ['create','store']]);
         $this->middleware('permission:worktype-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:worktype-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $worktypes = Worktype::query()->orderBy('id','DESC');

        $data = [
            'page_name' =>'WorkTypeList',
            'worktypes' => $worktypes,
        ];

        if ($request->ajax()) {
            $data =  $worktypes;
            return Datatables::of($data)
                      
                    ->addIndexColumn()
                    
                    ->addColumn('price', function($data){
   
                           $price = number_format((float)$data->price, 2, '.', '');
     
                          return $price;
                    })

                    ->addColumn('created_at', function($data){
   
                           $date = date('d-m-Y',strtotime($data->created_at));
     
                          return $date;
                    })
                    ->addColumn('action', function($data){
                        
                        $btn = '';

                        if(auth()->user()->can('worktype-edit')){
                           $btn .= '<a  href="'.route('worktypes.edit',$data->id).'" class="btn btn-sm mr-2 btn-primary show-worktypes"><i class="las la-edit"></i></a>'; 
                        }

                        if(auth()->user()->can('worktype-delete')){
                           $btn .= '<a  href="'.route('worktypes.destroy',$data->id).'" class="btn btn-sm btn-primary show-worktypes"><i class="las la-trash"></i></a>';
                        }
     
                        return $btn;

                    })

                    ->rawColumns(['created_at'],['action'])
                    
                    ->make(true);

                }

                return view('worktypes.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $data = [
            'page_name' =>'Create WorkType',
        ];

        return view('worktypes.create')->with($data);
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
            'price' => 'required'
        ]);

        $Worktype = new Worktype();
        $Worktype->name = $request->input('name');
        $Worktype->price = $request->input('price');
        $Worktype->save();

        return redirect()->route('worktypes.index')->with('success', 'WorkType created successfully'); 

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit(Request $request,$id)
    {
        $worktype = Worktype::findOrNew($id);

        $data = [
            'page_name' =>'Edit WorkType',
            'worktype' => $worktype
        ];

        return view('worktypes.edit')->with($data);
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
            'name' => 'required',
            'price' => 'required'
        ]);

        $worktype= Worktype::find($id);
        $worktype->name = $request->input('name');
        $worktype->price = $request->input('price');
        $worktype->save();
            
        return redirect()->route('worktypes.index')->with('success', 'WorkType updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy(Request $request,$id)
    {
        Worktype::find($id)->delete();

        return redirect()->route('worktypes.index')
        ->with('success','WorkType deleted successfully');
    }
}
