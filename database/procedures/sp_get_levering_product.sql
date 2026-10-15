CREATE PROCEDURE sp_get_levering_product(IN p_leverancier_id INT, IN p_product_id INT)
BEGIN
    SELECT p.Id, p.Naam AS ProductNaam, l.Naam AS LeverancierNaam,
           l.ContactPersoon, l.Mobiel, p.IsActief + 0 AS IsActief
    FROM Product AS p
    INNER JOIN Magazijn AS m ON m.ProductId = p.Id AND m.IsActief = 1
    INNER JOIN Leverancier AS l ON l.Id = p_leverancier_id AND l.IsActief = 1
    WHERE p.Id = p_product_id
        AND EXISTS (SELECT 1 FROM ProductPerLeverancier AS pl
                    WHERE pl.ProductId = p.Id AND pl.LeverancierId = l.Id AND pl.IsActief = 1);
END
