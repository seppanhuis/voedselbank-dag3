DROP PROCEDURE IF EXISTS sp_GetKlantDetailsByGezinId;

DELIMITER $$

CREATE PROCEDURE sp_GetKlantDetailsByGezinId(
	IN p_gezin_id INT UNSIGNED
)
BEGIN
	SELECT
		G.Id as GezinId,
		G.Naam as NaamGezin,
		CONCAT(COALESCE(P.Voornaam, ''), ' ', COALESCE(P.Tussenvoegsel, ''), ' ', COALESCE(P.Achternaam, '')) as Vertegenwoordiger,
		COALESCE(P.Voornaam, '') as Voornaam,
		COALESCE(P.Tussenvoegsel, '') as Tussenvoegsel,
		COALESCE(P.Achternaam, '') as Achternaam,
		P.Geboortedatum,
		P.TypePersoon,
		C.Straat,
		C.Huisnummer,
		COALESCE(C.Toevoeging, '') as Toevoeging,
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
END$$

DELIMITER ;
