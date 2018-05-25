<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use DB;
use Auth;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::check()) {
            $roles = Role::all();
            return view('roles.index', ['roles' => $roles]);
        }
        return back()->with('errors','Login first');
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if (Auth::check()) {
            $role = Role::create([
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
                    'status' => 1
            ]);

            if ($role) {
                return back()->with('success','Role created successfully');
            }
            return back()->with('errors','Error creating role');
        }
        return back()->with('errors','Login first');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
        if (Auth::check()) {
            $role = Role::find($role->id);
            return view('roles.edit', ['role' => $role]);
        }
        return back()->with('errors','Login first');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
        if (Auth::check()) {
            $role = Role::where('id', $role->id)
                    ->update([
                        'name' => $request['name'],
                        'description' => $request['description']
                    ]);

            if ($role) {
                return back()->with('success','Role update successfully');
            }
            return back()->with('success','Error updating role');
        }
        return back()->with('errors','Login first');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }

    public function userRoles()
    {
        //
        if (Auth::check()) {
            $user_roles = DB::table('role_user')
                            ->select(DB::raw(
                                'role_user.id, roles.name as rname, users.name'
                            ))
                            ->join('users', 'users.id', '=', 'role_user.user_id')
                            ->join('roles', 'roles.id', '=', 'role_user.role_id')
                            ->get();
            return view('roles.user_roles',['roleusers' => $user_roles]);
        }
        return back()->with('errors','Login first');
    }
}
