TRUNCATE TABLE ROLES_USUARIO;
TRUNCATE TABLE ROLES;
TRUNCATE TABLE COMENTARIOS_FORO;
TRUNCATE TABLE RESENA;
TRUNCATE TABLE SERVICIOS_CONTRATADOS;
TRUNCATE TABLE SERVICIOS_FAVORITOS;
TRUNCATE TABLE ESTADO_SERVICIOS;
TRUNCATE TABLE ESTADO_MENSAJES;
TRUNCATE TABLE MENSAJES;
TRUNCATE TABLE USUARIOS;
TRUNCATE TABLE SERVICIO;
TRUNCATE TABLE FORO;
TRUNCATE TABLE CATEGORIA_SERVICIOS;
TRUNCATE TABLE CONVERSACIONES;

INSERT INTO ESTADO_SERVICIOS(ID, NOMBRE) VALUES
(1, 'SOLICITADO'),
(2, 'EN CURSO'),
(3, 'FINALIZADO'),
(4, 'RECHAZADO');

INSERT INTO ESTADO_MENSAJES(ID, NOMBRE) VALUES
(1, 'NO LEIDO'),
(2, 'LEIDO');


INSERT INTO ROLES (ID, NOMBRE) VALUES
(1, 'user'),
(2, 'admin');


INSERT INTO ROLES_USUARIO (USUARIO, ROL) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1);

INSERT INTO USUARIOS (ID, NOMBRE, APELLIDO1, APELLIDO2, USERNAME, PASSWORD, EMAIL, TELEFONO, DESCRIPCION, SERVICIO_OFERTADO, 
SALDO_MONEDERO, FECHA_CREACION, FECHA_NACIMIENTO, IMAGEN, PAIS, CIUDAD, CALLE, NUMERO_CALLE, PORTAL, PISO, PUERTA, CODIGO_POSTAL) VALUES
(1, 'Alfredo', 'Fernandez', 'Perez', 'admin', '$2y$10$O3c1kBFa2yDK5F47IUqusOJmIANjHP6EiPyke5dD18ldJEow.e0eS', 'admin@example.com', 910000000, 'Descripcion de admin', NULL, 
900, NOW(), '1996-9-06', 'img/usuarios/admin.png', 'España', 'Madrid', 'Gran vía', 2, 1, 0, 'B', 28005),

(2, 'Manuela', 'Lovera', 'Ojeda', 'user', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user@example.com', 610034578, 'Descripcion de user', 1, 
1, NOW(), '1997-7-04', NULL, 'España', 'Madrid', 'Gran vía', 2, 1, 0, 'B', 28005),

(3, 'Pedro', 'Lopez', 'Lugo', 'pedrolo', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user1@example.com', 610000000, 'Descripcion de user', 2, 
900, NOW(), '1997-11-29', NULL, 'España', 'Barcelona', 'Del Rosal', 2, 1, 0, 'C', 28005),

(4, 'Juan', 'Fernandez', 'Alcantara', 'juanfer', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user2@example.com', 610576000, 'Descripcion de user', NULL, 
900, NOW(), '1990-7-15', NULL, 'España', 'Valencia', 'Del Pino', 2, 1, 0, 'B', 28005),

(5, 'Rocio', 'Herranz', 'Acosta', 'rociotaxista', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user3@example.com', 620008730, 'Descripcion de user', 3, 
2, NOW(), '1989-12-17', NULL, 'España', 'Madrid', 'Gran vía', 2, 1, 0, 'A', 28005),

(6, 'Roberto', 'García', 'Martos', 'rober89', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user4@example.com', 620008730, 'Descripcion de user', 5, 
6, NOW(), '1989-05-19', NULL, 'España', 'Madrid', 'Gran vía', 2, 1, 0, 'A', 28005),

