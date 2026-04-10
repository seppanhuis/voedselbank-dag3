DROP DATABASE IF EXISTS `voedselbank2`;
CREATE DATABASE IF NOT EXISTS `voedselbank2`;
USE `voedselbank2`;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `AllergiePerPersoon`;
DROP TABLE IF EXISTS `RolPerGebruiker`;
DROP TABLE IF EXISTS `EetwensPerGezin`;
DROP TABLE IF EXISTS `ContactPerLeverancier`;
DROP TABLE IF EXISTS `ContactPerGezin`;
DROP TABLE IF EXISTS `ProductPerVoedselpakket`;
DROP TABLE IF EXISTS `ProductPerLeverancier`;
DROP TABLE IF EXISTS `ProductPerMagazijn`;
DROP TABLE IF EXISTS `Gebruiker`;
DROP TABLE IF EXISTS `Voedselpakket`;
DROP TABLE IF EXISTS `Persoon`;
DROP TABLE IF EXISTS `Gezin`;
DROP TABLE IF EXISTS `Product`;
DROP TABLE IF EXISTS `Magazijn`;
DROP TABLE IF EXISTS `Leverancier`;
DROP TABLE IF EXISTS `Contact`;
DROP TABLE IF EXISTS `Categorie`;
DROP TABLE IF EXISTS `Rol`;
DROP TABLE IF EXISTS `Eetwens`;
DROP TABLE IF EXISTS `Allergie`;

CREATE TABLE `Allergie` (
	`Id` INT UNSIGNED NOT NULL,
	`Naam` VARCHAR(100) NOT NULL,
	`Omschrijving` VARCHAR(255) NOT NULL,
	`AnafylactischRisico` VARCHAR(50) NOT NULL,
	`IsActief` BIT NOT NULL DEFAULT b'1',
	`Opmerking` VARCHAR(255) NULL,
	`DatumAangemaakt` DATETIME(6) NOT NULL,
	`DatumGewijzigd` DATETIME(6) NOT NULL,
	PRIMARY KEY (`Id`)
) ENGINE=InnoDB;

CREATE TABLE `Rol` (
	`Id` INT UNSIGNED NOT NULL,
	`Naam` VARCHAR(100) NOT NULL,
	`IsActief` BIT NOT NULL DEFAULT b'1',
	`Opmerking` VARCHAR(255) NULL,
	`DatumAangemaakt` DATETIME(6) NOT NULL,
	`DatumGewijzigd` DATETIME(6) NOT NULL,
	PRIMARY KEY (`Id`)
) ENGINE=InnoDB;

CREATE TABLE `Categorie` (
	`Id` INT UNSIGNED NOT NULL,
	`Naam` VARCHAR(20) NOT NULL,
	`Omschrijving` VARCHAR(255) NOT NULL,
	`IsActief` BIT NOT NULL DEFAULT b'1',
	`Opmerking` VARCHAR(255) NULL,
	`DatumAangemaakt` DATETIME(6) NOT NULL,
	`DatumGewijzigd` DATETIME(6) NOT NULL,
	PRIMARY KEY (`Id`)
) ENGINE=InnoDB;

CREATE TABLE `Eetwens` (
	`Id` INT UNSIGNED NOT NULL,
	`Naam` VARCHAR(100) NOT NULL,
	`Omschrijving` VARCHAR(255) NOT NULL,
	`IsActief` BIT NOT NULL DEFAULT b'1',
	`Opmerking` VARCHAR(255) NULL,
	`DatumAangemaakt` DATETIME(6) NOT NULL,
	`DatumGewijzigd` DATETIME(6) NOT NULL,
	PRIMARY KEY (`Id`)
) ENGINE=InnoDB;

CREATE TABLE `Contact` (
	`Id` INT UNSIGNED NOT NULL,
	`Straat` VARCHAR(100) NOT NULL,
	`Huisnummer` INT UNSIGNED NOT NULL,
	`Toevoeging` VARCHAR(20) NULL,
	`Postcode` VARCHAR(10) NOT NULL,
	`Woonplaats` VARCHAR(100) NOT NULL,
	`Email` VARCHAR(255) NOT NULL,
	`Mobiel` VARCHAR(25) NOT NULL,
	`IsActief` BIT NOT NULL DEFAULT b'1',
	`Opmerking` VARCHAR(255) NULL,
	`DatumAangemaakt` DATETIME(6) NOT NULL,
	`DatumGewijzigd` DATETIME(6) NOT NULL,
	PRIMARY KEY (`Id`)
) ENGINE=InnoDB;

CREATE TABLE `Leverancier` (
	`Id` INT UNSIGNED NOT NULL,
	`Naam` VARCHAR(100) NOT NULL,
	`ContactPersoon` VARCHAR(100) NOT NULL,
	`LeverancierNummer` VARCHAR(20) NOT NULL,
	`LeverancierType` VARCHAR(50) NOT NULL,
	`IsActief` BIT NOT NULL DEFAULT b'1',
	`Opmerking` VARCHAR(255) NULL,
	`DatumAangemaakt` DATETIME(6) NOT NULL,
	`DatumGewijzigd` DATETIME(6) NOT NULL,
	PRIMARY KEY (`Id`)
) ENGINE=InnoDB;

