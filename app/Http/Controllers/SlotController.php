<?php

namespace App\Http\Controllers;

use PDF;
use App\Slot;
use Illuminate\Http\Request;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SlotController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage,App\Slot');

        $this->middleware(function ($request, $next)
        {
            if(!auth()->user()->parkingLot) {
                abort(403);
            }

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $this->authorize('read', Slot::class);


        if ($request->ajax()) {
            return Laratables::recordsOf(Slot::class, function ($query)
            {
                return $query->whereHas('parkingLot', function ($query)
                {
                    $query->where('user_id', auth()->id());
                });
            });
        } else {
            return view('pages.slots.index');
        }
    }

    public function create()
    {
        $this->authorize('create', Slot::class);

        $parkingLot = auth()->user()->parkingLot;
        $code = Slot::code($parkingLot);

        return view('pages.slots.create', compact('code', 'parkingLot'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Slot::class);

        $request->validate([
            'level' => 'sometimes|required|integer',
        ]);

        try {
            DB::beginTransaction();

            $parkingLot = auth()->user()->parkingLot;
            $level = $request->level;
            $code = Slot::code($parkingLot, $level);

            $parkingLot->slots()->create([
                'code' => $code,
                'level' => $level,
                'qrcode' => base64_encode(QrCode::format('png')->merge('/public/apple-icon.png')->size(500)->generate($code)),
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('slots.index')->withStatus('Slot could not been saved');
        }

        return redirect()->route('slots.index')->withStatus('Slot has been saved');
    }

    public function print(Slot $slot)
    {
        $this->authorize('print', $slot);

        $pdf = PDF::loadView('pages.slots.pdf', compact('slot'));
        return $pdf->download($slot->code.'.pdf');
    }

    public function code(Request $request)
    {
        if (auth()->user()->parkingLot) {
            $parkingLot = auth()->user()->parkingLot;
            $code = Slot::code($parkingLot, $request->level);

            return response()->json(['status' => 'success', 'code' => $code], 200);

        } else {
            return response()->json(['status' => 'error', 'error' => 'Parking Lot Not Found'], 404);
        }
    }
}
