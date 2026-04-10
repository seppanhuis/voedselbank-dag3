DROP PROCEDURE IF EXISTS sp_GetAllAllergieen;

DELIMITER $$

CREATE PROCEDURE sp_GetAllAllergieen()
BEGIN
    SELECT
        a.Id,
        a.Naam,
        a.AnafylactischRisico
    FROM Allergie a
    WHERE a.IsActief = 1
    ORDER BY a.Naam ASC;
END$$

DELIMITER ;
