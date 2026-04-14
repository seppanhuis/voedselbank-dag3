<?php

namespace App\Http\Controllers;

use App\Models\Klant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KlantController extends Controller
{
    /**
     * Toon overzicht van alle klanten
     */
    public function index(Request $request)
    {
        $postcodes = Klant::getAllPostcodes();
        $klantenData = [];
        $selectedPostcode = $request->input('postcode');

        if ($selectedPostcode) {
            $klantenData = Klant::getKlantenByPostcode($selectedPostcode);
        } else {
            $klantenData = Klant::getAllKlantenWithContact();
        }

        return view('klant.index', [
            'klanten' => $klantenData,
            'postcodes' => $postcodes,
            'selectedPostcode' => $selectedPostcode
        ]);
    }

    /**
     * Toon klant details
     */
    public function show($id)
    {
        $klant = Klant::getKlantDetailsByGezinId($id);

        if (!$klant) {
            return redirect()->route('klant.index')->with('error', 'Klant niet gevonden');
        }

        return view('klant.show', ['klant' => $klant]);
    }

    /**
     * Toon bewerk formulier
     */
    public function edit($id)
    {
        $klant = Klant::getKlantDetailsByGezinId($id);

        if (!$klant) {
            return redirect()->route('klant.index')->with('error', 'Klant niet gevonden');
        }

        return view('klant.edit', ['klant' => $klant]);
    }

    /**
     * Update klant contactgegevens
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'contact_id' => 'required|integer',
            'persoon_id' => 'required|integer',
            'voornaam' => 'required|string|max:100',
            'tussenvoegsel' => 'nullable|string|max:50',
            'achternaam' => 'required|string|max:100',
            'straat' => 'required|string|max:100',
            'huisnummer' => 'required|string|max:10',
            'toevoeging' => 'nullable|string|max:20',
            'postcode' => ['required', 'string', 'max:6', 'regex:/^[0-9]{4}(TH|TJ|ZE|ZH)$/i'],
            'woonplaats' => 'required|string|max:100',
            'email' => 'required|string|max:255',
            'mobiel' => 'required|string|max:25'
        ], [
            'postcode.regex' => 'Deze postcode komt niet uit de regio Maaskantje',
            'postcode.max' => 'Postcode mag maximaal 6 karakters zijn',
            'postcode.required' => 'Postcode is verplicht',
        ]);

        // Update personal details via stored procedure
        Log::info('Updating klant personal details', ['persoon_id' => $validated['persoon_id'], 'data' => $validated]);
        
        $personalResult = Klant::updateKlantPersonalDetails($validated['persoon_id'], [
            'voornaam' => $validated['voornaam'],
            'tussenvoegsel' => $validated['tussenvoegsel'],
            'achternaam' => $validated['achternaam']
        ]);

        Log::info('Personal update result', ['result' => $personalResult]);

        // Update contact gegevens via stored procedure
        Log::info('Updating klant contact details', ['contact_id' => $validated['contact_id']]);
        
        $contactResult = Klant::updateKlantContactGegevens($validated['contact_id'], [
            'straat' => $validated['straat'],
            'huisnummer' => $validated['huisnummer'],
            'toevoeging' => $validated['toevoeging'],
            'postcode' => $validated['postcode'],
            'woonplaats' => $validated['woonplaats'],
            'email' => $validated['email'],
            'mobiel' => $validated['mobiel']
        ]);

        Log::info('Contact update result', ['result' => $contactResult]);

        if ($contactResult) {
            if ($contactResult->success == 1) {
                return redirect()->route('klant.edit', $id)
                    ->with('success', 'Alle gegevens zijn succesvol gewijzigd');
            } else {
                return redirect()->route('klant.edit', $id)
                    ->with('error', 'De contactgegevens van de geselecteerde klant kunnen niet gewijzigd')
                    ->withErrors(['postcode' => $contactResult->message]);
            }
        }

        return redirect()->route('klant.edit', $id)
            ->with('error', 'Er is een fout opgetreden bij het bijwerken van de klantgegevens');
    }
}
