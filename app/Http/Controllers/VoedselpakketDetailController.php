<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voedselpakket;
use App\Models\Gezin;

class VoedselpakketDetailController extends Controller
{
    public function show($gezinId)
    {
        $voedselpakketten = Voedselpakket::getByGezinId($gezinId);
        $gezin = Gezin::where('Id', $gezinId)->first();

        return view('voedselpakket.details', compact('voedselpakketten', 'gezin'));
    }

    public function edit($pakketId)
    {
        $pakket = Voedselpakket::getById($pakketId);

        // ✅ NULL CHECK
        if (!$pakket) {
            return redirect()->back()->with('error', 'Voedselpakket niet gevonden');
        }

        // Extra check op hoofdlettergebruik property
        $gezinIngeschreven = $pakket->IsIngeschreven ?? $pakket->isIngeschreven ?? false;

        // Toon unhappy scenario direct als gezin niet is ingeschreven
        if (!$gezinIngeschreven) {
            return redirect()->back()->with('error', 'Dit gezin is niet meer ingeschreven bij de voedselbank en daarom kan er geen voedselpakket worden uitgereikt');
        }

        return view('voedselpakket.edit', compact('pakket', 'gezinIngeschreven'));
    }

    public function update(Request $request, $pakketId)
    {
        $request->validate([
            'status' => 'required|in:Niet Uitgereikt,Uitgereikt,NietMeerIngeschreven'
        ]);

        $pakket = Voedselpakket::getById($pakketId);

        // ✅ NULL CHECK (belangrijk!)
        if (!$pakket) {
            return redirect()->back()->with('error', 'Voedselpakket niet gevonden');
        }

        $gezinId = $pakket->GezinId;
        $gezinIngeschreven = $pakket->IsIngeschreven ?? $pakket->isIngeschreven ?? false;

        // Als gekozen is voor "NietMeerIngeschreven", status direct updaten
        if ($request->status === 'NietMeerIngeschreven') {
            Voedselpakket::updateStatus($pakketId, $request->status);
            return redirect()
                ->route('voedselpakket.details', ['gezinId' => $gezinId])
                ->with('success', 'De status is gewijzigd naar: Gezin niet meer ingeschreven bij de voedselbank');
        }

        if ($gezinIngeschreven) {
            Voedselpakket::updateStatus($pakketId, $request->status);

            return redirect()
                ->route('voedselpakket.details', ['gezinId' => $gezinId])
                ->with('success', 'De wijziging is doorgevoerd');
        }

        return redirect()
            ->back()
            ->with('error', 'Dit gezin is niet meer ingeschreven bij de voedselbank en daarom kan er geen voedselpakket worden uitgereikt');
    }
}
