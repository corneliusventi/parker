@extends('layouts.bread.action', [
    'show' => route('user.show', $user->id),
    'edit' => route('user.edit', $user->id),
    'delete' => route('user.destroy', $user->id),
])