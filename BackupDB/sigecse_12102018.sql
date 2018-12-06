-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 12-10-2018 a las 20:35:26
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 7.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sigecse`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`oarodriguez`@`%` PROCEDURE `pd_cli_get_x_mai` (IN `_mail` VARCHAR(100))  BEGIN

	SELECT
		uc.id_cli,
		uc.id_tu,
		uc.nom_cli,
        uc.ape_cli
	FROM
		`user_cli` AS uc
	WHERE
		uc.status_cli = 1 AND
		uc.corr_cli = _mail;
			
END$$

CREATE DEFINER=`oarodriguez`@`%` PROCEDURE `pd_ins_data` (IN `_id` INT, IN `_nom` VARCHAR(30), IN `_ape` VARCHAR(30), IN `_fec` DATE, IN `_fot` LONGBLOB, IN `_pwd` VARCHAR(40))  BEGIN
		INSERT INTO `prueba`VALUES(_id,_nom,_ape,_fec,_fot, MD5(SHA1(_pwd)),DEFAULT,DEFAULT);
END$$

CREATE DEFINER=`oarodriguez`@`%` PROCEDURE `pd_ins_useradm` (IN `_id_tu` INT, IN `_cod_adm` VARCHAR(10), IN `_ced_adm` VARCHAR(15), IN `_nom_adm` VARCHAR(50), IN `_ape_adm` VARCHAR(50), IN `_fnc_adm` DATE, IN `_tlf_adm` VARCHAR(12), IN `_corr_adm` VARCHAR(50), IN `_pwd_adm` VARCHAR(50), IN `_fot_adm` LONGBLOB, IN `_id_adm` INT)  BEGIN
	IF _id_adm > 0 THEN
    -- Reinicio la Variable a 0.
    SET _id_adm = '0';
	INSERT INTO `user_admin` VALUES(_id_adm,_id_tu,_cod_adm,_ced_adm,_nom_adm,_ape_adm,_fnc_adm,_tlf_adm,_corr_adm,MD5(SHA1(_pwd_adm)),_fot_adm,DEFAULT,DEFAULT);
    END IF ;
END$$

CREATE DEFINER=`oarodriguez`@`%` PROCEDURE `pd_pb_cmb` ()  BEGIN
	SELECT ua.* FROM `user_admin` AS ua;
END$$

--
-- Funciones
--
CREATE DEFINER=`oarodriguez`@`%` FUNCTION `fn_prueba` (`_id` INT, `_nom` VARCHAR(30), `_ape` VARCHAR(30), `_fec` DATE, `_fot` LONGBLOB, `_pwd` VARCHAR(40)) RETURNS INT(11) BEGIN
-- Declaracion de Variables.
DECLARE cont INTEGER ;
DECLARE resul INT ;

-- Inicializo el Cursor.
SET cont = (SELECT COUNT(p.id) FROM prueba AS p WHERE p.nombre = _nom);

-- Si No Existen Nombres Validos.
IF cont = 0 THEN 
-- Actualizo el Cursor.
SET cont = (SELECT COUNT(p.id) FROM prueba AS p WHERE p.apellido = _ape);
	-- Si No Existen Apellidos Validos.	
    IF cont > 0 THEN    	
    	SET resul = 2 ; -- El Apellido Ya Se Encuentra Registrado.
    ELSE
		INSERT INTO `prueba`VALUES(@p0, @p1, @p2, @p3, @p4, MD5(SHA1(@p5)), DEFAULT, DEFAULT);
        -- CALL pd_ins_data(@p0, @p1, @p2);
        SET resul = 0 ; -- OK    
    END IF ; -- Fin cont1 --
ELSE
	SET resul = 1 ; -- El Nombre Ya Se Encuentra Registrado.
END IF ; -- Fin cont --
     RETURN resul ; -- Retorno el Resultado (INTEGER).
END$$

CREATE DEFINER=`oarodriguez`@`%` FUNCTION `fn_set_pwd_us` (`_id` INT, `_pwd` VARCHAR(50)) RETURNS INT(11) BEGIN

DECLARE result INT;

		UPDATE `user_cli` SET pwd_cli = MD5(_pwd) WHERE id_cli = _id;
		SET result = 1;
    

		RETURN result;
END$$

CREATE DEFINER=`oarodriguez`@`%` FUNCTION `fn_user_adm_ins` (`_id_adm` INT, `_id_tu` INT, `_cod_adm` VARCHAR(10), `_ced_adm` VARCHAR(15), `_nom_adm` VARCHAR(50), `_ape_adm` VARCHAR(50), `_fnc_adm` DATE, `_tlf_adm` VARCHAR(12), `_corr_adm` VARCHAR(50), `_pwd_adm` VARCHAR(50), `_fot_adm` LONGBLOB) RETURNS INT(11) BEGIN
-- Declaracion de Variable. --
DECLARE cnt INTEGER ;
DECLARE result INT ;

-- Inicializo Cursor. --
SET cnt = (SELECT COUNT(ua.id_adm) FROM	`user_admin` AS ua INNER JOIN `tipouser` AS tu ON tu.id_tu = ua.id_tu WHERE	ua.id_adm = _id_adm AND tu.desc_tu IN ('ADMINISTRADOR')) ;
-- Valio si el User es Admin. --
IF cnt > 0 THEN

	-- Actualizo el Cursor.
	SET cnt = (SELECT COUNT(ua.id_adm) FROM `user_admin` AS ua WHERE ua.ced_adm = _ced_adm) ;
    
    -- Valido el Cedula del User. --    
	IF cnt = 0 THEN
    
    	-- Actualizo el Cursor.
		SET cnt = (SELECT COUNT(ua.id_adm) FROM `user_admin` AS ua WHERE
			 ua.corr_adm = _corr_adm) ;
             
        -- Valido la Correo del User. --
		IF cnt = 0 THEN        	
        	-- Si el ID es mayor a 0.
        	IF _id_adm > 0 THEN
             /*  SET _id_adm = 0;
			INSERT INTO `user_admin`VALUES(_id_adm, _id_tu,_cod_adm,_ced_adm,_nom_adm,_ape_adm,_fnc_adm,_tlf_adm,_corr_adm,MD5(SHA1(_pwd_adm)),_fot_adm,DEFAULT,DEFAULT);*/
            -- Seteo el Code para Tomar el Ultimo Valor del ID+1.
            SET @p2 = (SELECT MAX(id_adm)+1 FROM `user_admin`);
            -- Seteo el ID a 0;
            SET @p0 = '0' ;
        	INSERT INTO `user_admin`VALUES(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8, MD5(SHA1(@p9)), @p10, DEFAULT, DEFAULT);            
                                   
            SET result = 200 ; -- OK --
			END IF ;
            
        ELSE
			SET result = 2 ; -- Este Correo Ya Se Encuentra Registrado. --
        END IF ;    
        
    ELSE
		SET result = 1 ; -- Esta Cedula Ya Se Encuentra Registrada. --        
	END IF ;
    
ELSE
SET result = -99 ; -- No Tiene los Privilegios Suficientes. --
END IF ;

RETURN result;

END$$

CREATE DEFINER=`oarodriguez`@`%` FUNCTION `fn_us_cli_ins` (`_id_cli` INT, `_cod_cli` VARCHAR(10), `_ced_cli` VARCHAR(12), `_nom_cli` VARCHAR(30), `_ape_cli` VARCHAR(30), `_fcn_cli` DATE, `_ntlf_cli` VARCHAR(15), `_ncasa_cli` VARCHAR(5), `_ncalle_cli` VARCHAR(12), `_ch_cli` VARCHAR(30), `_corr_cli` VARCHAR(50), `_pwd_cli` VARCHAR(40), `_fot_cli` LONGBLOB) RETURNS INT(11) BEGIN
-- Declaro las Variables.
DECLARE cnt INTEGER ;
DECLARE result INT ;
-- Inicializo el Cursor.
SET cnt = (SELECT COUNT(uc.id_cli) FROM `user_cli` AS uc WHERE uc.ced_cli = _ced_cli) ;
    	-- SI No Existe la Cedula.
    	IF cnt = 0 THEN
        	-- Actualizo el Cursor.
    		SET cnt = (SELECT COUNT(uc.id_cli) FROM `user_cli` AS uc WHERE
			uc.corr_cli = _corr_cli) ;
            -- Si No Existe el Correo. 
        	IF cnt = 0 THEN
            	IF _id_cli = 0 THEN                	                    
                    IF _cod_cli = 0 THEN
                        SET _cod_cli = (SELECT COUNT(id_cli)+1 FROM `user_cli`);
                    	SET _id_cli = 0 ;
                    	INSERT INTO `user_cli`VALUES(_id_cli, DEFAULT, _cod_cli, _ced_cli, _nom_cli, _ape_cli, _fcn_cli, _ntlf_cli, _ncasa_cli, _ncalle_cli, _ch_cli, _corr_cli, MD5(SHA1(_pwd_cli)), _fot_cli, DEFAULT, DEFAULT);
                        
            	-- Seteo el Code y Capturo el Ultimo valor del ID+1.
            	/*SET @p1 = (SELECT MAX(id_cli)+1 FROM `user_cli`);
                SET @p0 = 0;
            	-- Insercion.
        		INSERT INTO `user_cli`VALUES(@p0, DEFAULT, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, MD5(SHA1(@p10)), @p11, DEFAULT, DEFAULT); */           
                                   
            		SET result = 200 ; -- OK.                	
                    END IF;
                END IF;
       		ELSE
				SET result = 2 ; -- Este Correo Ya Se Encuentra Registrado.
        	END IF ;    
        
    	ELSE
			SET result = 1 ; -- Esta Cedula Ya Se Encuentra Registrada.
    	END IF ;

	RETURN result;

END$$

CREATE DEFINER=`oarodriguez`@`%` FUNCTION `fn_us_cli_ins_pb` (`_cod_cli` VARCHAR(10), `_ced_cli` VARCHAR(12), `_nom_cli` VARCHAR(30), `_ape_cli` VARCHAR(30), `_fcn_cli` DATE, `_ntlf_cli` VARCHAR(15), `_ncasa_cli` VARCHAR(5), `_ncalle_cli` VARCHAR(12), `_ch_cli` VARCHAR(30), `_corr_cli` VARCHAR(50), `_pwd_cli` VARCHAR(40), `_fot_cli` LONGBLOB) RETURNS INT(11) BEGIN
-- Variables Declaradas. --
DECLARE cnt INTEGER ;
DECLARE result INT ;
-- Inicializo el Cursor. --
SET cnt = (SELECT COUNT(uc.id_cli) FROM `user_cli` AS uc WHERE uc.ced_cli = _ced_cli) ;
    	-- Si No Existe Cedula Duplicada. --
    	IF cnt = 0 THEN
    			-- Actualizo el Cursor. --
    			SET cnt = (SELECT COUNT(uc.id_cli) FROM `user_cli` AS uc WHERE
			 uc.corr_cli = _corr_cli) ;
             	-- Si No Existe Correo Duplicado. --
        		IF cnt = 0 THEN            
                    -- Automatizo el "cod_cli". --
                    SET @p0 = (SELECT MAX(id_cli)+1 FROM `user_cli`);                    
                    -- Inserto. --
                    INSERT INTO `user_cli`(                        
                        cod_cli,
                        ced_cli,
                        nom_cli,
                        ape_cli,
                        fcn_cli,
                        ntlf_cli,
                        ncasa_cli,
                        ncalle_cli,
                        ch_cli,
                        corr_cli,
                        pwd_cli,
                        fot_cli)
                    VALUES(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, MD5(SHA1(@p10)), @p11);                
            		SET result = 200 ; -- OK. --
                ELSE
                    SET result = 2 ; -- Este Correo Ya Se Encuentra Registrado. --
                END IF ;            
    	ELSE
			SET result = 1 ; -- Esta Cedula Ya Se Encuentra Registrada. --
        END IF ;

RETURN result; -- Resultado --

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prueba`
--