CREATE TABLE `Magazijn` (
	`Id` INT UNSIGNED NOT NULL,
	`Ontvangstdatum` DATE NOT NULL,
	`Uitleveringsdatum` DATE NULL,
	`VerpakkingsEenheid` VARCHAR(50) NOT NULL,
	`Aantal` INT UNSIGNED NOT NULL,
	`IsActief` BIT NOT NULL DEFAULT b'1',
	`Opmerking` VARCHAR(255) NULL,
	`DatumAangemaakt` DATETIME(6) NOT NULL,
	`DatumGewijzigd` DATETIME(6) NOT NULL,
	PRIMARY KEY (`Id`)
) ENGINE=InnoDB;

CREATE TABLE `Gezin` (
	`Id` INT UNSIGNED NOT NULL,
	`Naam` VARCHAR(100) NOT NULL,
	`Code` VARCHAR(20) NOT NULL,
	`Omschrijving` VARCHAR(255) NOT NULL,
	`AantalVolwassenen` INT UNSIGNED NOT NULL,
	`AantalKinderen` INT UNSIGNED NOT NULL,
	`AantalBabys` INT UNSIGNED NOT NULL,
	`TotaalAantalPersonen` INT UNSIGNED NOT NULL,
	`IsActief` BIT NOT NULL DEFAULT b'1',
	`Opmerking` VARCHAR(255) NULL,
	`DatumAangemaakt` DATETIME(6) NOT NULL,
	`DatumGewijzigd` DATETIME(6) NOT NULL,
	PRIMARY KEY (`Id`)
) ENGINE=InnoDB;

CREATE TABLE `Persoon` (
	`Id` INT UNSIGNED NOT NULL,
	`GezinId` INT UNSIGNED NULL,
	`Voornaam` VARCHAR(100) NOT NULL,
	`Tussenvoegsel` VARCHAR(50) NULL,
	`Achternaam` VARCHAR(100) NOT NULL,
	`Geboortedatum` DATE NOT NULL,
	`TypePersoon` VARCHAR(50) NOT NULL,
	`IsVertegenwoordiger` BIT NOT NULL,
	`IsActief` BIT NOT NULL DEFAULT b'1',
	`Opmerking` VARCHAR(255) NULL,
	`DatumAangemaakt` DATETIME(6) NOT NULL,
	`DatumGewijzigd` DATETIME(6) NOT NULL,
	PRIMARY KEY (`Id`),
	CONSTRAINT `FK_Persoon_Gezin` FOREIGN KEY (`GezinId`) REFERENCES `Gezin`(`Id`)
) ENGINE=InnoDB;

CREATE TABLE `Gebruiker` (
	`Id` INT UNSIGNED NOT NULL,
	`PersoonId` INT UNSIGNED NOT NULL,
	`InlogNaam` VARCHAR(100) NOT NULL,
	`Gebruikersnaam` VARCHAR(255) NOT NULL,
	`Wachtwoord` VARCHAR(255) NOT NULL,
	`IsIngelogd` BIT NOT NULL,
	`Ingelogd` DATETIME NULL,
	`Uitgelogd` DATETIME NULL,
	`IsActief` BIT NOT NULL DEFAULT b'1',
	`Opmerking` VARCHAR(255) NULL,
	`DatumAangemaakt` DATETIME(6) NOT NULL,
	`DatumGewijzigd` DATETIME(6) NOT NULL,
	PRIMARY KEY (`Id`),
	CONSTRAINT `FK_Gebruiker_Persoon` FOREIGN KEY (`PersoonId`) REFERENCES `Persoon`(`Id`)
) ENGINE=InnoDB;

CREATE TABLE `Product` (
	`Id` INT UNSIGNED NOT NULL,
	`CategorieId` INT UNSIGNED NOT NULL,
	`Naam` VARCHAR(100) NOT NULL,
	`SoortAllergie` VARCHAR(50) NULL,
	`Barcode` VARCHAR(20) NOT NULL,
	`Houdbaarheidsdatum` DATE NOT NULL,
	`Omschrijving` VARCHAR(255) NOT NULL,
	`Status` VARCHAR(50) NOT NULL,
	`IsActief` BIT NOT NULL DEFAULT b'1',
	`Opmerking` VARCHAR(255) NULL,
	`DatumAangemaakt` DATETIME(6) NOT NULL,
	`DatumGewijzigd` DATETIME(6) NOT NULL,
	PRIMARY KEY (`Id`),
	CONSTRAINT `FK_Product_Categorie` FOREIGN KEY (`CategorieId`) REFERENCES `Categorie`(`Id`)
) ENGINE=InnoDB;

