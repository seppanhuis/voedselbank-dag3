<?php

namespace App\Http\Controllers;

use App\Models\Leverancier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class LeverancierController extends Controller
{
    private Leverancier $leverancierModel;

    public function __construct()
    {
        $this->leverancierModel = new Leverancier();
    }

    public function index(Request $request): View
    {
        $selectedType = trim((string)$request->query('leverancier_type', ''));
        $selectedType = $selectedType !== '' ? $selectedType : null;

        try {
            $leverancierTypes = $this->leverancierModel->getLeverancierTypes();
            $leveranciers = $this->leverancierModel->getLeveranciersOverzicht($selectedType);
        } catch (Throwable $exception) {
            Log::error('Fout bij ophalen overzicht leveranciers', [
                'selectedType' => $selectedType,
                'message' => $exception->getMessage(),
            ]);

            return view('leverancier.index', [
                'title' => 'Overzicht Leveranciers',
                'leverancierTypes' => [],
                'leveranciers' => [],
                'selectedType' => $selectedType,
                'showNoDataWarning' => false,
                'error' => 'Het ophalen van de leveranciers is mislukt. Controleer de technische log.',
            ]);
        }

        $showNoDataWarning = !is_null($selectedType) && count($leveranciers) === 0;

        return view('leverancier.index', [
            'title' => 'Overzicht Leveranciers',
            'leverancierTypes' => $leverancierTypes,
            'leveranciers' => $leveranciers,
            'selectedType' => $selectedType,
            'showNoDataWarning' => $showNoDataWarning,
        ]);
    }

    public function showProducten(int $leverancierId): View|RedirectResponse
    {
        try {
            $leverancier = $this->leverancierModel->getLeverancierById($leverancierId);
            $producten = $this->leverancierModel->getProductenPerLeverancier($leverancierId);
        } catch (Throwable $exception) {
            Log::error('Fout bij ophalen producten per leverancier', [
                'leverancierId' => $leverancierId,
                'message' => $exception->getMessage(),
            ]);

            return redirect()->route('leverancier.index')
                ->with('error', 'Technische fout bij het ophalen van producten van de leverancier.');
        }

        if (!$leverancier) {
            return redirect()->route('leverancier.index')
                ->with('error', 'De geselecteerde leverancier bestaat niet.');
        }

        return view('leverancier.producten', [
            'title' => 'Overzicht producten',
            'leverancier' => $leverancier,
            'producten' => $producten,
        ]);
    }

    public function editProduct(int $productPerLeverancierId): View|RedirectResponse
    {
        try {
            $product = $this->leverancierModel->getProductPerLeverancierById($productPerLeverancierId);
        } catch (Throwable $exception) {
            Log::error('Fout bij openen wijzig product', [
                'productPerLeverancierId' => $productPerLeverancierId,
                'message' => $exception->getMessage(),
            ]);

            return redirect()->route('leverancier.index')
                ->with('error', 'Technische fout bij het openen van het wijzigscherm.');
        }

        if (!$product) {
            return redirect()->route('leverancier.index')
                ->with('error', 'Het geselecteerde product bestaat niet.');
        }

        return view('leverancier.edit-product', [
            'title' => 'Wijzig Product',
            'product' => $product,
        ]);
    }

    public function updateProduct(Request $request, int $productPerLeverancierId): RedirectResponse
    {
        $validated = $request->validate([
            'houdbaarheidsdatum' => 'required|date',
            'leverancier_id' => 'required|integer|min:1',
        ]);

        try {
            $result = $this->leverancierModel->updateProductHoudbaarheidsdatum(
                $productPerLeverancierId,
                (string)$validated['houdbaarheidsdatum']
            );
        } catch (Throwable $exception) {
            Log::error('Fout bij wijzigen houdbaarheidsdatum van product', [
                'productPerLeverancierId' => $productPerLeverancierId,
                'payload' => $validated,
                'message' => $exception->getMessage(),
            ]);

            return back()->withInput()->with(
                'error',
                'De houdbaarheidsdatum is niet gewijzigd door een technische fout.'
            );
        }

        if (($result['affected'] ?? 0) > 0) {
            return redirect()->route('leverancier.product.edit', ['productPerLeverancierId' => $productPerLeverancierId])
                ->with('success', 'De houdbaarheidsdatum is gewijzigd');
        }

        if (($result['reason'] ?? '') === 'MAX_7_DAYS') {
            return back()->withInput()->with(
                'error',
                'De houdbaarheidsdatum is niet gewijzigd'
            )->with(
                'validation_error',
                'De houdbaarheidsdatum mag met maximaal 7 dagen worden verlengd'
            );
        }

        return back()->withInput()->with(
            'error',
            'De houdbaarheidsdatum is niet gewijzigd'
        );
    }
}
