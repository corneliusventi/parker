<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TopUp;
use Freshbitsweb\Laratables\Laratables;

class TopUpController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:topup')->only(['topUp', 'toUppping', 'upload']);
        $this->middleware('can:manage,App\TopUp')->only(['index', 'receiptTransfer', 'approve', 'disapprove']);
    }

    public function topUp()
    {
        $topUps = auth()->user()->topUps->filter(function ($topUp) {
            return is_null($topUp->approved);
        });

        $topUp = $topUps->first();

        if (!$topUp) {
            $mode = 'top-up';
            return view('pages.top-up', compact('mode'));
        } else if (is_null($topUp->receipt_transfer)) {
            $mode = 'transfer';
            return view('pages.top-up', compact('mode', 'topUp'));
        } else if (is_null($topUp->approved)) {
            $mode = 'success';
            return view('pages.top-up', compact('mode', 'topUp'));
        }
    }

    public function topUpping(Request $request)
    {
        TopUp::create([
            'bank_name'           => $request->input('bank_name'),
            'bank_account_number' => $request->input('bank_account_number'),
            'bank_account_name'   => $request->input('bank_account_name'),
            'amount'              => $request->input('amount'),
            'user_id'             => auth()->id(),
        ]);

        return redirect()->route('top-up.index')->withStatus('Top Up Wallet Successful');
    }

    public function upload(Request $request)
    {
        $topUps = auth()->user()->topUps->filter(function ($topUp) {
            return is_null($topUp->approved);
        });

        $topUp = $topUps->first();

        if ($topUp) {
            $topUp->update([
                'receipt_transfer' => $request->file('receipt_transfer')->store('receipt_transfers')
            ]);
            return redirect()->route('top-up.index')->withStatus('Top Up Successful');
        } else {
            return redirect()->route('top-up.index')->withStatus('Top Up First');
        }
    }

    public function index(Request $request)
    {
        $this->authorize('read', TopUp::class);

        if ($request->ajax()) {
            return Laratables::recordsOf(TopUp::class, function ($query) {
                return $query->orderBy('created_at', 'desc');
            });
        } else {
            return view('pages.top-ups.index');
        }
    }

    public function show(Request $request, TopUp $topUp)
    {
        return view('pages.top-ups.show', compact('topUp'));
    }

    public function receiptTransfer(Request $request, TopUp $topUp)
    {
        return response()->file(storage_path('/app//' . $topUp->receipt_transfer));
    }

    public function approve(Request $request, TopUp $topUp)
    {
        $topUp->update([
            'approved' => true,
        ]);

        $user = $topUp->user;
        $user->wallet += $topUp->amount;
        $user->save();

        return redirect()->route('top-ups.index')->withStatus('Approval Top Up Successful');
    }

    public function disapprove(Request $request, TopUp $topUp)
    {
        $topUp->update([
            'approved' => false,
        ]);

        return redirect()->route('top-ups.index')->withStatus('Disapproval Top Up Successful');
    }
}
