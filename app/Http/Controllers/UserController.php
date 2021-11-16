<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\DataTables\UserDataTable;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('app.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();

        return response()->json(['success' => view('app.users.create', compact('roles'))->render()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newUser = new CreateNewUser();
        $user = $newUser->create($request->only(['name', 'email', 'role_id', 'password', 'password_confirmation']));

        if ($user) {
            return response()->json(['success' => 'New record has been created!']);
        }

        return response()->assertStatus(200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();

        return response()->json(['success' => view('app.users.edit', compact('user', 'roles'))->render()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email,' .$user->id,
            'name' => 'required'
        ]);

        if ($validator->passes()) {
            $user->email = $request->email;
            $user->name = $request->name;
            $user->role_id = $request->role_id;
            $user->save();

            return response()->json(['success' => 'Record has been updated!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['success' => 'Record has been deleted!']);
    }
}
