<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.view', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hospitals = Hospital::all();
        $roles = Role::all();
        return view('users.add', compact('roles','hospitals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'role' => 'required|string|max:255|exists:roles,name',
                'hospital' => 'nullable|integer|exists:hospitals,id',
            ]
        );
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        // attach hospital if selected
        if($request->has('hospital') && $request->role == 'coordinator'){
            $user->hospitals()->attach($request->hospital);
        }
        $user->assignRole($request->role);
        return redirect()->back()->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hospitals = Hospital::all();
        $user = User::find($id);
        if($user->hasRole('admin') && auth()->user()->id != $id){
            return redirect()->back()->with('error', __('You can not edit admin user'));
        }
        $roles = Role::all();
        return view('users.add', compact('user', 'roles','hospitals'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'password' => 'nullable|string|min:6|confirmed',
                'role' => 'required|string|max:255|exists:roles,name',
                'hospital' => 'nullable|integer|exists:hospitals,id',
            ]
        );
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        // detach hospitals and attach new hospital if selected
        $user->hospitals()->detach();
        if($request->has('hospital') && $request->role == 'coordinator'){
            $user->hospitals()->attach($request->hospital);
        }
        if(auth()->user()->id != $id)
            $user->syncRoles($request->role);
        
        return redirect()->back()->with('success', __('User updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
