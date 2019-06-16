<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Illuminate\Http\Request;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage,App\User');
    }

    public function index(Request $request)
    {
        $this->authorize('browse', User::class);

        if ($request->ajax()) {
            return Laratables::recordsOf(User::class, function ($query) {
                if (auth()->user()->isA('superadministrator')) {
                    return $query->whereIsNot('superadministrator');
                } else {
                    return $query->whereIs('operator');
                }
            });
        } else {
            return view('pages.users.index');
        }

    }

    public function create()
    {
        $this->authorize('add', User::class);

        if (auth()->user()->isA('superadministrator')) {
            $roles = Role::whereNotIn('name', ['superadministrator'])->get();
        } else {
            $roles = Role::whereIn('name', ['operator'])->get();
        }

        return view('pages.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->authorize('add', User::class);

        $request->validate([
            'fullname' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|string|unique:users,email',
            'role' => 'required|string|exists:roles,name',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'fullname' => $request->fullname,
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $user->assign($request->role);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('users.index')->withStatus('User could not been saved');
        }

        return redirect()->route('users.index')->withStatus('User has been saved');
    }

    public function show(User $user)
    {
        $this->authorize('read', $user);

        return view('pages.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('edit', $user);

        if (auth()->user()->isA('superadministrator')) {
            $roles = Role::whereNotIn('name', ['superadministrator'])->get();
        } else {
            $roles = Role::whereIn('name', ['operator'])->get();
        }

        return view('pages.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $this-> authorize('edit', $user);

        $request->validate([
            'fullname' => 'required|string',
            'username' => 'required|string|unique:users,username,'.$user->id,
            'email' => 'required|string|unique:users,email,'.$user->id,
            'role' => 'required|string|exists:roles,name',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        try {
            DB::beginTransaction();

            $user->update([
                'fullname' => $request->fullname,
                'username' => $request->username,
                'email' => $request->email,
            ]);

            if ($request->password) {
                $user->update([
                    'password' => bcrypt($request->password),
                ]);
            }

            $user->retract($user->roles()->first()->name);

            $user->assign($request->role);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('users.index')->withStatus('User could not been updated');
        }

        return redirect()->route('users.index')->withStatus('User has been updated');
    }
    public function destroy(Request $request, User $user)
    {
        $this-> authorize('delete', $user);

        try {
            DB::beginTransaction();

            $user->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('users.index')->withStatus('User could not been deleted');
        }

        return redirect()->route('users.index')->withStatus('User has been deleted');
    }
}