CREATE TABLE `Voedselpakket` (
	`Id` INT UNSIGNED NOT NULL,
	`GezinId` INT UNSIGNED NOT NULL,
	`PakketNummer` INT UNSIGNED NOT NULL,
	`DatumSamenstelling` DATE NOT NULL,
	`DatumUitgifte` DATE NULL,
	`Status` VARCHAR(50) NOT NULL,
	`IsActief` BIT NOT NULL DEFAULT b'1',
	`Opmerking` VARCHAR(255) NULL,
	`DatumAangemaakt` DATETIME(6) NOT NULL,
	`DatumGewijzigd` DATETIME(6) NOT NULL,
	PRIMARY KEY (`Id`),
	CONSTRAINT `FK_Voedselpakket_Gezin` FOREIGN KEY (`GezinId`) REFERENCES `Gezin`(`Id`)
) ENGINE=InnoDB;

CREATE TABLE `AllergiePerPersoon` (
	`Id` INT UNSIGNED NOT NULL,
	`PersoonId` INT UNSIGNED NOT NULL,
	`AllergieId` INT UNSIGNED NOT NULL,
	`IsActief` BIT NOT NULL DEFAULT b'1',
	`Opmerking` VARCHAR(255) NULL,
	`DatumAangemaakt` DATETIME(6) NOT NULL,
	`DatumGewijzigd` DATETIME(6) NOT NULL,
	PRIMARY KEY (`Id`),
	CONSTRAINT `FK_AllergiePerPersoon_Persoon` FOREIGN KEY (`PersoonId`) REFERENCES `Persoon`(`Id`),
	CONSTRAINT `FK_AllergiePerPersoon_Allergie` FOREIGN KEY (`AllergieId`) REFERENCES `Allergie`(`Id`)
) ENGINE=InnoDB;

CREATE TABLE `RolPerGebruiker` (
	`Id` INT UNSIGNED NOT NULL,
	`GebruikerId` INT UNSIGNED NOT NULL,
	`RolId` INT UNSIGNED NOT NULL,
	`IsActief` BIT NOT NULL DEFAULT b'1',
	`Opmerking` VARCHAR(255) NULL,
	`DatumAangemaakt` DATETIME(6) NOT NULL,
	`DatumGewijzigd` DATETIME(6) NOT NULL,
	PRIMARY KEY (`Id`),
	CONSTRAINT `FK_RolPerGebruiker_Gebruiker` FOREIGN KEY (`GebruikerId`) REFERENCES `Gebruiker`(`Id`),
	CONSTRAINT `FK_RolPerGebruiker_Rol` FOREIGN KEY (`RolId`) REFERENCES `Rol`(`Id`)
) ENGINE=InnoDB;

CREATE TABLE `EetwensPerGezin` (
	`Id` INT UNSIGNED NOT NULL,
	`GezinId` INT UNSIGNED NOT NULL,
	`EetwensId` INT UNSIGNED NOT NULL,
	`IsActief` BIT NOT NULL DEFAULT b'1',
	`Opmerking` VARCHAR(255) NULL,
	`DatumAangemaakt` DATETIME(6) NOT NULL,
	`DatumGewijzigd` DATETIME(6) NOT NULL,
	PRIMARY KEY (`Id`),
	CONSTRAINT `FK_EetwensPerGezin_Gezin` FOREIGN KEY (`GezinId`) REFERENCES `Gezin`(`Id`),
	CONSTRAINT `FK_EetwensPerGezin_Eetwens` FOREIGN KEY (`EetwensId`) REFERENCES `Eetwens`(`Id`)
) ENGINE=InnoDB;

CREATE TABLE `ContactPerLeverancier` (
	`Id` INT UNSIGNED NOT NULL,
	`LeverancierId` INT UNSIGNED NOT NULL,
	`ContactId` INT UNSIGNED NOT NULL,
	`IsActief` BIT NOT NULL DEFAULT b'1',
	`Opmerking` VARCHAR(255) NULL,
	`DatumAangemaakt` DATETIME(6) NOT NULL,
	`DatumGewijzigd` DATETIME(6) NOT NULL,
	PRIMARY KEY (`Id`),
	CONSTRAINT `FK_ContactPerLeverancier_Leverancier` FOREIGN KEY (`LeverancierId`) REFERENCES `Leverancier`(`Id`),
	CONSTRAINT `FK_ContactPerLeverancier_Contact` FOREIGN KEY (`ContactId`) REFERENCES `Contact`(`Id`)
) ENGINE=InnoDB;

CREATE TABLE `ContactPerGezin` (
	`Id` INT UNSIGNED NOT NULL,
	`GezinId` INT UNSIGNED NOT NULL,
	`ContactId` INT UNSIGNED NOT NULL,
	`IsActief` BIT NOT NULL DEFAULT b'1',
	`Opmerking` VARCHAR(255) NULL,
	`DatumAangemaakt` DATETIME(6) NOT NULL,
	`DatumGewijzigd` DATETIME(6) NOT NULL,
	PRIMARY KEY (`Id`),
	CONSTRAINT `FK_ContactPerGezin_Gezin` FOREIGN KEY (`GezinId`) REFERENCES `Gezin`(`Id`),
	CONSTRAINT `FK_ContactPerGezin_Contact` FOREIGN KEY (`ContactId`) REFERENCES `Contact`(`Id`)
) ENGINE=InnoDB;

