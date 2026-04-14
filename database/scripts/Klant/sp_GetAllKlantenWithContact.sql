DROP PROCEDURE IF EXISTS sp_GetAllKlantenWithContact;

DELIMITER $$

CREATE PROCEDURE sp_GetAllKlantenWithContact()
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
	ORDER BY G.Id ASC;
END$$

DELIMITER ;
