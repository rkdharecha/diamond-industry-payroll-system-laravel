<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Worktype;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function index()
    {
        if(auth()->user()->hasRole('Employee')){

            $data = [
                'page_name' => 'Employee Dashboard'
            ];

            return view('employee_dashboard')->with($data);
           
        }else{

             $employeescount = User::with('roles');

             if(auth()->user()->hasRole('SuperAdmin')){
                 $employeescount = User::whereHas("roles", function($q){ $q->where("name", ["Employee"]); })->count();
             }else{
                 $employeescount = User::where('parent_id',auth()->user()->id)->whereHas("roles", function($q){ $q->where("name", ["Employee"]); })->count();
             }
              
             $admincount = User::whereHas("roles", function($q){ 
                 $q->where("name", ["Manager"]); 
             })
             ->count();

             $superadmincount = User::whereHas("roles", function($q){
                  $q->where("name", ["SuperAdmin"]); 
             })->count();

             $worktypes = Worktype::count();

             $data = [
                'page_name' => 'Dashboard',
                'employeescount' => $employeescount,
                'admincount' => $admincount,
                'superadmincount' => $superadmincount,
                'worktypes' => $worktypes
             ];

            return view('dashboard')->with($data);
        }
    }
}
