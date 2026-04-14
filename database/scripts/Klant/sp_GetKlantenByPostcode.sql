DROP PROCEDURE IF EXISTS sp_GetKlantenByPostcode;

DELIMITER $$

CREATE PROCEDURE sp_GetKlantenByPostcode(
	IN p_postcode VARCHAR(10)
)
BEGIN
	SELECT
		G.Id as GezinId,
		G.Naam as NaamGezin,
		CONCAT(COALESCE(P.Voornaam, ''), ' ', COALESCE(P.Tussenvoegsel, ''), ' ', COALESCE(P.Achternaam, '')) as Vertegenwoordiger,
		C.Email,
		C.Mobiel,
		CONCAT(C.Straat, ' ', C.Huisnummer, COALESCE(CONCAT(' ', C.Toevoeging), '')) as Adres,
		C.Woonplaats,
		C.Postcode
	FROM Gezin G
	LEFT JOIN Persoon P ON G.Id = P.GezinId AND P.IsVertegenwoordiger = 1
	LEFT JOIN ContactPerGezin CPG ON G.Id = CPG.GezinId
	LEFT JOIN Contact C ON CPG.ContactId = C.Id
	WHERE G.IsActief = 1 AND CPG.IsActief = 1 AND C.IsActief = 1
	AND C.Postcode = p_postcode
	ORDER BY G.Id ASC;
END$$

DELIMITER ;
