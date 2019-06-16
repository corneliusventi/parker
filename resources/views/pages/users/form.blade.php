@input([
    'name' => 'fullname',
    'required' => true,
    'value' => isset($user) ? $user->fullname : old('fullname'),
])
    Fullname
@endinput

@input([
    'name' => 'username',
    'required' => true,
    'value' => isset($user) ? $user->username : old('username'),
])
    Username
@endinput

@input([
    'type' => 'email',
    'name' => 'email',
    'required' => true,
    'value' => isset($user) ? $user->email : old('email'),
])
    Email
@endinput
@select([
    'name' => 'role',
    'required' => true,
    'options' => $roles,
    'selected' => isset($user) ? $user->roles->first() : App\Role::where('name', old('role'))->first()
])
    Role
@endselect

@input([
    'type' => 'password',
    'name' => 'password',
    'required' => isset($user) ? false : true,
])
    Password
@endinput

@input([
    'type' => 'password',
    'name' => 'password_confirmation',
    'required' => isset($user) ? false : true,
])
    Password Confimation
@endinput