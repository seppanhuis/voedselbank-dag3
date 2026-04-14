USE voedselbank2;

UPDATE Product
SET SoortAllergie = NULL
WHERE Id IN (6, 7)
  AND SoortAllergie = 'Banaan';

UPDATE Product
SET SoortAllergie = 'Soja'
WHERE Id = 29
  AND (SoortAllergie IS NULL OR SoortAllergie = 'Cacao' OR SoortAllergie = 'Cacoa');

SELECT Id, Naam, SoortAllergie, Barcode, Houdbaarheidsdatum
FROM Product
WHERE Id IN (1, 4, 7, 8, 20, 9)
ORDER BY Naam;
