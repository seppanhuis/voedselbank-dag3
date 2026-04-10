<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Leverancier
{
    public function getLeverancierTypes(): array
    {
        try {
            return DB::select('CALL sp_GetLeverancierTypes()');
        } catch (QueryException $exception) {
            return DB::table('Leverancier')
                ->select('LeverancierType')
                ->where('IsActief', '=', 1)
                ->distinct()
                ->orderBy('LeverancierType', 'asc')
                ->get()
                ->all();
        }
    }

    public function getLeveranciersOverzicht(?string $leverancierType = null): array
    {
        try {
            return DB::select('CALL sp_GetLeveranciersOverzicht(?)', [$leverancierType]);
        } catch (QueryException $exception) {
            $query = DB::table('Leverancier as l')
                ->join('ContactPerLeverancier as cpl', function ($join) {
                    $join->on('cpl.LeverancierId', '=', 'l.Id')
                        ->where('cpl.IsActief', '=', 1);
                })
                ->join('Contact as c', function ($join) {
                    $join->on('c.Id', '=', 'cpl.ContactId')
                        ->where('c.IsActief', '=', 1);
                })
                ->select(
                    'l.Id as LeverancierId',
                    'l.Naam',
                    'l.ContactPersoon',
                    'c.Email',
                    'c.Mobiel',
                    'l.LeverancierNummer',
                    'l.LeverancierType'
                )
                ->where('l.IsActief', '=', 1)
                ->orderBy('l.Naam', 'asc');

            if (!empty($leverancierType)) {
                $query->where('l.LeverancierType', '=', $leverancierType);
            }

            return $query->get()->all();
        }
    }

    public function getLeverancierById(int $leverancierId): ?object
    {
        try {
            $rows = DB::select('CALL sp_GetLeverancierById(?)', [$leverancierId]);

            return $rows[0] ?? null;
        } catch (QueryException $exception) {
            return DB::table('Leverancier')
                ->select('Id', 'Naam', 'LeverancierNummer', 'LeverancierType')
                ->where('Id', '=', $leverancierId)
                ->where('IsActief', '=', 1)
                ->first();
        }
    }

    public function getProductenPerLeverancier(int $leverancierId): array
    {
        try {
            return DB::select('CALL sp_GetProductenPerLeverancier(?)', [$leverancierId]);
        } catch (QueryException $exception) {
            return DB::table('ProductPerLeverancier as ppl')
                ->join('Product as p', function ($join) {
                    $join->on('p.Id', '=', 'ppl.ProductId')
                        ->where('p.IsActief', '=', 1);
                })
                ->select(
                    'ppl.Id as ProductPerLeverancierId',
                    'p.Id as ProductId',
                    'p.Naam',
                    'p.Barcode',
                    'p.Houdbaarheidsdatum',
                    'p.Status'
                )
                ->where('ppl.LeverancierId', '=', $leverancierId)
                ->where('ppl.IsActief', '=', 1)
                ->orderBy('p.Naam', 'asc')
                ->get()
                ->all();
        }
    }

    public function getProductPerLeverancierById(int $productPerLeverancierId): ?object
    {
        try {
            $rows = DB::select('CALL sp_GetProductPerLeverancierById(?)', [$productPerLeverancierId]);

            return $rows[0] ?? null;
        } catch (QueryException $exception) {
            return DB::table('ProductPerLeverancier as ppl')
                ->join('Product as p', function ($join) {
                    $join->on('p.Id', '=', 'ppl.ProductId')
                        ->where('p.IsActief', '=', 1);
                })
                ->join('Leverancier as l', function ($join) {
                    $join->on('l.Id', '=', 'ppl.LeverancierId')
                        ->where('l.IsActief', '=', 1);
                })
                ->select(
                    'ppl.Id as ProductPerLeverancierId',
                    'l.Id as LeverancierId',
                    'l.Naam as LeverancierNaam',
                    'p.Id as ProductId',
                    'p.Naam as ProductNaam',
                    'p.Houdbaarheidsdatum'
                )
                ->where('ppl.Id', '=', $productPerLeverancierId)
                ->where('ppl.IsActief', '=', 1)
                ->first();
        }
    }

    public function updateProductHoudbaarheidsdatum(int $productPerLeverancierId, string $nieuweHoudbaarheidsdatum): array
    {
        try {
            $rows = DB::select(
                'CALL sp_UpdateProductHoudbaarheidsdatum(?, ?)',
                [$productPerLeverancierId, $nieuweHoudbaarheidsdatum]
            );

            $result = $rows[0] ?? null;

            return [
                'affected' => (int)($result->affected ?? 0),
                'reason' => (string)($result->reason ?? ''),
            ];
        } catch (QueryException $exception) {
            $record = DB::table('ProductPerLeverancier as ppl')
                ->join('Product as p', function ($join) {
                    $join->on('p.Id', '=', 'ppl.ProductId')
                        ->where('p.IsActief', '=', 1);
                })
                ->select('p.Id as ProductId', 'p.Houdbaarheidsdatum')
                ->where('ppl.Id', '=', $productPerLeverancierId)
                ->where('ppl.IsActief', '=', 1)
                ->first();

            if (!$record) {
                return ['affected' => 0, 'reason' => 'NOT_FOUND'];
            }

            $huidigeDatum = Carbon::parse($record->Houdbaarheidsdatum);
            $nieuweDatum = Carbon::parse($nieuweHoudbaarheidsdatum);

            if ($nieuweDatum->greaterThan($huidigeDatum->copy()->addDays(7))) {
                return ['affected' => 0, 'reason' => 'MAX_7_DAYS'];
            }

            $affected = DB::table('Product')
                ->where('Id', '=', (int)$record->ProductId)
                ->where('IsActief', '=', 1)
                ->update([
                    'Houdbaarheidsdatum' => $nieuweDatum->toDateString(),
                    'DatumGewijzigd' => now(),
                ]);

            return [
                'affected' => (int)$affected,
                'reason' => $affected > 0 ? 'UPDATED' : 'NOT_UPDATED',
            ];
        }
    }
}
