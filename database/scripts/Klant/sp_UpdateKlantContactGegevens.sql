DROP PROCEDURE IF EXISTS sp_UpdateKlantContactGegevens;

DELIMITER $$

CREATE PROCEDURE sp_UpdateKlantContactGegevens(
	IN p_contact_id INT UNSIGNED,
	IN p_straat VARCHAR(100),
	IN p_huisnummer INT UNSIGNED,
	IN p_toevoeging VARCHAR(20),
	IN p_postcode VARCHAR(10),
	IN p_woonplaats VARCHAR(100),
	IN p_email VARCHAR(255),
	IN p_mobiel VARCHAR(25)
)
BEGIN
	DECLARE is_valid_postcode TINYINT DEFAULT 0;
	
	-- Controleer of postcode in regio Maaskantje valt (52xx postcodes)
	IF SUBSTRING(p_postcode, 1, 2) = '52' THEN
		SET is_valid_postcode = 1;
	END IF;
	
	IF is_valid_postcode = 0 THEN
		SELECT 0 as success, 'De postcode komt niet uit de regio Maaskantje' as message;
	ELSE
		UPDATE Contact
		SET
			Straat = p_straat,
			Huisnummer = p_huisnummer,
			Toevoeging = p_toevoeging,
			Postcode = p_postcode,
			Woonplaats = p_woonplaats,
			Email = p_email,
			Mobiel = p_mobiel,
			DatumGewijzigd = SYSDATE(6)
		WHERE Id = p_contact_id;
		
		SELECT 1 as success, 'De klantgegevens zijn gewijzigd' as message;
	END IF;
END$$

DELIMITER ;
