DROP PROCEDURE IF EXISTS sp_GetAllergieDetailsPerGezin;

DELIMITER $$

CREATE PROCEDURE sp_GetAllergieDetailsPerGezin(IN p_gezinId INT)
BEGIN
    SELECT
        p.Id AS PersoonId,
        ap.Id AS AllergiePerPersoonId,
        g.Id AS GezinId,
        TRIM(CONCAT(p.Voornaam, ' ', COALESCE(p.Tussenvoegsel, ''), ' ', p.Achternaam)) AS Naam,
        p.TypePersoon,
        CASE
            WHEN p.IsVertegenwoordiger = 1 THEN 'Vertegenwoordiger'
            ELSE 'Gezinslid'
        END AS Gezinsrol,
        a.Id AS AllergieId,
        a.Naam AS AllergieNaam,
        a.AnafylactischRisico
    FROM Gezin g
    INNER JOIN Persoon p ON p.GezinId = g.Id
    INNER JOIN AllergiePerPersoon ap ON ap.PersoonId = p.Id
    INNER JOIN Allergie a ON a.Id = ap.AllergieId
    WHERE g.Id = p_gezinId
      AND ap.IsActief = 1
    ORDER BY p.Id ASC;
END$$

DELIMITER ;
