DROP PROCEDURE IF EXISTS sp_GetLeveranciersOverzicht;

DELIMITER $$

CREATE PROCEDURE sp_GetLeveranciersOverzicht(IN p_leverancierType VARCHAR(50))
BEGIN
    SELECT
        l.Id AS LeverancierId,
        l.Naam,
        l.ContactPersoon,
        c.Email,
        c.Mobiel,
        l.LeverancierNummer,
        l.LeverancierType
    FROM Leverancier AS l
    INNER JOIN ContactPerLeverancier AS cpl
        ON cpl.LeverancierId = l.Id
        AND cpl.IsActief = b'1'
    INNER JOIN Contact AS c
        ON c.Id = cpl.ContactId
        AND c.IsActief = b'1'
    WHERE l.IsActief = b'1'
      AND (
            p_leverancierType IS NULL
            OR p_leverancierType = ''
            OR l.LeverancierType = p_leverancierType
          )
    ORDER BY l.Naam ASC;
END$$

DELIMITER ;
