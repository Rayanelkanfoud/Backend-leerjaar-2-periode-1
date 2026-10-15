CREATE PROCEDURE sp_toevoegen_levering(
    IN p_leverancier_id INT,
    IN p_product_id INT,
    IN p_aantal INT,
    IN p_volgende_levering DATE
)
BEGIN
    DECLARE v_actief INT DEFAULT NULL;
    DECLARE v_voorraad INT DEFAULT NULL;
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;

    -- product vergrendelen zodat twee leveringen elkaar niet overschrijven
    SELECT IsActief + 0 INTO v_actief FROM Product WHERE Id = p_product_id FOR UPDATE;
    SELECT COALESCE(AantalAanwezig, 0) INTO v_voorraad
    FROM Magazijn WHERE ProductId = p_product_id AND IsActief = 1 FOR UPDATE;

    IF v_actief IS NULL OR v_voorraad IS NULL OR NOT EXISTS (
        SELECT 1 FROM ProductPerLeverancier AS pl
        INNER JOIN Leverancier AS l ON l.Id = pl.LeverancierId AND l.IsActief = 1
        WHERE pl.ProductId = p_product_id AND pl.LeverancierId = p_leverancier_id AND pl.IsActief = 1
    ) THEN
        ROLLBACK;
        SELECT 'onbekend' AS Status;
    ELSEIF v_actief = 0 THEN
        ROLLBACK;
        SELECT 'inactief' AS Status;
    ELSEIF p_aantal IS NULL OR p_aantal < 1 OR p_volgende_levering IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Aantal en eerstvolgende leverdatum zijn verplicht';
    ELSEIF v_voorraad + p_aantal > 65535 THEN
        ROLLBACK;
        SELECT 'voorraad_te_hoog' AS Status;
    ELSE
        UPDATE Magazijn SET AantalAanwezig = v_voorraad + p_aantal,
            DatumGewijzigd = NOW(6) WHERE ProductId = p_product_id;

        INSERT INTO ProductPerLeverancier
            (LeverancierId, ProductId, DatumLevering, Aantal, DatumEerstVolgendeLevering,
             IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)
        VALUES (p_leverancier_id, p_product_id, CURRENT_DATE(), p_aantal, p_volgende_levering,
                1, NULL, NOW(6), NOW(6));

        COMMIT;
        SELECT 'opgeslagen' AS Status;
    END IF;
END