CREATE TABLE `ProductPerVoedselpakket` (
	`Id` INT UNSIGNED NOT NULL,
	`VoedselpakketId` INT UNSIGNED NOT NULL,
	`ProductId` INT UNSIGNED NOT NULL,
	`AantalProductEenheden` INT UNSIGNED NOT NULL,
	`IsActief` BIT NOT NULL DEFAULT b'1',
	`Opmerking` VARCHAR(255) NULL,
	`DatumAangemaakt` DATETIME(6) NOT NULL,
	`DatumGewijzigd` DATETIME(6) NOT NULL,
	PRIMARY KEY (`Id`),
	CONSTRAINT `FK_ProductPerVoedselpakket_Voedselpakket` FOREIGN KEY (`VoedselpakketId`) REFERENCES `Voedselpakket`(`Id`),
	CONSTRAINT `FK_ProductPerVoedselpakket_Product` FOREIGN KEY (`ProductId`) REFERENCES `Product`(`Id`)
) ENGINE=InnoDB;

CREATE TABLE `ProductPerLeverancier` (
	`Id` INT UNSIGNED NOT NULL,
	`LeverancierId` INT UNSIGNED NOT NULL,
	`ProductId` INT UNSIGNED NOT NULL,
	`DatumAangeleverd` DATE NOT NULL,
	`DatumEerstVolgendeLevering` DATE NOT NULL,
	`IsActief` BIT NOT NULL DEFAULT b'1',
	`Opmerking` VARCHAR(255) NULL,
	`DatumAangemaakt` DATETIME(6) NOT NULL,
	`DatumGewijzigd` DATETIME(6) NOT NULL,
	PRIMARY KEY (`Id`),
	CONSTRAINT `FK_ProductPerLeverancier_Leverancier` FOREIGN KEY (`LeverancierId`) REFERENCES `Leverancier`(`Id`),
	CONSTRAINT `FK_ProductPerLeverancier_Product` FOREIGN KEY (`ProductId`) REFERENCES `Product`(`Id`)
) ENGINE=InnoDB;

CREATE TABLE `ProductPerMagazijn` (
	`Id` INT UNSIGNED NOT NULL,
	`ProductId` INT UNSIGNED NOT NULL,
	`MagazijnId` INT UNSIGNED NOT NULL,
	`Locatie` VARCHAR(100) NOT NULL,
	`IsActief` BIT NOT NULL DEFAULT b'1',
	`Opmerking` VARCHAR(255) NULL,
	`DatumAangemaakt` DATETIME(6) NOT NULL,
	`DatumGewijzigd` DATETIME(6) NOT NULL,
	PRIMARY KEY (`Id`),
	CONSTRAINT `FK_ProductPerMagazijn_Product` FOREIGN KEY (`ProductId`) REFERENCES `Product`(`Id`),
	CONSTRAINT `FK_ProductPerMagazijn_Magazijn` FOREIGN KEY (`MagazijnId`) REFERENCES `Magazijn`(`Id`)
) ENGINE=InnoDB;

