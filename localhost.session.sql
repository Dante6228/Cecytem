DROP DATABASE IF EXISTS Cecytem;
CREATE DATABASE Cecytem;
USE Cecytem;

CREATE TABLE tipoUsuario(
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    descripcion VARCHAR(50) NOT NULL
);

CREATE TABLE usuario(
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    ap VARCHAR(50) NOT NULL,
    am VARCHAR(50) NOT NULL,
    pswd VARCHAR(255) NOT NULL,
    usuario VARCHAR(50) NOT NULL,
    idTipo INT NOT NULL,
    FOREIGN KEY (idTipo) REFERENCES tipoUsuario(id)
);

CREATE TABLE semestre(
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    descripcion VARCHAR(50) NOT NULL
);

CREATE TABLE grupo(
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    descripcion VARCHAR(50) NOT NULL
);

CREATE TABLE parcial(
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    descripcion VARCHAR(50) NOT NULL
);

CREATE TABLE semestre_grupo(
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    idSemestre INT NOT NULL,
    idGrupo INT NOT NULL,
    FOREIGN KEY (idSemestre) REFERENCES semestre(id),
    FOREIGN KEY (idGrupo) REFERENCES grupo(id)
);

CREATE TABLE semestre_grupo_parcial(
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    idSG INT NOT NULL,
    idParcial INT NOT NULL,
    FOREIGN KEY (idSG) REFERENCES semestre_grupo(id),
    FOREIGN KEY (idParcial) REFERENCES parcial(id)
);

CREATE TABLE materia(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    descripcion VARCHAR(50) NOT NULL
);

CREATE TABLE maestro(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL
);

CREATE TABLE materia_maestro(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    idMateria INT NOT NULL,
    idMaestro INT NOT NULL,
    FOREIGN KEY (idMateria) REFERENCES materia(id),
    FOREIGN KEY (idMaestro) REFERENCES maestro(id)
);

CREATE TABLE tema (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    descripcion VARCHAR(50) NOT NULL
);

CREATE TABLE reactivos(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    pregunta VARCHAR(255) NOT NULL,
    materia_maestro_id INT NOT NULL,
    idTema INT NOT NULL,
    FOREIGN KEY (materia_maestro_id) REFERENCES materia_maestro(id),
    FOREIGN KEY (idTema) REFERENCES tema(id)
);

CREATE TABLE opciones (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    reactivo_id INT NOT NULL,
    descripcion VARCHAR(50) NOT NULL,
    es_correcta BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (reactivo_id) REFERENCES reactivos(id)
);

CREATE TABLE examen(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(100) NOT NULL
);

CREATE TABLE examen_reactivo (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    examen_id INT NOT NULL,
    reactivo_id INT NOT NULL,
    FOREIGN KEY (examen_id) REFERENCES examen(id),
    FOREIGN KEY (reactivo_id) REFERENCES reactivos(id)
);

-- //////////////////////////////////////////////////////////
-- INSERCIONES A TABLAS NECESARIAS
-- //////////////////////////////////////////////////////////

INSERT INTO tipoUsuario (descripcion) VALUES 
    ('Administrador'),
    ('Empleado');

INSERT INTO usuario (nombre, ap, am, pswd, usuario, idTipo) VALUES
    ('Director', 'General', 'Administrador', '123', 'Admin', 1);

INSERT INTO semestre (descripcion) VALUES
    ('Primer Semestre'),
    ('Tercer Semestre'),
    ('Quinto Semestre');

INSERT INTO grupo (descripcion) VALUES
    ('101'),
    ('102'),
    ('103'),
    ('104'),
    ('105'),
    ('301'),
    ('302'),
    ('303'),
    ('304'),
    ('305'),
    ('501'),
    ('502'),
    ('503'),
    ('504'),
    ('505');

INSERT INTO parcial (descripcion) VALUES
    ('Primer Parcial'),
    ('Segundo Parcial'),
    ('Tercer Parcial');

INSERT INTO semestre_grupo (idSemestre, idGrupo) VALUES
    (1, 1),
    (1, 2),
    (1, 3),
    (1, 4),
    (1, 5),
    (2, 6),
    (2, 7),
    (2, 8),
    (2, 9),
    (2, 10),
    (3, 11),
    (3, 12),
    (3, 13),
    (3, 14),
    (3, 15);