(7, 'Felipe', 'Ferrera', 'González', 'felipefit', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user5@example.com', 620008730, 'Descripcion de user', 4, 
10, NOW(), '1991-10-11', NULL, 'España', 'Madrid', 'Gran vía', 2, 1, 0, 'A', 28005),

(8, 'Elena', 'Sanfruto', 'Miguel', 'sanfruto27', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user6@example.com', 620008730, 'Descripcion de user', 7, 
1, NOW(), '1987-10-27', NULL, 'España', 'Madrid', 'Aguilar', 2, 1, 0, 'A', 28005),

(9, 'Marta', 'Martín', 'Herrera', 'marta2', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user7@example.com', 620008730, 'Descripcion de user', 10, 
0, NOW(), '1998-8-02', 'img/usuarios/fotografa.jpg', 'España', 'Madrid', 'Antonio Machado', 2, 1, 0, 'A', 28005),

(10, 'José Francisco', 'Recogido', 'Mateos', 'paco88', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user8@example.com', 620008730, 'Descripcion de user', 9, 
1, NOW(), '1988-9-21', NULL, 'España', 'Madrid', 'Bravo Murillo', 2, 1, 0, 'A', 28005),

(11, 'Marina', 'Rubio', 'Alvarado', 'marinabrico', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user9@example.com', 620008730, 'Descripcion de user', 6, 
0, NOW(), '1985-8-07', NULL, 'España', 'Madrid', 'Antonio Machado', 2, 1, 0, 'A', 28005),

(12, 'Pablo', 'Quevedo', 'Torres', 'pabloqt', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user10@example.com', 620008730, 'Descripcion de user', 8, 
0, NOW(), '1993-6-03', NULL, 'España', 'Madrid', 'Antonio Machado', 2, 1, 0, 'A', 28005),

(13, 'Ana', 'Jiménez', 'Padrones', 'anajipa', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user11@example.com', 610576000, 'Descripcion de user', NULL, 
1, NOW(), '1990-7-15', NULL, 'España', 'Valencia', 'Del Pino', 2, 1, 0, 'B', 28005),

(14, 'Francis', 'Postigo', 'Valverde', 'valvefrancis', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user12@example.com', 610576000, 'Descripcion de user', 24, 
1, NOW(), '1990-7-15', NULL, 'España', 'Valencia', 'Del Pino', 2, 1, 0, 'B', 28005),

(15, 'Carlos', 'Mustelier', 'Montilla', 'montilla', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user13@example.com', 610576000, 'Descripcion de user', 25, 
1, NOW(), '1990-7-15', NULL, 'España', 'Valencia', 'Del Pino', 2, 1, 0, 'B', 28005),

(16, 'Juliana', 'Villa', 'Rico', 'jules1990', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user14@example.com', 610576000, 'Descripcion de user', 23, 
1, NOW(), '1990-7-15', NULL, 'España', 'Valencia', 'Del Pino', 2, 1, 0, 'B', 28005),

(17, 'Verónica', 'Ferriol', 'Núñez', 'veroferriol', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user15@example.com', 610576000, 'Descripcion de user', NULL, 
1, NOW(), '1990-7-15', NULL, 'España', 'Valencia', 'Del Pino', 2, 1, 0, 'B', 28005),

(18, 'Alicia', 'Andrés', 'Castro', 'alicia80', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user16@example.com', 610576000, 'Descripcion de user', NULL, 
1, NOW(), '1980-3-14', NULL, 'España', 'Valencia', 'Del Pino', 2, 1, 0, 'B', 28005),

(19, 'Miguel', 'Cuzo', 'Cabrera', 'miguecabrera', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user17@example.com', 610576000, 'Descripcion de user', NULL, 
1, NOW(), '1990-7-15', NULL, 'España', 'Valencia', 'Del Pino', 2, 1, 0, 'B', 28005),

(20, 'Beatriz', 'Herrero', 'Iglesias', 'beaherrero', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user18@example.com', 610576000, 'Descripcion de user', 14, 
1, NOW(), '1990-7-08', NULL, 'España', 'Valencia', 'Del Pino', 2, 1, 0, 'B', 28005),

