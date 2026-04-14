<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Klant extends Model
{
    protected $table = 'gezin';
    protected $primaryKey = 'Id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'Naam',
        'Code',
        'Omschrijving',
        'AantalVolwassenen',
        'AantalKinderen',
        'AantalBabys',
        'TotaalAantalPersonen',
        'IsActief',
        'Opmerking'
    ];

    /**
     * Haal alle klanten met contactgegevens op
     */
    public static function getAllKlantenWithContact()
    {
        return DB::select('CALL sp_GetAllKlantenWithContact()');
    }

    /**
     * Haal klanten op gefilterd op postcode
     */
    public static function getKlantenByPostcode($postcode)
    {
        return DB::select('CALL sp_GetKlantenByPostcode(?)', [$postcode]);
    }

    /**
     * Haal alle beschikbare postcodes op
     */
    public static function getAllPostcodes()
    {
        return DB::select('CALL sp_GetAllPostcodes()');
    }

    /**
     * Haal klantdetails op
     */
    public static function getKlantDetailsByGezinId($gezin_id)
    {
        $result = DB::select('CALL sp_GetKlantDetailsByGezinId(?)', [$gezin_id]);
        return count($result) > 0 ? $result[0] : null;
    }

    /**
     * Update klant persoonlijke gegevens
     */
    public static function updateKlantPersonalDetails($persoon_id, $data)
    {
        $result = DB::select('CALL sp_UpdateKlantPersonalDetails(?, ?, ?, ?)', [
            $persoon_id,
            $data['voornaam'],
            $data['tussenvoegsel'] ?? '',
            $data['achternaam']
        ]);

        return $result[0] ?? null;
    }

    /**
     * Update klant contactgegevens
     */
    public static function updateKlantContactGegevens($contact_id, $data)
    {
        $result = DB::select('CALL sp_UpdateKlantContactGegevens(?, ?, ?, ?, ?, ?, ?, ?)', [
            $contact_id,
            $data['straat'],
            $data['huisnummer'],
            $data['toevoeging'] ?? null,
            $data['postcode'],
            $data['woonplaats'],
            $data['email'],
            $data['mobiel']
        ]);

        return $result[0] ?? null;
    }
}
