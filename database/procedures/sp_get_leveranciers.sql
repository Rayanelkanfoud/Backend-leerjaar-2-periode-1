CREATE PROCEDURE sp_get_leveranciers()
BEGIN
    SELECT l.Id, l.Naam, l.ContactPersoon, l.LeverancierNummer, l.Mobiel,
           COUNT(DISTINCT pl.ProductId) AS AantalVerschillendeProducten
    FROM Leverancier AS l
    LEFT JOIN ProductPerLeverancier AS pl
        ON pl.LeverancierId = l.Id AND pl.IsActief = 1
    WHERE l.IsActief = 1
    GROUP BY l.Id, l.Naam, l.ContactPersoon, l.LeverancierNummer, l.Mobiel
    ORDER BY AantalVerschillendeProducten DESC, l.Id ASC;
END
