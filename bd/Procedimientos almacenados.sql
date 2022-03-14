DROP PROCEDURE usuiu;
DELIMITER //
		CREATE PROCEDURE usuiu(idus bigint(11), nomus varchar(50), apeus varchar(50),docus varchar(11), pefi bigint(11), dirus varchar(100), telus varchar(10), codub bigint(11), emaus varchar(100), pasus varchar(100), imgu varchar(120), depus bigint(11), actus tinyint(1))
		BEGIN
		IF NOT EXISTS(SELECT idusu FROM usuario WHERE idusu=idus) THEN 
			INSERT INTO usuario (nomusu, apeusu, docusu, pefid, dirusu, telusu, codubi, emausu, pasusu, imgus, depusu, actusu) VALUES (nomus, apeus, docus, pefi, dirus, telus, codub, emaus, pasus, imgu, depus, actus);
		ELSE
			UPDATE usuario 
			SET nomusu=nomus, apeusu=apeus, docusu=docus, pefid=pefi, dirusu=dirus, telusu=telus, codubi=codub, emausu=emausu, imgus=imgus
			WHERE idusu=idus;
		END IF;
	END //
DELIMITER ;

DROP PROCEDURE presiu;
DELIMITER //
		CREATE PROCEDURE presiu(idcr bigint(11), feccr datetime, idus bigint(11), mont varchar(11), intere tinyint(1), tie tinyint(1), es tinyint(1), prestado bigint(11))
		BEGIN
		IF NOT EXISTS(SELECT idcre FROM credito WHERE idcre=idcr) THEN 
			INSERT INTO credito (feccre, idusu, monto, interes, tiem, est, prestador) VALUES (feccr, idus, mont, intere, tie, es, prestado);
		ELSE
			UPDATE credito 
			SET feccre=feccr, idusu=idus, monto=mont , interes=intere, tiem=tie, est=es, prestador=prestado
			WHERE idcre=idcr;
		END IF;
	END //
DELIMITER ;

DROP PROCEDURE inviu;
DELIMITER //
		CREATE PROCEDURE inviu(idus bigint(11), cin varchar(10))
		BEGIN		
		UPDATE usuario 
		SET cinv=cin
		WHERE idusu=idus;
		
	END //
DELIMITER ;