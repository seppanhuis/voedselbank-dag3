DROP PROCEDURE IF EXISTS sp_GetGezinById;

DELIMITER $$

CREATE PROCEDURE sp_GetGezinById(IN p_gezinId INT)
BEGIN
    SELECT
        g.Id,
        g.Naam,
        g.Omschrijving,
        g.TotaalAantalPersonen
    FROM Gezin g
    WHERE g.Id = p_gezinId;
END$$

DELIMITER ;
