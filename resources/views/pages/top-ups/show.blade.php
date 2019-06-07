@extends('layouts.bread.show', [
    'title' => 'Top Up',
    'details' => [
        [
            'name' => 'ID',
            'value' => $topUp->id,
        ],
        [
            'name' => 'User',
            'value' => $topUp->user->fullname,
        ],
        [
            'name' => 'Bank Name',
            'value' => strtoupper($topUp->bank_name),
        ],
        [
            'name' => 'Bank Account Number',
            'value' => $topUp->bank_account_number,
        ],
        [
            'name' => 'Bank Account Name',
            'value' => $topUp->bank_account_name,
        ],
        [
            'name' => 'Amount',
            'value' => 'Rp '.number_format($topUp->amount),
        ],
        [
            'name' => 'Receipt of Transfer',
            'value' => 'Preview',
            'link' => route('top-ups.receipt-transfer', $topUp->id),
        ],
        [
            'name' => 'Approved',
            'value' => $topUp->approved ? 'Approved' : 'Disapproved',
            'if' => !is_null($topUp->approved),
        ],
    ],
    'back' => route('top-ups.index'),
])