(21, 'Alberto', 'López', 'Escalante', 'albertole', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user19@example.com', 610576000, 'Descripcion de user', 11, 
1, NOW(), '1989-6-07', NULL, 'España', 'Valencia', 'Del Pino', 2, 1, 0, 'B', 28005),

(22, 'Andrea', 'LLanos', 'Mendoza', 'andreallanos', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user20@example.com', 610576000, 'Descripcion de user', 15, 
1, NOW(), '1988-5-06', NULL, 'España', 'Valencia', 'Del Pino', 2, 1, 0, 'B', 28005),

(23, 'Claudio', 'Latorre', 'Díaz', 'claudiolatorre', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user21@example.com', 610576000, 'Descripcion de user', 12, 
1, NOW(), '1987-4-05', NULL, 'España', 'Valencia', 'Del Pino', 2, 1, 0, 'B', 28005),

(24, 'Anabel', 'Valverde', 'Toirac', 'anabelvalve', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user22@example.com', 610576000, 'Descripcion de user', 17, 
1, NOW(), '1986-3-04', NULL, 'España', 'Madrid', 'Del Pino', 2, 1, 0, 'B', 28005),

(25, 'Iván', 'Fernández', 'Rubio', 'ivanfer85', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user23@example.com', 610576000, 'Descripcion de user', 13, 
1, NOW(), '1985-2-03', NULL, 'España', 'Valencia', 'Del Pino', 2, 1, 0, 'B', 28005),

(26, 'Julio', 'Amat', 'Pérez', 'julioamat', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user24@example.com', 610576000, 'Descripcion de user', 16, 
1, NOW(), '1990-7-08', NULL, 'España', 'Valencia', 'Del Pino', 2, 1, 0, 'B', 28005),

(27, 'Bárbara', 'Carrillo', 'Oviedo', 'barbaracarrillo', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user25@example.com', 610576000, 'Descripcion de user', 18, 
1, NOW(), '1989-6-07', NULL, 'España', 'Valencia', 'Del Pino', 2, 1, 0, 'B', 28005),

(28, 'Camila', 'Díaz', 'Nito', 'camilanito', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user26@example.com', 610576000, 'Descripcion de user', 22, 
1, NOW(), '1988-5-06', NULL, 'España', 'Valencia', 'Del Pino', 2, 1, 0, 'B', 28005),

(29, 'Diego', 'Escalona', 'Méndez', 'diegoescalona', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user27@example.com', 610576000, 'Descripcion de user', 19, 
1, NOW(), '1987-4-05', NULL, 'España', 'Valencia', 'Del Pino', 2, 1, 0, 'B', 28005),

(30, 'Ernesto', 'Ferrera', 'López', 'ernestoferrera', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user28@example.com', 610576000, 'Descripcion de user', 20, 
1, NOW(), '1986-3-04', NULL, 'España', 'Valencia', 'Del Pino', 2, 1, 0, 'B', 28005),

(31, 'Flavio', 'González', 'Hernández', 'flaviogon', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user29@example.com', 610576000, 'Descripcion de user', 21, 
1, NOW(), '1985-2-03', NULL, 'España', 'Valencia', 'Del Pino', 2, 1, 0, 'B', 28005);

INSERT INTO CONVERSACIONES (ID, USUARIO1, USUARIO2) VALUES
(1, 3, 4),
(2, 2, 12),
(3, 2, 11),
(4, 2, 19),
(5, 2, 5),
(6, 2, 7);

