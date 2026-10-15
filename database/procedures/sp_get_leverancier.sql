CREATE PROCEDURE sp_get_leverancier(IN p_leverancier_id INT)
BEGIN
    SELECT Id, Naam, ContactPersoon, LeverancierNummer, Mobiel
    FROM Leverancier
    WHERE Id = p_leverancier_id AND IsActief = 1;
END
