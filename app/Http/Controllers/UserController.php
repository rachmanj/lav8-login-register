<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index');
    }

    public function edit($id)
    {
        $user = User::find($id);
        $projects = Project::orderBy('project_code', 'asc')->get();

        return view('admin.users.edit', compact('user', 'projects'));
        
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if ($request->password) {
            $this->validate($request, [
                'name'          => 'required|min:3|max:255',
                'username'      => ['required','min:3','max:20', 'unique:users,username,'. $id],
                'email'         => ['email','unique:users,email,'. $id],
                'password'      => 'min:6',
                'password_confirmation' => 'required_with:password|same:password|min:6'
            ]);

            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->projects_id = $request->projects_id;
            $user->role = $request->role;
            $user->password = Hash::make($request->password);
            $user->save();

        } else {
            $this->validate($request, [
                'name'          => 'required|min:3|max:255',
                'username'      => ['required','min:3','max:20', 'unique:users,username,'. $id],
                'email'         => ['email','unique:users,email,'. $id],
            ]);

            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->projects_id = $request->projects_id;
            $user->role = $request->role;
            $user->save();
        }

        return redirect()->route('users.index')->with('status', 'Data successfully updated!');
    }

    public function activate_index()
    {
        return view('admin.users.activate.index');
    }

    public function activate_update($id)
    {
        $user = User::find($id);

        $user->active = 1;
        $user->update();

        return redirect()->route('user.activate_index')->with('status', 'User successfully activated');
    }

    public function deactivate_index()
    {
        return view('admin.users.activate.deactivate_index');
    }

    public function deactivate_update($id)
    {
        $user = User::find($id);

        $user->active = 0;
        $user->update();

        return redirect()->route('user.deactivate_index')->with('status', 'User successfully Deactivated');
    }

    public function change_password($id)
    {
        $user = User::findOrFail($id);
        return view('users.change-password', compact(['user']));
    }

    public function password_update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request, [
            'password'      => 'required|min:6',
            'password_confirmation' => 'required_with:password|same:password|min:6'
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('dashboard.index')->with('success', 'User password updated successfully');
    }
}