SET @INICIO := NOW();
INSERT INTO MENSAJES (ID, CONVERSACION, AUTOR, CONTENIDO, FECHA_HORA, ESTADO) VALUES
(1,1,3,'mensaje de prueba',NOW(), 2),
(2,1,4,'mensaje de respuesta',NOW(), 2),
(3,2,12,'Hola. Podrías configurarme un ordenador que me estoy montando? ',NOW(), 2),
(4,2,2,'Hola',NOW(), 2),
(5,2,2,'Si, podría realizar este servicio. Qué día sería?',NOW(), 2),
(6,2,12,'Te viene bien el viernes?',NOW(), 2),
(7,2,2,'Si, perfecto. Nos vemos el viernes por la mañana?',NOW(), 2),
(8,2,12,'Perfecto. Hasta el viernes',NOW(), 2),
(9,3,2,'Hola Marina',NOW(), 2),
(10,3,2,'Te contrato para un servicio de restaurar un armario de madera. Te viene bien?',NOW(), 2),
(11,3,11,'Buenas, puedo hacerlo sin problema. Podría ser el sábado de la semana que viene?',NOW(), 2),
(12,3,19,'Hola Manuela. He visto que ofreces servicio de informática',NOW(), 2),
(13,4,19,'Me gustaría contratarte para realizar una página web de mi tienda',NOW(), 2),
(14,4,19,'Aún no tengo saldo suficiente dado que no he realizado ningún servicio',NOW(), 2),
(15,4,19,'En cuanto lo tenga me pongo en contacto',NOW(), 2),
(16,4,2,'Hola. Sin problemas, cuando quieras me escribes y me comentas el proyecto :)',NOW(), 2),
(17,5,2,'Hola. Me gustaría contratarla para el lunes a las 9 am, Podría?',NOW(), 2),
(18,6,2,'Hola. Busco un entrenador personal.',NOW(), 2),
(19,6,2,'Quería saber si podría ver tu CV. Aparte de entrenamiento das pautas de la alimentación?',NOW(), 2);

INSERT INTO CATEGORIA_SERVICIOS (ID, NOMBRE) VALUES 
(1, 'Informática'),
(2, 'Asesoría'),
(3, 'Transporte'),
(4, 'Gastronomía'),
(5, 'Deporte'),
(6, 'Cuidado y mantenimiento doméstico'),
(7, 'Pintura y escultura'),
(8, 'Jardinería'),
(9, 'Fotografía, cine y edición'),
(10, 'Estética'),
(11, 'Moda y costura'),
(12, 'Imprenta'),
(13, 'Mecánica'),
(14, 'Entretenimiento'),
(15, 'Cuidado infantil'),
(16, 'Cuidado de animales'),
(17, 'Cuidado de mayores'),
(18, 'Otros servicios');

