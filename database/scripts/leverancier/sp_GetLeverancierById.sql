DROP PROCEDURE IF EXISTS sp_GetLeverancierById;

DELIMITER $$

CREATE PROCEDURE sp_GetLeverancierById(IN p_leverancierId INT)
BEGIN
    SELECT
        l.Id,
        l.Naam,
        l.LeverancierNummer,
        l.LeverancierType
    FROM Leverancier AS l
    WHERE l.Id = p_leverancierId
      AND l.IsActief = b'1';
END$$

DELIMITER ;
