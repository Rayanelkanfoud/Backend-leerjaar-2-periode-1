# Database specificatie tabel

Database: `mvc`. MySQL met InnoDB, primary keys en foreign keys.
Opdracht 2 gebruikt dezelfde zes tabellen als opdracht 1.

## Systeemvelden in alle zes tabellen

Deze vier kolommen horen bij **iedere** tabel hieronder.

| Kolom naam | Datatype | Lengte | Nullable | Opmerking |
| --- | --- | --- | --- | --- |
| IsActief | BIT | 1 | Nee | Standaard 1; Winegums heeft waarde 0 |
| Opmerking | VARCHAR | 255 | Ja | Standaard NULL |
| DatumAangemaakt | DATETIME | 6 decimalen | Nee | Bij aanmaken NOW(6) |
| DatumGewijzigd | DATETIME | 6 decimalen | Nee | Bij wijzigen NOW(6) |

## Product

| Kolom naam | Datatype | Lengte | Nullable | Opmerking |
| --- | --- | --- | --- | --- |
| Id | TINYINT UNSIGNED | 0 t/m 255 | Nee | PK, AUTO_INCREMENT |
| Naam | VARCHAR | 50 | Nee | Naam product |
| Barcode | VARCHAR | 13 | Nee | Barcode als tekst |

## Allergeen

| Kolom naam | Datatype | Lengte | Nullable | Opmerking |
| --- | --- | --- | --- | --- |
| Id | TINYINT UNSIGNED | 0 t/m 255 | Nee | PK, AUTO_INCREMENT |
| Naam | VARCHAR | 50 | Nee | Naam allergeen |
| Omschrijving | VARCHAR | 250 | Nee | Omschrijving allergeen |

## Leverancier

| Kolom naam | Datatype | Lengte | Nullable | Opmerking |
| --- | --- | --- | --- | --- |
| Id | TINYINT UNSIGNED | 0 t/m 255 | Nee | PK, AUTO_INCREMENT |
| Naam | VARCHAR | 50 | Nee | Naam leverancier |
| ContactPersoon | VARCHAR | 100 | Nee | Contactpersoon |
| LeverancierNummer | VARCHAR | 20 | Nee | Nummer met letter L |
| Mobiel | VARCHAR | 15 | Nee | Telefoonnummer met voorloopnul |

Quality Street: Johan Nooij, L1029234586, 06-23458456. Deze leverancier heeft nog geen leveringen.

## Magazijn

| Kolom naam | Datatype | Lengte | Nullable | Opmerking |
| --- | --- | --- | --- | --- |
| Id | TINYINT UNSIGNED | 0 t/m 255 | Nee | PK, AUTO_INCREMENT |
| ProductId | TINYINT UNSIGNED | 0 t/m 255 | Nee | FK naar Product.Id |
| VerpakkingsEenheid | DECIMAL | 4,1 | Nee | Gewicht in kg, bijvoorbeeld 2,5 |
| AantalAanwezig | SMALLINT UNSIGNED | 0 t/m 65535 | Ja | NULL wordt bij optellen als 0 behandeld |

## ProductPerAllergeen

| Kolom naam | Datatype | Lengte | Nullable | Opmerking |
| --- | --- | --- | --- | --- |
| Id | TINYINT UNSIGNED | 0 t/m 255 | Nee | PK, AUTO_INCREMENT |
| ProductId | TINYINT UNSIGNED | 0 t/m 255 | Nee | FK naar Product.Id |
| AllergeenId | TINYINT UNSIGNED | 0 t/m 255 | Nee | FK naar Allergeen.Id |

## ProductPerLeverancier

| Kolom naam | Datatype | Lengte | Nullable | Opmerking |
| --- | --- | --- | --- | --- |
| Id | TINYINT UNSIGNED | 0 t/m 255 | Nee | PK, AUTO_INCREMENT |
| LeverancierId | TINYINT UNSIGNED | 0 t/m 255 | Nee | FK naar Leverancier.Id |
| ProductId | TINYINT UNSIGNED | 0 t/m 255 | Nee | FK naar Product.Id |
| DatumLevering | DATE | JJJJ-MM-DD | Nee | Datum van de ontvangen levering |
| Aantal | SMALLINT UNSIGNED | 0 t/m 65535 | Nee | Aantal geleverde producteenheden |
| DatumEerstVolgendeLevering | DATE | JJJJ-MM-DD | Ja | Verwachte volgende levering |

## Relaties

- Product 1:N Magazijn.
- Product N:M Allergeen via ProductPerAllergeen.
- Leverancier N:M Product via ProductPerLeverancier. Iedere rij is een levering; een product kan meerdere keren door dezelfde leverancier zijn geleverd.
- Foreign keys blokkeren verwijderen van een stamrecord zolang er gekoppelde records bestaan.

## Stored procedures

| Procedure | Gebruik |
| --- | --- |
| sp_get_leveranciers | Leveranciers met COUNT(DISTINCT ProductId), aflopend op het aantal |
| sp_get_leverancier | Gegevens van een gekozen actieve leverancier |
| sp_get_geleverde_producten | Producten met voorraad en MAX(DatumLevering), aflopend op voorraad |
| sp_get_levering_product | Gegevens voor het formulier; controleert de leverancier-productkoppeling |
| sp_toevoegen_levering | Voorraad verhogen en nieuwe levering opslaan in dezelfde transactie |

De PDO-modellen gebruiken voorbereide CALL-statements. Na iedere aanroep wordt de cursor gesloten.
De opslagprocedure vergrendelt het product en de voorraad. Een inactief product wordt geweigerd zonder gegevens te wijzigen.
