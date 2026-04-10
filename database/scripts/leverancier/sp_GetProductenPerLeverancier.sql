DROP PROCEDURE IF EXISTS sp_GetProductenPerLeverancier;

DELIMITER $$

CREATE PROCEDURE sp_GetProductenPerLeverancier(IN p_leverancierId INT)
BEGIN
    SELECT
        ppl.Id AS ProductPerLeverancierId,
        p.Id AS ProductId,
        p.Naam,
        p.Barcode,
        p.Houdbaarheidsdatum,
        p.Status
    FROM ProductPerLeverancier AS ppl
    INNER JOIN Product AS p
        ON p.Id = ppl.ProductId
        AND p.IsActief = b'1'
    WHERE ppl.LeverancierId = p_leverancierId
      AND ppl.IsActief = b'1'
    ORDER BY p.Naam ASC;
END$$

DELIMITER ;
