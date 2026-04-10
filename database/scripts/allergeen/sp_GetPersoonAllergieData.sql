DROP PROCEDURE IF EXISTS sp_GetPersoonAllergieData;

DELIMITER $$

CREATE PROCEDURE sp_GetPersoonAllergieData(IN p_persoonId INT)
BEGIN
    SELECT
        p.Id AS PersoonId,
        p.GezinId,
        ap.Id AS AllergiePerPersoonId,
        a.Id AS AllergieId,
        a.Naam AS AllergieNaam,
        a.AnafylactischRisico
    FROM Persoon p
    INNER JOIN AllergiePerPersoon ap ON ap.PersoonId = p.Id
    INNER JOIN Allergie a ON a.Id = ap.AllergieId
    WHERE p.Id = p_persoonId
      AND ap.IsActief = 1
    ORDER BY ap.Id ASC
    LIMIT 1;
END$$

DELIMITER ;