INSERT INTO SERVICIO (ID, TITULO, COSTE, CATEGORIA_SERVICIOS, DESCRIPCION, IMAGEN) VALUES 
(1, 'Servicio de informática', 1, 1, 'Desarrollo de aplicaciones, instalación de software', 'img/servicios/serv_pc.jpg'),
(2, 'Servicio de aplicaciones', 1, 1, 'Desarrollo de aplicaciones', 'img/servicios/serv_app2.jpg'),
(3, 'Taxista 24 horas', 1, 3, 'Servicio de taxista 24 horas dentro de Madrid.', 'img/servicios/serv_taxis.jpg'),
(4, 'Entrenador Personal', 1, 5, 'Titulado en INEF. Clases guiadas en el domicilio o gimnasio acordado', 'img/servicios/serv_entrenador.jpg'),
(5, 'Servicio de Jardinería', 1, 8, 'Servicio de jardinera por las mañanas', 'img/servicios/serv_jardineria.jpg'),
(6, 'Arreglos en tu hogar', 1, 6, 'Todo tipo de arreglos de bricolaje a domicilio', 'img/servicios/serv_bricolaje.jpg'),
(7, 'Profesora de refuerzo', 1, 10, 'Servicio de clases particulares para estudiantes de instituto', 'img/servicios/serv_profesor.jpg'),
(8, 'Pintar tu hogar', 1, 6, 'Servicio de pintar interiores', 'img/servicios/serv_pintura.jpg'),
(9, 'Sastre', 1, 11, 'Sastre. Arreglos de prendas de vestir masculina', 'img/servicios/serv_sastre.jpg'),
(10, 'Sesiones de fotos', 1, 9, 'Sesiones fotográficas en estudio o al aire libre', 'img/servicios/serv_foto.jpg'),
(11, 'Chef para eventos', 1, 4, 'Chef titulado para todo tipo de eventos', 'img/servicios/serv_chef.jpg'),
(12, 'Zapatero ', 1, 11, 'Servicio de reparación de zapatos', 'img/servicios/serv_zapatero.jpg'),
(13, 'Servicio para cuidar mayores', 1, 17, 'Cuidador titulado', 'img/servicios/serv_cuidador.jpg'),
(14, 'Cuidadora de perros', 1, 16, 'Puedo pasear o cuidar a tu mascota durante una temporada', 'img/servicios/serv_cuidadoraperros.jpg'),
(15, 'Cantante para eventos', 1, 14, 'Cantante profesional para todo tipo de eventos', 'img/servicios/serv_cantante.jpg'),
(16, 'Restaurador de cuadros', 1, 7, 'Graduado en bellas artes y profesional restaurando cuadros', 'img/servicios/serv_restaurador.jpg'),
(17, 'Niñera', 1, 15, 'Estudiante universitaria con experiencia cuidando niños', 'img/servicios/serv_ninera.jpg'),
(18, 'Modista', 1, 11, 'Confección y arreglo de prendas', 'img/servicios/serv_modista.jpg'),
(19, 'Videos para eventos', 1, 9, 'Grabación y edición de videos para eventos', 'img/servicios/serv_video.jpg'),
(20, 'Maquillador profesional', 1, 10, 'Maquillador profesional para eventos', 'img/servicios/serv_maquillador.jpg'),
(21, 'Mecánico', 1, 13, 'Mecánico de coches y motos', 'img/servicios/serv_mecanico.jpg'),
(22, 'Mecánica de electrodomésticos', 1, 13, 'Mecánica titulada. Me presentas tu problema y lo arreglo', 'img/servicios/serv_mecanica2.jpg'),
(23, 'Fontanera', 1, 6, 'Servicio de fontanería profesional', 'img/servicios/serv_fontanera.jpg'),
(24, 'Servicio de imprenta', 1, 12, 'Impresiones a recoger en local o enviadas a domicilio', 'img/servicios/serv_imprenta.jpg'),
(25, 'Servicio de cuidado doméstico', 1, 6, 'Limpieza y mantenimiento del hogar por las mañanas', 'img/servicios/serv_limpieza.jpg');


INSERT INTO SERVICIOS_CONTRATADOS (ID, USUARIO_CONTRATADOR, USUARIO_REALIZADOR, SERVICIO, FECHA_SOLICITUD, FECHA_REALIZACION, FECHA_FINALIZACION, ESTADO) VALUES 
(1, 19, 2, 1, NOW(), NULL, NULL, 1),
(2, 18, 2, 1, NOW(), NULL, NULL, 1),
(3, 17, 2, 1, NOW(), NULL, NULL, 1),
(4, 16, 2, 1, NOW(), NOW(), NULL, 2),
(5, 15, 2, 1, NOW(), NOW(), NULL, 2),
(6, 14, 2, 1, NOW(), NOW(), NOW(), 3),
(7, 2, 12, 8, NOW(), NOW(), NULL, 2),
(8, 2, 8, 7, NOW(), NOW(), NULL, 2),
(9, 2, 11, 6, NOW(), NOW(), NULL, 2),
(10, 2, 6, 5, NOW(), NOW(), NOW(), 3),
(11, 2, 7, 4, NOW(), NOW(), NOW(), 3),
(12, 2, 5, 3, NOW(), NULL, NULL, 4),
(13, 2, 3, 2, NOW(), NULL, NULL, 4),
(14, 2, 29, 19, NOW(), NOW(), NOW(), 3),
(15, 2, 28, 22, NOW(), NOW(), NOW(), 3),
(16, 27, 2, 2, NOW(), NOW(), NOW(), 3),
(17, 26, 2, 2, NOW(), NOW(), NOW(), 3),
(18, 25, 2, 2, NOW(), NOW(), NOW(), 3),
(19, 3, 31, 21, NOW(), NOW(), NOW(), 3),
(20, 4, 29, 19, NOW(), NOW(), NOW(), 3),
(21, 5, 27, 18, NOW(), NOW(), NOW(), 3);