CREATE TABLE `prueba` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `FOTO` longblob,
  `pwd` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `fh_cre` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `prueba`
--

INSERT INTO `prueba` (`id`, `nombre`, `apellido`, `fecha`, `FOTO`, `pwd`, `status`, `fh_cre`) VALUES
(5, 'OMAR', 'RODRIGUEZ', '2018-05-01', NULL, '', 0, '2018-05-07 17:49:15'),
(6, 'ANDRES', 'SANABRIA', '2018-05-09', NULL, '', 0, '2018-05-07 17:49:15'),
(7, 'LISS', 'MARTINEZ', '2018-05-17', NULL, '', 0, '2018-05-07 17:49:15'),
(8, 'CARLOS', 'VELASQUEZ', '2018-05-17', NULL, '', 0, '2018-05-07 17:49:15'),
(9, 'maryi', 'leal', '2018-05-04', NULL, '', 0, '2018-05-07 17:49:15'),
(10, 'ruben', 'ss', '2018-05-11', NULL, '', 0, '2018-05-07 17:49:15'),
(11, 'jose', 'perez', '2018-05-09', NULL, '', 0, '2018-05-07 17:49:15'),
(12, 'daniel', 'velas', '2018-05-16', NULL, '', 0, '2018-05-07 17:49:15'),
(13, 'sss', 'daniel', '2018-05-16', NULL, '', 0, '2018-05-07 17:49:15'),
(14, 'JEISON', 'XX', '2018-05-10', NULL, '', 0, '2018-05-07 17:49:15'),
(15, 'doris', 'chacon', '2018-05-18', NULL, '', 0, '2018-05-07 17:49:15'),
(16, 'XAVIER', 'DURAN', '2018-05-11', NULL, '', 0, '2018-05-07 17:49:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipouser`
--

CREATE TABLE `tipouser` (
  `id_tu` int(11) NOT NULL,
  `cod_tu` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `desc_tu` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `status_tu` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipouser`
--

INSERT INTO `tipouser` (`id_tu`, `cod_tu`, `desc_tu`, `status_tu`) VALUES
(1, '11', 'ADMINISTRADOR', 0),
(2, '31', 'CLIENTE', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_admin`
--

CREATE TABLE `user_admin` (
  `id_adm` int(20) NOT NULL COMMENT 'Identificador Principal de la Tabla.',
  `id_tu` int(11) NOT NULL COMMENT 'Identificador de la Tabla "tipouser", (Relacion).',
  `cod_adm` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Codigo del Administrador.',
  `ced_adm` varchar(12) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Cedula del Administrador.',
  `nom_adm` varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del Administrador',
  `ape_adm` varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Apellido del Administrador',
  `fnc_adm` date NOT NULL COMMENT 'Fecha de Nacimiento del Administrador',
  `tlf_adm` varchar(15) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Telefono del Administrador.',
  `corr_adm` varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Correo del Administrador.',
  `pwd_adm` varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Password del Administrador.',
  `fot_adm` longblob COMMENT 'Foto del Administrador.',
  `status_adm` smallint(6) NOT NULL DEFAULT '1' COMMENT 'Status del Administrador, (Activado->1/Eliminado->0).',
  `fh_cre` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y Hora de Creacion del Administrador.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla Maestra de los Usuarios Administradores del Sistema.';

--
-- Volcado de datos para la tabla `user_admin`
--

INSERT INTO `user_admin` (`id_adm`, `id_tu`, `cod_adm`, `ced_adm`, `nom_adm`, `ape_adm`, `fnc_adm`, `tlf_adm`, `corr_adm`, `pwd_adm`, `fot_adm`, `status_adm`, `fh_cre`) VALUES
(1, 1, '1', '0000000000', 'ADMIN', 'DEL SISTEMA', '1111-11-11', '000000000000', 'ADMIN@ADMIN.COM', 'd93a5def7511da3d0f2d171d9c344e91', 0x30, 0, '2018-05-04 16:14:32'),
(2, 1, '2', '110011', 'TEST', 'TEST', '1111-11-11', '0412452142', 'TEST@TEST.COM', '25d55ad283aa400af464c76d713c07ad', 0x30, 0, '2018-05-08 11:21:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_cli`
--

CREATE TABLE `user_cli` (
  `id_cli` int(11) NOT NULL COMMENT 'Identificador Principal de la Tabla.',
  `id_tu` int(11) NOT NULL DEFAULT '2' COMMENT 'Identificador de la Tabla "tipouser", (Relacion).',
  `cod_cli` varchar(10) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Codigo del Cliente.',
  `ced_cli` varchar(12) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Cedula del Cliente, Campo Unico',
  `nom_cli` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del CLiente.',
  `ape_cli` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Apellido del CLiente.',
  `fcn_cli` date NOT NULL COMMENT 'Fecha de Nacimiento del CLiente.',
  `ntlf_cli` varchar(15) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Numero de Telefono del Cliente.',
  `ncasa_cli` varchar(5) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Numero de Casa del Cliente.',
  `ncalle_cli` varchar(12) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Numero de Calle del Cliente.',
  `ch_cli` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Condicion Habitacional del Cliente.',
  `corr_cli` varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Correo del Cliente.',
  `pwd_cli` varchar(40) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Contraseña del Cliente.',
  `fot_cli` longblob COMMENT 'Foto del Cliente Asociado',
  `status_cli` smallint(6) NOT NULL DEFAULT '1' COMMENT 'Status del Cliente, (Activado->1/Eliminado->0).',
  `fh_cre` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y Hora de Creacion del Cliente.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla Maestra de los Clientes Asociados en el Sistema';

--
-- Volcado de datos para la tabla `user_cli`
--

INSERT INTO `user_cli` (`id_cli`, `id_tu`, `cod_cli`, `ced_cli`, `nom_cli`, `ape_cli`, `fcn_cli`, `ntlf_cli`, `ncasa_cli`, `ncalle_cli`, `ch_cli`, `corr_cli`, `pwd_cli`, `fot_cli`, `status_cli`, `fh_cre`) VALUES
(0, 2, '5', 'V-00000000', 'ALEXANDER', 'CID AGUILAR', '2003-02-20', '(5036)3122900', '00', '00', 'PROPIETARIO', 'ALEXCIDAGUILAR1@YAHOO.ES', '2c95d13706c26d7d22878cc0ac204f52', 0x30, 1, '2018-06-12 18:55:02'),
(1, 2, '1', 'V-19608212', 'OMAR', 'RODRIGUEZ', '1988-08-10', '(0412)1982526', '83', '5', 'PROPIETARIO', 'OMARGUMER22@GMAIL.COM', 'a38c6da825bc81a065f20e3c38bde0ba', 0x30, 1, '2018-05-11 15:21:36'),
(2, 2, '2', 'V-15425888', 'DANIEL', 'RODRIGUEZ', '1994-03-15', '(0426)1597536', '83', '5', 'PROPIETARIO', 'DANI@DANIEEE.COM', 'c99331028bad9372f1657ef19eb5de82', 0x30, 1, '2018-05-11 15:22:40'),
(3, 2, '3', 'V-15275557', 'DAY', 'RODRIGUEZ', '1981-07-17', '(0424)1597548', '83', '5', 'PROPIETARIO', 'DAY@DAY.COM', '827ccb0eea8a706c4c34a16891f84e7b', 0x30, 1, '2018-05-11 15:25:44'),
(4, 2, '4', 'V-15478956', 'REF', 'RODRIGUEZ', '2018-05-01', '(0412)5856325', '83', '15', 'ALQUILADO', 'FINO@FION.COM', 'e9e811371917632632e76290ecec8b07', 0x30, 1, '2018-05-16 16:01:01');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `prueba`
--
ALTER TABLE `prueba`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipouser`
--
ALTER TABLE `tipouser`
  ADD PRIMARY KEY (`id_tu`),
  ADD UNIQUE KEY `cod_tu` (`cod_tu`);

--
-- Indices de la tabla `user_admin`
--
ALTER TABLE `user_admin`
  ADD PRIMARY KEY (`id_adm`),
  ADD UNIQUE KEY `ced_adm` (`ced_adm`),
  ADD UNIQUE KEY `cod_adm` (`cod_adm`),
  ADD KEY `id_tu` (`id_tu`);

--
-- Indices de la tabla `user_cli`
--
ALTER TABLE `user_cli`
  ADD PRIMARY KEY (`id_cli`),
  ADD UNIQUE KEY `ced_cli` (`ced_cli`),
  ADD KEY `id_tu` (`id_tu`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `prueba`
--
ALTER TABLE `prueba`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `tipouser`
--
ALTER TABLE `tipouser`
  MODIFY `id_tu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `user_admin`
--
ALTER TABLE `user_admin`
  MODIFY `id_adm` int(20) NOT NULL AUTO_INCREMENT COMMENT 'Identificador Principal de la Tabla.', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `user_cli`
--
ALTER TABLE `user_cli`
  MODIFY `id_cli` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador Principal de la Tabla.', AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `user_admin`
--
ALTER TABLE `user_admin`
  ADD CONSTRAINT `user_admin_ibfk_1` FOREIGN KEY (`id_tu`) REFERENCES `tipouser` (`id_tu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user_cli`
--
ALTER TABLE `user_cli`
  ADD CONSTRAINT `user_cli_ibfk_1` FOREIGN KEY (`id_tu`) REFERENCES `tipouser` (`id_tu`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
