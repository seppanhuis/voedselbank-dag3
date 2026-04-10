<?php

namespace App\Http\Controllers;

use App\Models\Allergie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;
 
class AllergieController extends Controller
{
    private Allergie $allergieModel;

    public function __construct()
    {
        $this->allergieModel = new Allergie();
    }

    public function index(Request $request): View
    {
        $selectedAllergieId = $request->integer('allergie_id');

        try {
            $allergieen = $this->allergieModel->getAllAllergieen();
            $gezinnen = $this->allergieModel->getGezinnenMetAllergie($selectedAllergieId ?: null);
        } catch (Throwable $exception) {
            Log::error('Fout bij ophalen overzicht gezinsallergieen', [
                'message' => $exception->getMessage(),
            ]);

            return view('allergie.index', [
                'title' => 'Overzicht gezinnen met allergieen',
                'allergieen' => [],
                'gezinnen' => [],
                'selectedAllergieId' => $selectedAllergieId,
                'error' => 'Het ophalen van gegevens is mislukt. Controleer de technische log.',
            ]);
        }

        $showNoDataWarning = !is_null($selectedAllergieId) && count($gezinnen) === 0;

        return view('allergie.index', [
            'title' => 'Overzicht gezinnen met allergieen',
            'allergieen' => $allergieen,
            'gezinnen' => $gezinnen,
            'selectedAllergieId' => $selectedAllergieId,
            'showNoDataWarning' => $showNoDataWarning,
        ]);
    }

    public function showGezin(int $gezinId): View|RedirectResponse
    {
        try {
            $gezin = $this->allergieModel->getGezinById($gezinId);
            $details = $this->allergieModel->getAllergieDetailsPerGezin($gezinId);
        } catch (Throwable $exception) {
            Log::error('Fout bij ophalen allergie details per gezin', [
                'gezinId' => $gezinId,
                'message' => $exception->getMessage(),
            ]);

            return redirect()->route('allergie.index')
                ->with('error', 'Technische fout bij het ophalen van het gezin.');
        }

        if (!$gezin) {
            return redirect()->route('allergie.index')
                ->with('error', 'Het geselecteerde gezin bestaat niet.');
        }

        return view('allergie.details', [
            'title' => 'Allergieen in het gezin',
            'gezin' => $gezin,
            'details' => $details,
        ]);
    }

    public function editPersoon(int $persoonId): View|RedirectResponse
    {
        try {
            $persoonAllergie = $this->allergieModel->getPersoonAllergieData($persoonId);
            $allergieen = $this->allergieModel->getAllAllergieen();
        } catch (Throwable $exception) {
            Log::error('Fout bij ophalen wijzigscherm allergie', [
                'persoonId' => $persoonId,
                'message' => $exception->getMessage(),
            ]);

            return redirect()->route('allergie.index')
                ->with('error', 'Technische fout bij het openen van het wijzigscherm.');
        }

        if (!$persoonAllergie) {
            return redirect()->route('allergie.index')
                ->with('error', 'Persoon of allergie niet gevonden.');
        }

        $showMedicalWarning = in_array(
            strtolower((string)$persoonAllergie->AnafylactischRisico),
            ['hoog', 'redelijkhoog'],
            true
        );

        return view('allergie.edit', [
            'title' => 'Wijzig allergie',
            'persoonAllergie' => $persoonAllergie,
            'allergieen' => $allergieen,
            'showMedicalWarning' => $showMedicalWarning,
        ]);
    }

    public function updatePersoon(Request $request, int $persoonId): RedirectResponse
    {
        $validated = $request->validate([
            'allergie_id' => 'required|integer|min:1',
            'allergie_per_persoon_id' => 'required|integer|min:1',
            'gezin_id' => 'required|integer|min:1',
        ]);

        try {
            $affectedRows = $this->allergieModel->updatePersoonAllergie(
                (int)$validated['allergie_per_persoon_id'],
                (int)$validated['allergie_id']
            );
        } catch (Throwable $exception) {
            Log::error('Fout bij wijzigen allergie', [
                'persoonId' => $persoonId,
                'payload' => $validated,
                'message' => $exception->getMessage(),
            ]);

            return back()->withInput()->with(
                'error',
                'De wijziging kon niet worden doorgevoerd door een technische fout.'
            );
        }

        if ($affectedRows <= 0) {
            return back()->withInput()->with(
                'error',
                'Er is geen wijziging doorgevoerd.'
            );
        }

        return redirect()->route('allergie.persoon.edit', ['persoonId' => $persoonId])
            ->with('success', 'De wijziging is doorgevoerd')
            ->with('redirect_to_gezin', (int)$validated['gezin_id']);
    }
}
