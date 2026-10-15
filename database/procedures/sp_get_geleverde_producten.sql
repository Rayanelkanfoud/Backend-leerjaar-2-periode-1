CREATE PROCEDURE sp_get_geleverde_producten(IN p_leverancier_id INT)
BEGIN
    SELECT p.Id, p.Naam, m.AantalAanwezig, m.VerpakkingsEenheid,
           MAX(pl.DatumLevering) AS LaatsteLevering
    FROM ProductPerLeverancier AS pl
    INNER JOIN Product AS p ON p.Id = pl.ProductId
    INNER JOIN Magazijn AS m ON m.ProductId = p.Id
    WHERE pl.LeverancierId = p_leverancier_id
        AND pl.IsActief = 1 AND m.IsActief = 1
    GROUP BY p.Id, p.Naam, m.AantalAanwezig, m.VerpakkingsEenheid
    ORDER BY m.AantalAanwezig DESC, p.Naam ASC;
END