INSERT INTO `Allergie` (`Id`, `Naam`, `Omschrijving`, `AnafylactischRisico`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'Gluten', 'Allergisch voor gluten', 'zeerlaag', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 'Pindas', 'Allergisch voor pindas', 'Hoog', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 'Schaaldieren', 'Allergisch voor schaaldieren', 'RedelijkHoog', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(4, 'Hazelnoten', 'Allergisch voor hazelnoten', 'laag', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(5, 'Lactose', 'Allergisch voor lactose', 'Zeerlaag', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(6, 'Soja', 'Allergisch voor soja', 'Zeerlaag', b'1', NULL, SYSDATE(6), SYSDATE(6));

INSERT INTO `Rol` (`Id`, `Naam`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'Manager', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 'Medewerker', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 'Vrijwilliger', b'1', NULL, SYSDATE(6), SYSDATE(6));

INSERT INTO `Categorie` (`Id`, `Naam`, `Omschrijving`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'AGF', 'Aardappelen groente en fruit', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 'KV', 'Kaas en vleeswaren', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 'ZPE', 'Zuivel plantaardig en eieren', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(4, 'BB', 'Bakkerij en Banket', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(5, 'FSKT', 'Frisdranken, sappen, koffie en thee', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(6, 'PRW', 'Pasta, rijst en wereldkeuken', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(7, 'SSKO', 'Soepen, sauzen, kruiden en olie', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(8, 'SKCC', 'Snoep, koek, chips en chocolade', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(9, 'BVH', 'Baby, verzorging en hygiëne', b'1', NULL, SYSDATE(6), SYSDATE(6));

INSERT INTO `Eetwens` (`Id`, `Naam`, `Omschrijving`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'GeenVarken', 'Geen Varkensvlees', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 'Veganistisch', 'Geen zuivelproducten en vlees', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 'Vegetarisch', 'Geen vlees', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(4, 'Omnivoor', 'Geen beperkingen', b'1', NULL, SYSDATE(6), SYSDATE(6));

INSERT INTO `Contact` (`Id`, `Straat`, `Huisnummer`, `Toevoeging`, `Postcode`, `Woonplaats`, `Email`, `Mobiel`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'Prinses Irenestraat', 12, 'A', '5271TH', 'Maaskantje', 'j.v.zevenhuizen@gmail.com', '+31 623456123', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 'Gibraltarstraat', 234, NULL, '5271TJ', 'Maaskantje', 'a.bergkamp@hotmail.com', '+31 623456123', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 'Der Kinderenstraat', 456, 'Bis', '5271TH', 'Maaskantje', 's.van.de.heuvel@gmail.com', '+31 623456123', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(4, 'Nachtegaalstraat', 233, NULL, '5271TJ', 'Maaskantje', 'e.scherder@gmail.com', '+31 623456123', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(5, 'Bertram Russellstraat', 45, NULL, '5271TH', 'Maaskantje', 'f.de.jong@hotmail.com', '+31 623456123', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(6, 'Leonardo Da VinciHof', 34, NULL, '5271ZE', 'Maaskantje', 'h.van.der.berg@gmail.com', '+31 623456123', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(7, 'Siegfried Knutsenlaan', 234, NULL, '5271ZE', 'Maaskantje', 'r.ter.weijden@ah.nl', '+31 623456123', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(8, 'Theo de Bokstraat', 256, NULL, '5271ZH', 'Maaskantje', 'l.pastoor@gmail.com', '+31 623456123', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(9, 'Meester van Leerhof', 2, 'A', '5271ZH', 'Maaskantje', 'm.yazidi@gemeenteutrecht.nl', '+31 623456123', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(10, 'Van Wemelenplantsoen', 300, NULL, '5271TH', 'Maaskantje', 'b.van.driel@gmail.com', '+31 623456123', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(11, 'Terlingenhof', 20, NULL, '5271TH', 'Maaskantje', 'j.pastorius@gmail.com', '+31 623456356', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(12, 'Veldhoen', 31, NULL, '5271ZE', 'Maaskantje', 's.dollaard@gmail.com', '+31 623452314', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(13, 'ScheringaDreef', 37, NULL, '5271ZE', 'Vught', 'j.blokker@gemeentevught.nl', '+31 623452314', b'1', NULL, SYSDATE(6), SYSDATE(6));

INSERT INTO `Leverancier` (`Id`, `Naam`, `ContactPersoon`, `LeverancierNummer`, `LeverancierType`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'Albert Heijn', 'Ruud ter Weijden', 'L0001', 'Bedrijf', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 'Albertus Kerk', 'Leo Pastoor', 'L0002', 'Instelling', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 'Gemeente Utrecht', 'Mohammed Yazidi', 'L0003', 'Overheid', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(4, 'Boerderij Meerhoven', 'Bertus van Driel', 'L0004', 'Particulier', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(5, 'Jan van der Heijden', 'Jan van der Heijden', 'L0005', 'Donor', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(6, 'Vomar', 'Jaco Pastorius', 'L0006', 'Bedrijf', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(7, 'DekaMarkt', 'Sil den Dollaard', 'L0007', 'Bedrijf', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(8, 'Gemeente Vught', 'Jan Blokker', 'L0008', 'Overheid', b'1', NULL, SYSDATE(6), SYSDATE(6));

INSERT INTO `Magazijn` (`Id`, `Ontvangstdatum`, `Uitleveringsdatum`, `VerpakkingsEenheid`, `Aantal`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, '2026-03-12', NULL, '5 kg', 20, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, '2026-04-02', NULL, '2.5 kg', 40, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, '2026-03-16', NULL, '1 kg', 30, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(4, '2026-04-08', NULL, '1.5 kg', 25, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(5, '2026-04-06', NULL, '4 stuks', 75, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(6, '2026-03-12', NULL, '1 kg/tros', 60, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(7, '2026-03-20', NULL, '2 kg/tros', 200, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(8, '2026-04-02', NULL, '200 g', 45, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(9, '2026-04-04', NULL, '100 g', 60, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(10, '2026-04-07', NULL, '1 liter', 120, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(11, '2026-04-01', NULL, '250 g', 80, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(12, '2026-03-18', NULL, '6 stuks', 120, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(13, '2026-03-19', NULL, '800 g', 220, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(14, '2026-03-10', NULL, '1 stuk', 130, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(15, '2026-03-13', NULL, '150 ml', 72, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(16, '2026-03-18', NULL, '1 l', 120, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(17, '2026-03-11', NULL, '250 g', 300, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(18, '2026-04-02', NULL, '25 zakjes', 280, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(19, '2026-04-09', NULL, '500 g', 330, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(20, '2026-04-03', NULL, '1 kg', 34, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(21, '2026-04-02', NULL, '50 g', 23, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(22, '2026-03-16', NULL, '1 l', 46, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(23, '2026-03-14', NULL, '250 ml', 98, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(24, '2026-04-07', NULL, '1 potje', 56, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(25, '2026-03-17', NULL, '1 l', 210, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(26, '2026-04-05', NULL, '4 stuks', 24, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(27, '2026-04-07', NULL, '300 g', 87, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(28, '2026-04-06', NULL, '200 g', 230, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(29, '2026-04-08', NULL, '80 g', 30, b'1', NULL, SYSDATE(6), SYSDATE(6));

INSERT INTO `Gezin` (`Id`, `Naam`, `Code`, `Omschrijving`, `AantalVolwassenen`, `AantalKinderen`, `AantalBabys`, `TotaalAantalPersonen`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'ZevenhuizenGezin', 'G0001', 'Bijstandsgezin', 2, 2, 0, 4, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 'BergkampGezin', 'G0002', 'Bijstandsgezin', 2, 1, 1, 4, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 'HeuvelGezin', 'G0003', 'Bijstandsgezin', 2, 0, 0, 2, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(4, 'ScherderGezin', 'G0004', 'Bijstandsgezin', 1, 0, 2, 3, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(5, 'DeJongGezin', 'G0005', 'Bijstandsgezin', 1, 1, 0, 2, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(6, 'VanderBergGezin', 'G0006', 'AlleenGaande', 1, 0, 0, 1, b'1', NULL, SYSDATE(6), SYSDATE(6));

INSERT INTO `Persoon` (`Id`, `GezinId`, `Voornaam`, `Tussenvoegsel`, `Achternaam`, `Geboortedatum`, `TypePersoon`, `IsVertegenwoordiger`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, NULL, 'Hans', 'van', 'Leeuwen', '1958-02-12', 'Manager', b'0', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, NULL, 'Jan', 'van der', 'Sluijs', '1993-04-30', 'Medewerker', b'0', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, NULL, 'Herman', 'den', 'Duiker', '1989-08-30', 'Vrijwilliger', b'0', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(4, 1, 'Johan', 'van', 'Zevenhuizen', '1990-05-20', 'Klant', b'1', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(5, 1, 'Sarah', 'den', 'Dolder', '1985-03-23', 'Klant', b'0', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(6, 1, 'Theo', 'van', 'Zevenhuizen', '2015-03-08', 'Klant', b'0', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(7, 1, 'Jantien', 'van', 'Zevenhuizen', '2016-09-20', 'Klant', b'0', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(8, 2, 'Arjan', NULL, 'Bergkamp', '1968-07-12', 'Klant', b'1', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(9, 2, 'Janneke', NULL, 'Sanders', '1969-05-11', 'Klant', b'0', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(10, 2, 'Stein', NULL, 'Bergkamp', '2011-02-02', 'Klant', b'0', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(11, 2, 'Judith', NULL, 'Bergkamp', '2026-02-05', 'Klant', b'0', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(12, 3, 'Mazin', 'van', 'Vliet', '1968-08-18', 'Klant', b'0', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(13, 3, 'Selma', 'van de', 'Heuvel', '1965-09-04', 'Klant', b'1', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(14, 4, 'Eva', NULL, 'Scherder', '2000-04-07', 'Klant', b'1', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(15, 4, 'Felicia', NULL, 'Scherder', '2025-11-29', 'Klant', b'0', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(16, 4, 'Devin', NULL, 'Scherder', '2026-03-01', 'Klant', b'0', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(17, 5, 'Frieda', 'de', 'Jong', '1980-09-04', 'Klant', b'1', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(18, 5, 'Simon', 'de', 'Jong', '2018-05-23', 'Klant', b'0', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(19, 6, 'Hanna', 'van der', 'Berg', '1999-09-09', 'Klant', b'1', b'1', NULL, SYSDATE(6), SYSDATE(6));

INSERT INTO `Gebruiker` (`Id`, `PersoonId`, `InlogNaam`, `Gebruikersnaam`, `Wachtwoord`, `IsIngelogd`, `Ingelogd`, `Uitgelogd`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 'Hans', 'hans@maaskantje.nl', '$2y$10$296RMzqzZqWENu9vyh6axed0DkfsuYkbvoI/AXVowCp/DL6zKiF0i', b'1', '2026-04-10 09:03:06', NULL, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 2, 'Jan', 'jan@maaskantje.nl', '$2y$10$296RMzqzZqWENu9vyh6axed0DkfsuYkbvoI/AXVowCp/DL3zKiF6i', b'0', '2026-04-09 15:13:23', '2026-04-09 15:23:46', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 3, 'Herman', 'herman@maaskantje.nl', '$2y$10$296RMzqzZqWENu9vyh6axed0DkfsuYkbvoI/AXVowCp/DL9zKiF2i', b'1', '2026-04-08 12:05:20', NULL, b'1', NULL, SYSDATE(6), SYSDATE(6));

INSERT INTO `Product` (`Id`, `CategorieId`, `Naam`, `SoortAllergie`, `Barcode`, `Houdbaarheidsdatum`, `Omschrijving`, `Status`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 'Aardappel', NULL, '8719587321239', '2026-05-12', 'Kruimige aardappel', 'OpVoorraad', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 1, 'Aardappel', NULL, '8719587321239', '2026-05-26', 'Kruimige aardappel', 'OpVoorraad', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 1, 'Ui', NULL, '8719437321335', '2026-05-02', 'Gele ui', 'NietOpVoorraad', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(4, 1, 'Appel', NULL, '8719486321332', '2026-05-16', 'Granny Smith', 'NietLeverbaar', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(5, 1, 'Appel', NULL, '8719486321332', '2026-05-23', 'Granny Smith', 'NietLeverbaar', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(6, 1, 'Banaan', 'Banaan', '8719484321336', '2026-05-12', 'Biologische Banaan', 'OverHoudbaarheidsDatum', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(7, 1, 'Banaan', 'Banaan', '8719484321336', '2026-05-19', 'Biologische Banaan', 'OverHoudbaarheidsDatum', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(8, 2, 'Kaas', 'Lactose', '8719487421338', '2026-05-19', 'Jonge Kaas', 'OpVoorraad', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(9, 2, 'Rosbief', NULL, '8719487421331', '2026-05-23', 'Rundvlees', 'OpVoorraad', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(10, 3, 'Melk', 'Lactose', '8719447321332', '2026-05-23', 'Halfvolle melk', 'OpVoorraad', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(11, 3, 'Margarine', NULL, '8719486321336', '2026-05-02', 'Plantaardige boter', 'OpVoorraad', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(12, 3, 'Ei', 'Eier', '8719487421334', '2026-05-04', 'Scharrelei', 'OpVoorraad', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(13, 4, 'Brood', 'Gluten', '8719487721337', '2026-05-07', 'Volkoren brood', 'OpVoorraad', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(14, 4, 'Gevulde Koek', 'Amande', '8719483321333', '2026-05-04', 'Banketbakkers kwaliteit', 'OpVoorraad', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(15, 5, 'Fristi', 'Lactose', '8719487121331', '2026-05-28', 'Frisdrank', 'NietOpVoorraad', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(16, 5, 'Appelsap', NULL, '8719487521335', '2026-05-19', '100% vruchtensap', 'OpVoorraad', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(17, 5, 'Koffie', 'Caffeïne', '8719487381338', '2026-05-23', 'Arabica koffie', 'OverHoudbaarheidsDatum', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(18, 5, 'Thee', 'Theïne', '8719487329339', '2026-05-02', 'Ceylon thee', 'OpVoorraad', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(19, 6, 'Pasta', 'Gluten', '8719487321334', '2026-05-16', 'Macaroni', 'NietLeverbaar', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(20, 6, 'Rijst', NULL, '8719487331332', '2026-05-25', 'Basmati Rijst', 'OpVoorraad', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(21, 6, 'Knorr Nasi MiX', NULL, '871948735135', '2026-05-13', 'Nasi kruiden', 'OpVoorraad', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(22, 7, 'Tomatensoep', NULL, '8719487371337', '2026-05-23', 'Romige tomatensoep', 'OpVoorraad', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(23, 7, 'Tomatensaus', NULL, '8719487341334', '2026-05-21', 'Pizza saus', 'NietOpVoorraad', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(24, 7, 'Peterselie', NULL, '8719487321636', '2026-05-31', 'Verse kruidenpot', 'OpVoorraaad', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(25, 8, 'Olie', NULL, '8719487327337', '2026-05-27', 'Olijfolie', 'OpVoorraad', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(26, 8, 'Mars', NULL, '8719487324334', '2026-05-11', 'Snoep', 'OpVoorraad', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(27, 8, 'Biscuit', NULL, '8719487311331', '2026-05-07', 'San Francisco biscuit', 'OpVoorraad', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(28, 8, 'Paprika Chips', NULL, '87194873218398', '2026-05-22', 'Ribbelchips paprika', 'OpVoorraad', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(29, 8, 'Chocolade reep', 'Cacao', '8719487321533', '2026-05-21', 'Tony Chocolonely', 'OpVoorraad', b'1', NULL, SYSDATE(6), SYSDATE(6));

INSERT INTO `Voedselpakket` (`Id`, `GezinId`, `PakketNummer`, `DatumSamenstelling`, `DatumUitgifte`, `Status`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 1, '2026-03-21', '2026-03-21', 'Uitgereikt', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 1, 2, '2026-03-19', NULL, 'NietUitgereikt', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 1, 3, '2026-03-17', NULL, 'NietMeerIngeschreven', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(4, 2, 4, '2026-03-10', '2026-03-14', 'Uitgereikt', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(5, 2, 5, '2026-03-18', '2026-03-20', 'Uitgereikt', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(6, 2, 6, '2026-04-08', NULL, 'NietUitgereikt', b'1', NULL, SYSDATE(6), SYSDATE(6));

INSERT INTO `AllergiePerPersoon` (`Id`, `PersoonId`, `AllergieId`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 4, 1, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 5, 2, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 6, 3, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(4, 7, 4, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(5, 8, 3, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(6, 9, 2, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(7, 10, 5, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(8, 12, 2, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(9, 13, 4, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(10, 14, 1, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(11, 15, 3, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(12, 16, 5, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(13, 17, 1, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(14, 17, 2, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(15, 18, 4, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(16, 19, 4, b'1', NULL, SYSDATE(6), SYSDATE(6));

INSERT INTO `RolPerGebruiker` (`Id`, `GebruikerId`, `RolId`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 1, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 2, 2, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 3, 3, b'1', NULL, SYSDATE(6), SYSDATE(6));

INSERT INTO `EetwensPerGezin` (`Id`, `GezinId`, `EetwensId`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 2, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 2, 4, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 3, 4, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(4, 4, 3, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(5, 5, 2, b'1', NULL, SYSDATE(6), SYSDATE(6));

INSERT INTO `ContactPerLeverancier` (`Id`, `LeverancierId`, `ContactId`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 7, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 2, 8, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 3, 9, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(4, 4, 10, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(6, 6, 11, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(7, 7, 12, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(8, 8, 13, b'1', NULL, SYSDATE(6), SYSDATE(6));

INSERT INTO `ContactPerGezin` (`Id`, `GezinId`, `ContactId`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 1, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 2, 2, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 3, 3, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(4, 4, 4, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(5, 5, 5, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(6, 6, 6, b'1', NULL, SYSDATE(6), SYSDATE(6));

INSERT INTO `ProductPerVoedselpakket` (`Id`, `VoedselpakketId`, `ProductId`, `AantalProductEenheden`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 7, 1, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 1, 8, 2, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 1, 9, 1, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(4, 2, 12, 1, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(5, 2, 13, 2, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(6, 2, 14, 1, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(7, 3, 3, 1, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(8, 3, 4, 1, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(9, 4, 20, 1, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(10, 4, 19, 1, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(11, 4, 21, 1, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(12, 5, 24, 1, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(13, 5, 25, 1, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(14, 5, 26, 1, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(15, 6, 27, 1, b'1', NULL, SYSDATE(6), SYSDATE(6));

INSERT INTO `ProductPerLeverancier` (`Id`, `LeverancierId`, `ProductId`, `DatumAangeleverd`, `DatumEerstVolgendeLevering`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 1, '2026-03-12', '2026-05-15', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 4, 2, '2026-04-02', '2026-05-05', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 2, 3, '2026-03-16', '2026-05-18', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(4, 1, 4, '2026-04-08', '2026-05-11', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(5, 4, 5, '2026-04-06', '2026-05-10', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(6, 1, 6, '2026-03-12', '2026-05-15', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(7, 4, 7, '2026-03-20', '2026-05-21', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(8, 4, 8, '2026-04-02', '2026-05-08', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(9, 4, 9, '2026-04-04', '2026-05-09', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(10, 3, 10, '2026-04-07', '2026-05-11', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(11, 3, 11, '2026-04-01', '2026-05-06', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(12, 3, 12, '2026-03-18', '2026-05-20', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(13, 3, 13, '2026-03-19', '2026-05-20', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(14, 2, 14, '2026-04-10', '2026-05-12', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(15, 2, 15, '2026-03-13', '2026-05-15', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(16, 1, 16, '2026-03-18', '2026-05-21', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(17, 1, 17, '2026-03-11', '2026-05-15', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(18, 1, 18, '2026-04-02', '2026-05-06', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(19, 1, 19, '2026-04-09', '2026-05-12', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(20, 4, 20, '2026-04-03', '2026-05-06', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(21, 2, 21, '2026-04-02', '2026-05-08', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(22, 1, 22, '2026-03-16', '2026-05-19', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(23, 3, 23, '2026-03-14', '2026-05-18', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(24, 3, 24, '2026-04-07', '2026-05-15', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(25, 1, 25, '2026-03-17', '2026-05-21', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(26, 2, 26, '2026-04-05', '2026-05-12', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(27, 1, 27, '2026-04-07', '2026-05-10', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(28, 2, 28, '2026-04-06', '2026-05-09', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(29, 3, 29, '2026-04-08', '2026-05-11', b'1', NULL, SYSDATE(6), SYSDATE(6));

INSERT INTO `ProductPerMagazijn` (`Id`, `ProductId`, `MagazijnId`, `Locatie`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 1, 'Berlicum', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 2, 2, 'Rosmalen', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 3, 3, 'Berlicum', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(4, 4, 4, 'Berlicum', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(5, 5, 5, 'Rosmalen', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(6, 6, 6, 'Berlicum', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(7, 7, 7, 'Rosmalen', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(8, 8, 8, 'Sint-MichelsGestel', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(9, 9, 9, 'Sint-MichelsGestel', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(10, 10, 10, 'Middelrode', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(11, 11, 11, 'Middelrode', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(12, 12, 12, 'Middelrode', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(13, 13, 13, 'Schijndel', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(14, 14, 14, 'Schijndel', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(15, 15, 15, 'Gemonde', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(16, 16, 16, 'Gemonde', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(17, 17, 17, 'Gemonde', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(18, 18, 18, 'Gemonde', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(19, 19, 19, 'Den Bosch', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(20, 20, 20, 'Den Bosch', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(21, 21, 21, 'Den Bosch', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(22, 22, 22, 'Heeswijk Dinther', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(23, 23, 23, 'Heeswijk Dinther', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(24, 24, 24, 'Heeswijk Dinther', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(25, 25, 25, 'Vught', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(26, 26, 26, 'Vught', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(27, 27, 27, 'Vught', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(28, 28, 28, 'Vught', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(29, 29, 29, 'Vught', b'1', NULL, SYSDATE(6), SYSDATE(6));

SET FOREIGN_KEY_CHECKS = 1;

-- Stored procedures staan nu in losse bestanden onder:
-- database/scripts/allergeen
-- Voer die bestanden apart uit na het draaien van dit createscript.
