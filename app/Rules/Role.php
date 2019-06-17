<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\User;

class Role implements Rule
{
    public $role;
    public $roles;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($role)
    {
        if (is_array($role)) {
            $this->roles = $role;
        } else {
            $this->role = $role;
        }
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = User::find($value);

        if (!$user instanceof User) {
            return false;
        }

        if ($this->role) {
            return $user->isA($this->role);
        } else {
            $roles = collect($this->roles);
            return $roles->contains(function ($value, $key) use ($user)
            {
                return $user->isA($value);
            });
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
