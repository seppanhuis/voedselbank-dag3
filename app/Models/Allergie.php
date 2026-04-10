<?php

namespace App\Models;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Allergie
{
    public function getAllAllergieen(): array
    {
        return DB::select('CALL sp_GetAllAllergieen()');
    }

    public function getGezinnenMetAllergie(?int $allergieId = null): array
    {
        try {
            return DB::select('CALL sp_GetGezinnenMetAllergie(?)', [$allergieId]);
        } catch (QueryException $exception) {
            // Fallback if procedures are not created yet.
            $query = DB::table('Gezin as g')
                ->join('Persoon as p', 'p.GezinId', '=', 'g.Id')
                ->join('AllergiePerPersoon as ap', 'ap.PersoonId', '=', 'p.Id')
                ->join('Allergie as a', 'a.Id', '=', 'ap.AllergieId')
                ->leftJoin('Persoon as v', function ($join) {
                    $join->on('v.GezinId', '=', 'g.Id')->where('v.IsVertegenwoordiger', '=', 1);
                })
                ->select(
                    'g.Id as GezinId',
                    'g.Naam',
                    'g.Omschrijving',
                    'g.AantalVolwassenen',
                    'g.AantalKinderen',
                    'g.AantalBabys',
                    DB::raw("CONCAT(v.Voornaam, ' ', COALESCE(v.Tussenvoegsel, ''), ' ', v.Achternaam) as Vertegenwoordiger")
                )
                ->where('g.IsActief', '=', 1)
                ->where('ap.IsActief', '=', 1)
                ->groupBy(
                    'g.Id',
                    'g.Naam',
                    'g.Omschrijving',
                    'g.AantalVolwassenen',
                    'g.AantalKinderen',
                    'g.AantalBabys',
                    'v.Voornaam',
                    'v.Tussenvoegsel',
                    'v.Achternaam'
                )
                ->orderBy('g.Naam', 'asc');

            if (!is_null($allergieId)) {
                $query->where('a.Id', '=', $allergieId);
            }

            return $query->get()->all();
        }
    }

    public function getAllergieDetailsPerGezin(int $gezinId): array
    {
        return DB::select('CALL sp_GetAllergieDetailsPerGezin(?)', [$gezinId]);
    }

    public function getGezinById(int $gezinId): ?object
    {
        $rows = DB::select('CALL sp_GetGezinById(?)', [$gezinId]);

        return $rows[0] ?? null;
    }

    public function getPersoonAllergieData(int $persoonId): ?object
    {
        $rows = DB::select('CALL sp_GetPersoonAllergieData(?)', [$persoonId]);

        return $rows[0] ?? null;
    }

    public function updatePersoonAllergie(int $allergiePerPersoonId, int $nieuweAllergieId): int
    {
        $rows = DB::select('CALL sp_UpdatePersoonAllergie(?, ?)', [$allergiePerPersoonId, $nieuweAllergieId]);

        return (int)($rows[0]->affected ?? 0);
    }
}
