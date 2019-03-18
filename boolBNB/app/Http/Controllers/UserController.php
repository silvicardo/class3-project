<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $newUser = new User();
        $newUser->fill($data);
        $newUser->save();

        return redirect()->route('users.index');

    
    }

    public function show(User $user)
    {
        if (empty($user)) {
            abort(404);
        }

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if (empty($user))
        {
            abort(404);
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $data = $request->all();

        $user->update($data);

        return redirect()->back();
    }

    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();

        return redirect()->back();
    }
}
