# Jamin backend opdracht 2

Laravel MVC-applicatie met PDO en MySQL stored procedures.

## Starten

Gebruik de bestaande `.env` met de lokale MySQL-verbinding. Voor een nieuwe installatie: kopieer `.env.example` naar `.env`, stel de MySQL-verbinding in en maak een lege database aan. Gebruik PHP 8.4 of hoger met pdo_mysql en Composer.

```powershell
composer install
php artisan key:generate
php artisan migrate
npm install
npm run build
composer run dev
```

Bij een bestaande installatie is alleen `php artisan migrate` nodig voor de nieuwe tabellenwijzigingen en stored procedures. Het handmatig uitvoeren van het createscript maakt de zes Jamin-tabellen opnieuw aan; gebruik voor de bestaande database dus de migraties.

Open `http://127.0.0.1:8000/dashboard` en log in met je bestaande account. Open **Overzicht Leveranciers** op de homepage of **Leveranciers** in de bestaande Laravel-sidebar. De nieuwe Blade-views gebruiken dezelfde app-layout en tabelopmaak als opdracht 1. Nieuwe accounts kunnen worden geregistreerd via `/register`.

## Scenario's

1. Overzicht leveranciers toont zes leveranciers, gesorteerd op aantal verschillende producten aflopend. Meerdere leveringen van hetzelfde product tellen als één verschillend product.
2. Het doosje van Venco opent de drie geleverde producten, gesorteerd op voorraad aflopend. De laatste levering is de hoogste leverdatum.
3. Het doosje van Quality Street toont de melding dat er nog niets is geleverd en gaat na drie seconden terug.
4. Het plusje bij Mintnopjes opent Levering product. Vul 25 en 29 mei 2024 in. Na opslaan is de voorraad 478 in plaats van 453 en staat de laatste levering op de huidige database-datum. Iedere verdere geldige inzending voegt opnieuw 25 toe.
5. Het plusje bij Winegums van Basset opent hetzelfde formulier. Vul 30 en de datum van vandaag in. Na opslaan verschijnt de melding dat Winegums niet meer wordt geproduceerd. De gegevens blijven gelijk en na vier seconden verschijnt Geleverde producten van Basset.

De jaartallen in de voorbeeldscenario's en wireframes verschillen van de specificatietabellen. De begingegevens volgen de tabellen (november 2024); het formulier accepteert de expliciet gevraagde datum 29 mei 2024. Een nieuwe ontvangen levering krijgt de huidige datum.

## Tests

```powershell
php vendor/bin/pint --test
php vendor/bin/phpstan analyse --memory-limit=512M
php artisan test

$env:JAMIN_MYSQL_TESTS = '1'
php artisan test
Remove-Item Env:JAMIN_MYSQL_TESTS
```

De elf Jamin-tests maken voor iedere test een eigen `jamin_test_...` database en verwijderen die daarna. Het MySQL-account heeft hiervoor CREATE DATABASE, DROP DATABASE, CREATE ROUTINE en TRIGGER nodig. Zonder de omgevingsvariabele worden deze MySQL-tests overgeslagen; de overige tests gebruiken SQLite in het geheugen.

## Branches

- `feature_overzicht_leverancier`: databasevoorbereiding, procedures, leveranciersschermen en tests van userstory 1.
- `feature_toevoegen_product`: bouwt verder op de eerste featurebranch en bevat de levering van userstory 2 en de eindcontroles.
- `dev` en `main`: blijven ongewijzigd tot het geheel is gecontroleerd.

Na goedkeuring eerst beide featurebranches naar `dev` mergen en testen; daarna `dev` naar `main` mergen. Er zijn nog geen merges uitgevoerd.

De databasespecificatie staat in `docs/Database specificatie tabel.md`. Het filmpje voor Canvas moet nog worden opgenomen; zie `vids/README.md`.
