DROP PROCEDURE IF EXISTS sp_GetGezinnenMetAllergie;

DELIMITER $$

CREATE PROCEDURE sp_GetGezinnenMetAllergie(IN p_allergieId INT)
BEGIN
    SELECT
        g.Id AS GezinId,
        g.Naam,
        g.Omschrijving,
        g.AantalVolwassenen,
        g.AantalKinderen,
        g.AantalBabys,
        TRIM(CONCAT(v.Voornaam, ' ', COALESCE(v.Tussenvoegsel, ''), ' ', v.Achternaam)) AS Vertegenwoordiger
    FROM Gezin g
    INNER JOIN Persoon p ON p.GezinId = g.Id
    INNER JOIN AllergiePerPersoon ap ON ap.PersoonId = p.Id
    INNER JOIN Allergie a ON a.Id = ap.AllergieId
    LEFT JOIN Persoon v ON v.GezinId = g.Id AND v.IsVertegenwoordiger = 1
    WHERE g.IsActief = 1
      AND ap.IsActief = 1
      AND (p_allergieId IS NULL OR a.Id = p_allergieId)
    GROUP BY
        g.Id,
        g.Naam,
        g.Omschrijving,
        g.AantalVolwassenen,
        g.AantalKinderen,
        g.AantalBabys,
        v.Voornaam,
        v.Tussenvoegsel,
        v.Achternaam
    ORDER BY g.Naam ASC;
END$$

DELIMITER ;
