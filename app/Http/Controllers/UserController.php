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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('read', User::class);
        if ($request->ajax()) {
            return Laratables::recordsOf(User::class, function ($query) {
                if (auth()->user()->isA('superadministrator')) {
                    return $query->whereIsNot('superadministrator');
                } else {
                    return $query->whereIsNot('superadministrator', 'administrator');
                }
            });
        } else {
            return view('pages.users.index');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);

        if (auth()->user()->isA('superadministrator')) {
            $roles = Role::whereNotIn('name', ['superadministrator'])->get();
        } else {
            $roles = Role::whereNotIn('name', ['superadministrator', 'administrator'])->get();
        }

        return view('pages.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('store', User::class);

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

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('show', $user);

        return view('pages.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('edit', $user);

        if (auth()->user()->isA('superadministrator')) {
            $roles = Role::whereNotIn('name', ['superadministrator'])->get();
        } else {
            $roles = Role::whereNotIn('name', ['superadministrator', 'administrator'])->get();
        }

        return view('pages.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

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
                'password' => bcrypt($request->password),
            ]);

            if ($request->password) {
                $user->update([
                    'password' => bcrypt($request->password),
                ]);
            }

            $user->retract($user->roles->first()->name);

            $user->assign($request->role);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('users.index')->withStatus('User could not been updated');
        }

        return redirect()->route('users.index')->withStatus('User has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        try {
            DB::beginTransaction();

            $user->delete();

            DB::commit();
        } catch (Excaption $e) {
            DB::rollBack();

            return redirect()->route('users.index')->withStatus('User could not been deleted');
        }

        return redirect()->route('users.index')->withStatus('User has been deleted');
    }
}