INSERT INTO semestre_grupo_parcial (idSG, idParcial) VALUES
    (1, 1), (1, 2), (1, 3),
    (2, 1), (2, 2), (2, 3),
    (3, 1), (3, 2), (3, 3),
    (4, 1), (4, 2), (4, 3),
    (5, 1), (5, 2), (5, 3),
    (6, 1), (6, 2), (6, 3),
    (7, 1), (7, 2), (7, 3),
    (8, 1), (8, 2), (8, 3),
    (9, 1), (9, 2), (9, 3),
    (10, 1), (10, 2), (10, 3),
    (11, 1), (11, 2), (11, 3),
    (12, 1), (12, 2), (12, 3),
    (13, 1), (13, 2), (13, 3),
    (14, 1), (14, 2), (14, 3),
    (15, 1), (15, 2), (15, 3);


INSERT INTO maestro (nombre) VAlUES
    ('Gilberto'),
    ('Tarcisio'),
    ('Julio'),
    ('Yulissa'),
    ('Mauricio');

INSERT INTO materia (descripcion) VALUES
    ('Cálculo integral'),
    ('Física II'),
    ('Inglés V'),
    ('Ciencia, Tecnología, Sociedad y Valores'),
    ('Bases de datos'),
    ('Páginas Web');

INSERT INTO materia_maestro (idMateria, idMaestro) VALUES
    (1, 1),
    (2, 2),
    (3, 3),
    (4, 4),
    (5, 5),
    (6, 5);

-- //////////////////////////////////////////////////////////
-- INSERCIONES A REACTIVOS Y EXAMENES
-- //////////////////////////////////////////////////////////

-- CALCULO INTEGRAL

INSERT INTO tema (descripcion) VALUES
    ('Antiderivadas'),
    ('Integrales indefinidas'),
    ('Métodos de integración'),
    ('Integrales definidas'),
    ('Teorema fundamental del cálculo');


INSERT INTO reactivos (pregunta, materia_maestro_id, idTema) VALUES
    ('¿Cuál es la antiderivada de f(x) = 3x^2?', 1, 1),
    ('¿Cuál es la antiderivada de f(x) = 4x^3?', 1, 1),
    ('¿La antiderivada de una constante c es?', 1, 1),
    ('¿Cuál es la antiderivada de f(x) = e^x?', 1, 1),
    ('¿Cuál es la antiderivada de f(x) = 1/x?', 1, 1),
    
    ('¿Cuál de las siguientes es la fórmula correcta para la integral indefinida de una constante c?', 1, 2),
    ('¿Cuál es la integral indefinida de ∫ cos(x) dx?', 1, 2),
    ('¿Cuál es la integral indefinida de ∫ 3x^2 dx?', 1, 2),
    ('¿Cuál es la integral indefinida de ∫ 1/(x^2) dx?', 1, 2),
    ('¿Cuál es la integral indefinida de ∫ x^2 dx?', 1, 2),

    ('¿Qué método de integración usarías para resolver ∫ x e^x dx?', 1, 3),
    ('¿Qué método usarías para resolver ∫ x^3 dx?', 1, 3),
    ('¿Qué método usarías para resolver ∫ ln(x) dx?', 1, 3),
    ('¿Qué método se debe usar para ∫ 2x/(x^2 + 1) dx?', 1, 3),
    ('¿Qué método de integración es adecuado para ∫ 1/(x + 1) dx?', 1, 3),

    ('¿Cuál es el valor de ∫_1^2 (3x^2) dx?', 1, 4),
    ('¿Cuál es el resultado de ∫_0^\pi sin(x) dx?', 1, 4),
    ('¿Cuál es el valor de ∫_1^3 x dx?', 1, 4),
    ('¿Cuál es el área bajo la curva de f(x) = 2x desde x=1 hasta x=3?', 1, 4),
    ('Si ∫_0^3 (2x + 1) dx es una integral definida, ¿cuál es el resultado?', 1, 4),

    ('¿Cuál de las siguientes es la primera parte del teorema fundamental del cálculo?', 1, 5),
    ('¿Cuál de las siguientes es la segunda parte del teorema fundamental del cálculo?', 1, 5),
    ('¿Qué relación describe el teorema fundamental del cálculo?', 1, 5),
    ('¿Cuál es el valor de ∫_a^b f(x) dx según el teorema fundamental del cálculo?', 1, 5),
    ('¿Qué nos dice el teorema fundamental del cálculo sobre las integrales definidas?', 1, 5);

