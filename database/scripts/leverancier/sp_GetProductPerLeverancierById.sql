DROP PROCEDURE IF EXISTS sp_GetProductPerLeverancierById;

DELIMITER $$

CREATE PROCEDURE sp_GetProductPerLeverancierById(IN p_productPerLeverancierId INT)
BEGIN
    SELECT
        ppl.Id AS ProductPerLeverancierId,
        l.Id AS LeverancierId,
        l.Naam AS LeverancierNaam,
        p.Id AS ProductId,
        p.Naam AS ProductNaam,
        p.SoortAllergie,
        p.Houdbaarheidsdatum
    FROM ProductPerLeverancier AS ppl
    INNER JOIN Product AS p
        ON p.Id = ppl.ProductId
        AND p.IsActief = b'1'
    INNER JOIN Leverancier AS l
        ON l.Id = ppl.LeverancierId
        AND l.IsActief = b'1'
    WHERE ppl.Id = p_productPerLeverancierId
      AND ppl.IsActief = b'1';
END$$

DELIMITER ;
