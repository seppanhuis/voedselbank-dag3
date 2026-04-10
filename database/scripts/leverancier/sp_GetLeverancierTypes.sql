DROP PROCEDURE IF EXISTS sp_GetLeverancierTypes;

DELIMITER $$

CREATE PROCEDURE sp_GetLeverancierTypes()
BEGIN
    SELECT DISTINCT
        l.LeverancierType
    FROM Leverancier AS l
    WHERE l.IsActief = b'1'
    ORDER BY l.LeverancierType ASC;
END$$

DELIMITER ;
