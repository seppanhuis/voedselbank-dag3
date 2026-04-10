<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // sp_GetAllKlantenWithContact
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GetAllKlantenWithContact');
        DB::unprepared('
            CREATE PROCEDURE sp_GetAllKlantenWithContact()
            BEGIN
                SELECT
                    G.Id as GezinId,
                    G.Naam as NaamGezin,
                    CONCAT(COALESCE(P.Voornaam, ""), " ", COALESCE(P.Tussenvoegsel, ""), " ", COALESCE(P.Achternaam, "")) as Vertegenwoordiger,
                    C.Email,
                    C.Mobiel,
                    CONCAT(C.Straat, " ", C.Huisnummer, COALESCE(CONCAT(" ", C.Toevoeging), "")) as Adres,
                    C.Woonplaats,
                    C.Postcode
                FROM Gezin G
                LEFT JOIN Persoon P ON G.Id = P.GezinId AND P.IsVertegenwoordiger = 1
                LEFT JOIN ContactPerGezin CPG ON G.Id = CPG.GezinId
                LEFT JOIN Contact C ON CPG.ContactId = C.Id
                WHERE G.IsActief = 1 AND CPG.IsActief = 1 AND C.IsActief = 1
                ORDER BY G.Id ASC;
            END
        ');

        // sp_GetKlantenByPostcode
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GetKlantenByPostcode');
        DB::unprepared('
            CREATE PROCEDURE sp_GetKlantenByPostcode(
                IN p_postcode VARCHAR(10)
            )
            BEGIN
                SELECT
                    G.Id as GezinId,
                    G.Naam as NaamGezin,
                    CONCAT(COALESCE(P.Voornaam, ""), " ", COALESCE(P.Tussenvoegsel, ""), " ", COALESCE(P.Achternaam, "")) as Vertegenwoordiger,
                    C.Email,
                    C.Mobiel,
                    CONCAT(C.Straat, " ", C.Huisnummer, COALESCE(CONCAT(" ", C.Toevoeging), "")) as Adres,
                    C.Woonplaats,
                    C.Postcode
                FROM Gezin G
                LEFT JOIN Persoon P ON G.Id = P.GezinId AND P.IsVertegenwoordiger = 1
                LEFT JOIN ContactPerGezin CPG ON G.Id = CPG.GezinId
                LEFT JOIN Contact C ON CPG.ContactId = C.Id
                WHERE G.IsActief = 1 AND CPG.IsActief = 1 AND C.IsActief = 1
                AND C.Postcode = p_postcode
                ORDER BY G.Id ASC;
            END
        ');

        // sp_GetAllPostcodes
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GetAllPostcodes');
        DB::unprepared('
            CREATE PROCEDURE sp_GetAllPostcodes()
            BEGIN
                SELECT DISTINCT
                    C.Postcode
                FROM Contact C
                WHERE C.IsActief = 1
                ORDER BY C.Postcode ASC;
            END
        ');

        // sp_GetKlantDetailsByGezinId
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GetKlantDetailsByGezinId');
        DB::unprepared('
            CREATE PROCEDURE sp_GetKlantDetailsByGezinId(
                IN p_gezin_id INT UNSIGNED
            )
            BEGIN
                SELECT
                    G.Id as GezinId,
                    G.Naam as NaamGezin,
                    CONCAT(COALESCE(P.Voornaam, ""), " ", COALESCE(P.Tussenvoegsel, ""), " ", COALESCE(P.Achternaam, "")) as Vertegenwoordiger,
                    P.Id as PersoonId,
                    COALESCE(P.Voornaam, "") as Voornaam,
                    COALESCE(P.Tussenvoegsel, "") as Tussenvoegsel,
                    COALESCE(P.Achternaam, "") as Achternaam,
                    P.Geboortedatum,
                    P.TypePersoon,
                    C.Straat,
                    C.Huisnummer,
                    COALESCE(C.Toevoeging, "") as Toevoeging,
                    C.Postcode,
                    C.Woonplaats,
                    C.Email,
                    C.Mobiel,
                    C.Id as ContactId,
                    CPG.Id as ContactPerGezinId
                FROM Gezin G
                LEFT JOIN Persoon P ON G.Id = P.GezinId AND P.IsVertegenwoordiger = 1
                LEFT JOIN ContactPerGezin CPG ON G.Id = CPG.GezinId
                LEFT JOIN Contact C ON CPG.ContactId = C.Id
                WHERE G.Id = p_gezin_id AND G.IsActief = 1;
            END
        ');

        // sp_UpdateKlantPersonalDetails
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_UpdateKlantPersonalDetails');
        DB::unprepared('
            CREATE PROCEDURE sp_UpdateKlantPersonalDetails(
                IN p_persoon_id INT UNSIGNED,
                IN p_voornaam VARCHAR(100),
                IN p_tussenvoegsel VARCHAR(50),
                IN p_achternaam VARCHAR(100)
            )
            BEGIN
                UPDATE Persoon
                SET
                    Voornaam = p_voornaam,
                    Tussenvoegsel = p_tussenvoegsel,
                    Achternaam = p_achternaam,
                    DatumGewijzigd = SYSDATE(6)
                WHERE Id = p_persoon_id;
                
                SELECT 1 as success, "De persoonlijke gegevens zijn gewijzigd" as message;
            END
        ');

        // sp_UpdateKlantContactGegevens
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_UpdateKlantContactGegevens');
        DB::unprepared('
            CREATE PROCEDURE sp_UpdateKlantContactGegevens(
                IN p_contact_id INT UNSIGNED,
                IN p_straat VARCHAR(100),
                IN p_huisnummer VARCHAR(10),
                IN p_toevoeging VARCHAR(20),
                IN p_postcode VARCHAR(10),
                IN p_woonplaats VARCHAR(100),
                IN p_email VARCHAR(255),
                IN p_mobiel VARCHAR(25)
            )
            BEGIN
                DECLARE is_valid_postcode TINYINT DEFAULT 0;
                
                -- Controleer of postcode in regio Maaskantje valt (52xx postcodes)
                IF SUBSTRING(p_postcode, 1, 2) = "52" THEN
                    SET is_valid_postcode = 1;
                END IF;
                
                IF is_valid_postcode = 0 THEN
                    SELECT 0 as success, "De postcode komt niet uit de regio Maaskantje" as message;
                ELSE
                    UPDATE Contact
                    SET
                        Straat = p_straat,
                        Huisnummer = CAST(p_huisnummer AS UNSIGNED),
                        Toevoeging = p_toevoeging,
                        Postcode = p_postcode,
                        Woonplaats = p_woonplaats,
                        Email = p_email,
                        Mobiel = p_mobiel,
                        DatumGewijzigd = SYSDATE(6)
                    WHERE Id = p_contact_id;
                    
                    SELECT 1 as success, "De klantgegevens zijn gewijzigd" as message;
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GetAllKlantenWithContact');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GetKlantenByPostcode');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GetAllPostcodes');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GetKlantDetailsByGezinId');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_UpdateKlantPersonalDetails');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_UpdateKlantContactGegevens');
    }
};

