DROP PROCEDURE IF EXISTS sp_UpdateProductHoudbaarheidsdatum;

DELIMITER $$

CREATE PROCEDURE sp_UpdateProductHoudbaarheidsdatum(
    IN p_productPerLeverancierId INT,
    IN p_nieuweHoudbaarheidsdatum DATE
)
BEGIN
    DECLARE v_productId INT DEFAULT NULL;
    DECLARE v_huidigeHoudbaarheidsdatum DATE DEFAULT NULL;

    SELECT
        p.Id,
        p.Houdbaarheidsdatum
    INTO
        v_productId,
        v_huidigeHoudbaarheidsdatum
    FROM ProductPerLeverancier AS ppl
    INNER JOIN Product AS p
        ON p.Id = ppl.ProductId
        AND p.IsActief = b'1'
    WHERE ppl.Id = p_productPerLeverancierId
      AND ppl.IsActief = b'1'
    LIMIT 1;

    IF v_productId IS NULL THEN
        SELECT 0 AS affected, 'NOT_FOUND' AS reason;
    ELSEIF p_nieuweHoudbaarheidsdatum > DATE_ADD(v_huidigeHoudbaarheidsdatum, INTERVAL 7 DAY) THEN
        SELECT 0 AS affected, 'MAX_7_DAYS' AS reason;
    ELSE
        UPDATE Product
        SET
            Houdbaarheidsdatum = p_nieuweHoudbaarheidsdatum,
            DatumGewijzigd = SYSDATE(6)
        WHERE Id = v_productId
          AND IsActief = b'1';

        SELECT ROW_COUNT() AS affected, 'UPDATED' AS reason;
    END IF;
END$$

DELIMITER ;