INSERT INTO FORO (ID, TEMA_FOROS, ASUNTO) VALUES 
(1, 1, 'Foro para discutir sobre los servicios de informatica'),
(2, 2, 'Importante, ayuda con Asesoría'),
(3, 3, 'Foro sobre transporte'),
(4, 4, 'Ayudaaa. Necesito un fontanero');

INSERT INTO COMENTARIOS_FORO (ID, FORO, CONTENIDO, USUARIO_CREADOR, FECHA_CREACION, ID_PADRE) VALUES 
(1, 1, 'Necesito ayuda con un problema de mi CPU', 3, NOW(), NULL),
(2, 2, 'Busco asesor para cubrir horas en una empresa.', 3, NOW(), NULL),
(3, 3, 'Buenas tardes, soy taxista y quería hablar sobre qué opináis sobre el crecimiento de empresas como UBER.', 5, NOW(), NULL),
(4, 4, 'Necesito ayuda sobre herramientas de fontanería.', 2, NOW(), NULL),
(5, 1, 'Que problema tienes?', 2, NOW(), 1),
(6, 1, 'He visto que el uso del procesador está al máximo y todo los programas van muy lentos. Tienes alguna idea de qué puedo hacer?', 3, NOW(), 1),
(7, 1, 'Probablemente necesites una limpieza en el PC incluso cambiar de procesador', 2, NOW(), 1),
(8, 1, 'Genial contratare un servicio de informatica. Gracias.', 3, NOW(), 1),
(9, 1, 'De nada!', 2, NOW(), 1),
(10, 3, 'Pues para los jóvenes es múy práctico pedir Uber y pagar desde un aplicación.', 24, NOW(), 3),
(11, 3, 'Busco algun servicio de transporte para llevar material de sesión fotográfica.', 2, NOW(), NULL),
(12, 3, 'Busco un minibus para llevar a un grupo reducido de personas con cierto grado de discapacidad. Es para una pequeña excursión', 8, NOW(), NULL),
(13, 3, 'Algún transportista de cuadros? Se prioriza la delicadeza y cuidado en el transporte', 26, NOW(), NULL),
(14, 3, 'Aprovecho el foro para buscar algun servicio de mudanza, con una furgoneta pequeña es suficiente.', 4, Now(), NULL);

INSERT INTO RESENA (ID, USUARIO_CREADOR, USUARIO_VALORADO, PUNTUACION, COMENTARIO, FECHA_VALORACION) VALUES 
(1, 2, 5, 3, 'Primera resena', NOW()),
(2, 2, 31, 4, 'Me encantó el servicio', NOW()),
(3, 2, 30, 5, 'Ninguna queja, servicio impresionante', NOW()),
(4, 27, 2, 4, 'Buen servicio', NOW()),
(5, 26, 2, 4, 'Trato cordial', NOW()),
(6, 25, 2, 2, 'El servicio fue bueno, pero llegó tarde', NOW()),
(7, 2, 6, 3, 'Muy buen servicio', NOW()),
(8, 2, 31, 4, 'Me gustó mucho, volvería a trabajar con esta persona', NOW()),
(9, 2, 30, 5, 'Trato agradable, buen servicio', NOW());

INSERT INTO SERVICIOS_FAVORITOS (USUARIO, SERVICIO) VALUES
(2, 1);
