<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
       <div id="sidebar-menu" class="sidebar-menu">
          <ul>
             @if(auth()->user()->hasRole('Employee'))
             <li class="{{ $page_name === 'Employee Dashboard' ? 'active' : '' }}">
               <a href="{{ route('home') }}"><i class="la la-dashboard"></i> <span>Dashboard</span></a>
             </li>
             @else
             <li class="{{ $page_name === 'Dashboard' ? 'active' : '' }}">
                <a href="{{ route('home') }}"><i class="la la-dashboard"></i> <span>Dashboard</span></a>
             </li>
             @endif
             @if(auth()->user()->hasRole('SuperAdmin') || auth()->user()->hasRole('Manager'))
             <li class="submenu">
               <a href="javascript:void(0);"><i class="la la-users"></i> </i> <span> Users</span> <span class="menu-arrow"></span></a>
             <ul>
            @can('user-list')
             <li> 
               <a href="{{ route('users.index') }}"   class="{{ $page_name === 'UserList' ? 'active' : ''}}"><span>Users</span></a>
            </li>
            @endcan
            @can('user-create')
             <li> 
               <a href="{{ route('users.create') }}" class="{{ $page_name === 'Create User' ? 'active' : ''}}"><span>Create</span></a>
            </li>
            @endcan
             </ul>
             </li>
            @can('role-list')
            <li class="submenu">
               <a href="javascript:void(0);"><i class="las la-user-tag"></i><span> Manage</span> <span class="menu-arrow"></span></a>
               <ul>
                  <li><a href="{{ route('roles.index') }}" class="{{ $page_name === 'RoleList' ? 'active' : '' }}">Roles</a></li>
                  
                  @can('role-create')
                  <li><a href="{{ route('roles.create') }}" class="{{ $page_name === 'Create Role' ? 'active' : '' }}">Create</a></li>
                  @endcan
               </ul>
            </li>
            @endcan
            @endif

         @can('worktype-list')
           <li class="submenu">
            <a href="javascript:void(0);"><i class="las la-briefcase"></i><span> WorkTypes</span> <span class="menu-arrow"></span></a>
            <ul>
               <li><a href="{{ route('worktypes.index') }}" class="{{ $page_name === 'WorkTypeList' ? 'active' : '' }}">WorkTypes</a></li>
               @can('worktype-create')
               <li><a href="{{ route('worktypes.create') }}" class="{{ $page_name === 'Create WorkType' ? 'active' : '' }}">Create</a></li>
               @endcan
            </ul>
         </li>
         @endcan
         
         
         @if(auth()->user()->hasRole('Manager'))
         <li class="submenu">
            <a href="javascript:void(0);"><i class="las la-hands-helping"></i><span> Services</span> <span class="menu-arrow"></span></a>
            <ul>
               <li><a href="{{ route('cash.index') }}" class="
                  @if($page_name == 'AdvanceCashList' OR $page_name == 'AddAdvanceCash' OR $page_name == 'EditAdvanceCash')
                  active
                  @else
                  @endif
                  ">Cash Advance</a></li>
            </ul>
         </li>
         @endif
          </ul>
       </div>
    </div>
 </div>