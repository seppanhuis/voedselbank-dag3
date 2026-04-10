DROP PROCEDURE IF EXISTS sp_UpdatePersoonAllergie;

DELIMITER $$

CREATE PROCEDURE sp_UpdatePersoonAllergie(
    IN p_allergiePerPersoonId INT,
    IN p_nieuweAllergieId INT
)
BEGIN
    UPDATE AllergiePerPersoon
    SET AllergieId = p_nieuweAllergieId,
        DatumGewijzigd = SYSDATE(6)
    WHERE Id = p_allergiePerPersoonId;

    SELECT ROW_COUNT() AS affected;
END$$

DELIMITER ;