-- Antiderivadas
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
    (1, 'x^3 + C', TRUE),
    (1, 'x^2 + C', FALSE),
    (1, '(3/2)x^3 + C', FALSE),
    (1, '(x^3)/3 + C', FALSE),

    (2, 'x^4 + C', FALSE),
    (2, '(1/4)x^4 + C', TRUE),
    (2, 'x^5 + C', FALSE),
    (2, 'x^4/4 + C', FALSE),

    (3, 'cx + C', TRUE),
    (3, 'c + x', FALSE),
    (3, '(c^2)/2 + C', FALSE),
    (3, 'cx^2 + C', FALSE),

    (4, 'e^x + C', TRUE),
    (4, 'e^x', FALSE),
    (4, 'ln(x) + C', FALSE),
    (4, 'xe^x + C', FALSE),

    (5, 'ln(|x|) + C', TRUE),
    (5, '1/x^2 + C', FALSE),
    (5, 'x + C', FALSE),
    (5, '-ln(x) + C', FALSE);

-- Integrales Indefinidas
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
    (6, '∫ c dx = cx + C', TRUE),
    (6, '∫ c dx = c + x', FALSE),
    (6, '∫ c dx = c^2x', FALSE),
    (6, '∫ c dx = cx^2', FALSE),

    (7, 'sin(x) + C', TRUE),
    (7, '-sin(x) + C', FALSE),
    (7, 'cos(x) + C', FALSE),
    (7, 'cos(x) - C', FALSE),

    (8, 'x^3 + C', TRUE),
    (8, '3x^3 + C', FALSE),
    (8, 'x^2 + C', FALSE),
    (8, '(x^3)/3 + C', FALSE),

    (9, '-1/x + C', TRUE),
    (9, '1/x + C', FALSE),
    (9, '-ln(x) + C', FALSE),
    (9, 'x^(-1) + C', FALSE),

    (10, '(x^3)/3 + C', TRUE),
    (10, 'x^2 + C', FALSE),
    (10, 'x^3 + C', FALSE),
    (10, '(x^2)/2 + C', FALSE);

-- Métodos de Integración
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
    (11, 'Integración por sustitución', FALSE),
    (11, 'Integración por partes', TRUE),
    (11, 'Integración directa', FALSE),
    (11, 'Regla de la cadena', FALSE),

    (12, 'Integración por sustitución', FALSE),
    (12, 'Integración por partes', FALSE),
    (12, 'Integración directa', TRUE),
    (12, 'Descomposición en fracciones parciales', FALSE),

    (13, 'Integración por partes', TRUE),
    (13, 'Regla del producto', FALSE),
    (13, 'Integración por sustitución', FALSE),
    (13, 'Regla de la cadena', FALSE),

    (14, 'Sustitución con u = x^2 + 1', TRUE),
    (14, 'Integración por partes', FALSE),
    (14, 'Descomposición en fracciones parciales', FALSE),
    (14, 'Regla del cociente', FALSE),

    (15, 'Integración por sustitución', TRUE),
    (15, 'Integración por partes', FALSE),
    (15, 'Descomposición en fracciones parciales', FALSE),
    (15, 'Regla de la cadena', FALSE);

-- Integrales Definidas
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
    (16, '7', TRUE),
    (16, '5', FALSE),
    (16, '4', FALSE),
    (16, '8', FALSE),

    (17, '0', TRUE),
    (17, '1', FALSE),
    (17, '2', FALSE),
    (17, 'π', FALSE),

    (18, '4', TRUE),
    (18, '6', FALSE),
    (18, '5', FALSE),
    (18, '3', FALSE),

    (19, '8', TRUE),
    (19, '7', FALSE),
    (19, '6', FALSE),
    (19, '10', FALSE),

    (20, '14', TRUE),
    (20, '12', FALSE),
    (20, '13.5', FALSE),
    (20, '15', FALSE);

-- Teorema Fundamental del Cálculo
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
    (21, 'La derivada de la integral de una función es la propia función', TRUE),
    (21, 'La integral definida se puede evaluar con el límite de una suma de Riemann', FALSE),
    (21, 'La integral indefinida es siempre constante', FALSE),
    (21, 'La integral de una constante es cero', FALSE),

    (22, 'La integral definida de una función es el área bajo la curva entre dos puntos', TRUE),
    (22, 'La integral indefinida es igual a cero', FALSE),
    (22, 'La integral de una constante es cero', FALSE),
    (22, 'La derivada de una constante es cero', FALSE),

    (23, 'Entre derivadas e integrales', TRUE),
    (23, 'Entre límites e integrales', FALSE),
    (23, 'Entre derivadas y límites', FALSE),
    (23, 'Entre funciones exponenciales', FALSE),

    (24, 'f(b) - f(a)', TRUE),
    (24, '0', FALSE),
    (24, 'f(a) + f(b)', FALSE),
    (24, 'f\'(b) - f\'(a)', FALSE);

