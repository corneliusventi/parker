@extends('layouts.bread.action', [
    'show' => route('users.show', $user->id),
    'edit' => route('users.edit', $user->id),
    'delete' => route('users.destroy', $user->id),
])