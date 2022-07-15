<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
    
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    function __construct()
    {
         $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {
        $roles = Role::query()->orderBy('id','DESC');

        $data = [
          'page_name' => 'RoleList',
          'roles' => $roles
        ];

        if ($request->ajax()) {
            $data =  $roles;

            return Datatables::of($data)
            
                    ->addIndexColumn()

                    ->addColumn('created_at',function($data){

                         $date = date('d-m-Y',strtotime($data->created_at));

                         return $date;
                    })

                    ->addColumn('action',function($data){
                        
                        $btn = '';

                        $btn .= '<a href="'.route('roles.show',$data->id).'" class="btn btn-sm btn-primary show-user"><i class="las la-eye"></i></a> ';

                        if(auth()->user()->can('role-edit')){

                           $btn .= '<a href="'.route('roles.edit',$data->id).'" class="btn btn-sm btn-primary edit-user"><i class="las la-edit"></i></a> ';

                        }

                        if(auth()->user()->can('role-delete')){

                           $btn .= '<a href="'.route('roles.destroy',$data->id).'" class="btn btn-sm btn-primary edit-user"><i class="las la-trash"></i></a> ';

                        }

                        return $btn;


                     })

                     ->rawColumns(['created_at'],['action'])
                    ->make(true);
        }

        return view('roles.index')->with($data);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $permission = Permission::get();

        $data = [
           'page_name' => 'Create Role',
           'permission' => $permission
        ];
        return view('roles.create')->with($data);
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
            'name' => 'required|unique:roles,name',
        ]);
    
        $role = Role::create(['name' => $request->input('name')]);

        if(isset($request->permission[0])){
            $role->syncPermissions($request->input('permission'));
        }else{
            $role->syncPermissions($request->input('permission'));
        }
    
        return redirect()->route('roles.index')
                        ->with('success','Role created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();

        $data = [
            'page_name' => 'ShowRole',
            'role' => $role,
            'rolePermissions' => $rolePermissions
        ];
    
        return view('roles.show')->with($data);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        $data = [
           'page_name' => 'EditRole',
           'role' => $role,
           'permission' => $permission,
           'rolePermissions' => $rolePermissions
        ];
    
        return view('roles.edit')->with($data);
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
        ]);
    
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
    
        if(isset($request->permission[0])){
            $role->syncPermissions($request->input('permission'));
        }else{
            $role->syncPermissions($request->input('permission'));
        }
    
        return redirect()->route('roles.index')
                        ->with('success','Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
                        ->with('success','Role deleted successfully');
    }
}