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
    idParcial INT NOT NULL,
    FOREIGN KEY (idParcial) REFERENCES parcial(id),
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
-- CALCULO INTEGRAL / PARCIAL 1
-- //////////////////////////////////////////////////////////

INSERT INTO tema (descripcion) VALUES
    ('Antiderivadas'),
    ('Integrales Indefinidas'),
    ('Métodos de Integración'),
    ('Integrales Definidas'),
    ('Teorema Fundamental del Cálculo');


-- Inserciones en la tabla 'reactivos'
INSERT INTO reactivos (pregunta, materia_maestro_id, idTema, idParcial) VALUES
    ('¿Cuál es la antiderivada de f(x) = 3x^2?', 1, 1, 1),
    ('¿Cuál es la antiderivada de f(x) = 4x^3?', 1, 1, 1),
    ('¿La antiderivada de una constante c es?', 1, 1, 1),
    ('¿Cuál es la antiderivada de f(x) = e^x?', 1, 1, 1),
    ('¿Cuál es la antiderivada de f(x) = 1/x?', 1, 1, 1),
    ('¿Cuál de las siguientes es la fórmula correcta para la integral indefinida de una constante c?', 1, 2, 1),
    ('¿Cuál es la integral indefinida de ∫ cos(x) dx?', 1, 2, 1),
    ('¿Cuál es la integral indefinida de ∫ 3x^2 dx?', 1, 2, 1),
    ('¿Cuál es la integral indefinida de ∫ 1/(x^2) dx?', 1, 2, 1),
    ('¿Cuál es la integral indefinida de ∫ x^2 dx?', 1, 2, 1),
    ('¿Qué método de integración usarías para resolver ∫ x e^x dx?', 1, 3, 1),
    ('¿Qué método usarías para resolver ∫ x^3 dx?', 1, 3, 1),
    ('¿Qué método usarías para resolver ∫ ln(x) dx?', 1, 3, 1),
    ('¿Qué método se debe usar para ∫ 2x/(x^2 + 1) dx?', 1, 3, 1),
    ('¿Qué método de integración es adecuado para ∫ 1/(x + 1) dx?', 1, 3, 1),
    ('¿Cuál es el valor de ∫_1^2 (3x^2) dx?', 1, 4, 1),
    ('¿Cuál es el resultado de ∫_0^π sin(x) dx?', 1, 4, 1),
    ('¿Cuál es el valor de ∫_1^3 x dx?', 1, 4, 1),
    ('¿Cuál es el área bajo la curva de f(x) = 2x desde x=1 hasta x=3?', 1, 4, 1),
    ('Si ∫_0^3 (2x + 1) dx es una integral definida, ¿cuál es el resultado?', 1, 4, 1),
    ('¿Cuál de las siguientes es la primera parte del teorema fundamental del cálculo?', 1, 5, 1),
    ('¿Cuál de las siguientes es la segunda parte del teorema fundamental del cálculo?', 1, 5, 1),
    ('¿Qué relación describe el teorema fundamental del cálculo?', 1, 5, 1),
    ('¿Cuál es el valor de ∫_a^b f\(x) dx según el teorema fundamental del cálculo?', 1, 5, 1),
    ('¿Qué nos dice el teorema fundamental del cálculo sobre las integrales definidas?', 1, 5, 1);

-- Para las opciones de Antiderivadas
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(1, 'x^3 + C', 1),
(1, 'x^2 + C', 0),
(1, '(3/2)x^3 + C', 0),
(1, '(x^3)/3 + C', 0),
(2, 'x^4 + C', 0),
(2, '(1/4)x^4 + C', 1),
(2, 'x^5 + C', 0),
(2, 'x^4/4 + C', 0),
(3, 'cx + C', 1),
(3, 'c + x', 0),
(3, '(c^2)/2 + C', 0),
(3, 'cx^2 + C', 0),
(4, 'e^x + C', 1),
(4, 'e^x', 0),
(4, 'ln(x) + C', 0),
(4, 'xe^x + C', 0),
(5, 'ln(|x|) + C', 1),
(5, '1/x^2 + C', 0),
(5, 'x + C', 0),
(5, '-ln(x) + C', 0);

-- Para las opciones de Integrales Indefinidas
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(6, '∫ c dx = cx + C', 1),
(6, '∫ c dx = c + x', 0),
(6, '∫ c dx = c^2x', 0),
(6, '∫ c dx = cx^2', 0),
(6, '∫ c dx = cx + C', 1),
(7, 'sin(x) + C', 1),
(7, '-sin(x) + C', 0),
(7, 'cos(x) + C', 0),
(7, 'cos(x) - C', 0),
(8, 'x^3 + C', 0),
(8, '3x^3 + C', 0),
(8, 'x^2 + C', 0),
(8, '(x^3)/3 + C', 1),
(9, '-1/x + C', 1),
(9, '1/x + C', 0),
(9, '-ln(x) + C', 0),
(9, 'x^(-1) + C', 0),
(10, '(x^3)/3 + C', 1),
(10, 'x^2 + C', 0),
(10, 'x^3 + C', 0),
(10, '(x^2)/2 + C', 0);

-- Para las opciones de Métodos de Integración
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(11, 'Integración por sustitución', 0),
(11, 'Integración por partes', 1),
(11, 'Integración directa', 0),
(11, 'Regla de la cadena', 0),
(12, 'Regla del producto', 0),
(12, 'Integración directa', 1),
(12, 'Integración por partes', 0),
(12, 'Descomposición en fracciones parciales', 0),
(13, 'Integración por partes', 1),
(13, 'Regla del producto', 0),
(13, 'Integración por sustitución', 0),
(13, 'Regla de la cadena', 0),
(14, 'Sustitución con u = x^2 + 1', 1),
(14, 'Integración por partes', 0),
(14, 'Descomposición en fracciones parciales', 0),
(14, 'Regla del cociente', 0),
(15, 'Integración por sustitución', 1),
(15, 'Integración por partes', 0),
(15, 'Descomposición en fracciones parciales', 0),
(15, 'Regla de la cadena', 0);

-- Para las opciones de Integrales Definidas
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(16, '7', 1),
(16, '5', 0),
(16, '4', 0),
(16, '8', 0),
(17, '2', 0),
(17, '0', 0),
(17, '1', 0),
(17, 'π', 1),
(18, '4', 1),
(18, '6', 0),
(18, '5', 0),
(18, '3', 0),
(19, '7', 0),
(19, '8', 1),
(19, '6', 0),
(19, '10', 0),
(20, '12', 0),
(20, '13.5', 0),
(20, '15', 0),
(20, '14', 1);

-- Para las opciones de Teorema Fundamental del Cálculo
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(21, 'La derivada de la integral de una función es la propia función', 1),
(21, 'La integral definida se puede evaluar con el límite de una suma de Riemann', 0),
(21, 'La integral indefinida es siempre constante', 0),
(21, 'La integral de una constante es cero', 0),
(22, 'La integral definida de una función es el área bajo la curva entre dos puntos', 1),
(22, 'La integral indefinida es igual a cero', 0),
(22, 'La integral de una constante es cero', 0),
(22, 'La derivada de una constante es cero', 0),
(23, 'Entre derivadas e integrales', 1),
(23, 'Entre límites e integrales', 0),
(23, 'Entre derivadas y límites', 0),
(23, 'Entre funciones exponenciales', 0),
(24, 'f(b) - f(a)', 1),
(24, '0', 0),
(24, 'f(a) + f(b)', 0),
(24, 'f\(b) - f\(a)', 0),
(25, 'Nos permiten calcular el área bajo una curva en un intervalo dado', 1),
(25, 'Solo existen para funciones continuas', 0),
(25, 'Siempre son positivas', 0),
(25, 'Siempre tienen una solución algebraica', 0);

-- //////////////////////////////////////////////////////////
-- CALCULO INTEGRAL / PARCIAL 2
-- //////////////////////////////////////////////////////////

INSERT INTO tema (descripcion) VALUES
('Teorema de Taylor'),
('Integral de Funciones Trigonométricas');

-- Teorema de Taylor
INSERT INTO reactivos (pregunta, materia_maestro_id, idTema, idParcial) VALUES
('¿El teorema de Taylor se usa para?', 1, 6, 2),
('¿La serie de Taylor de f(x) en x=a se basa en?', 1, 6, 2),
('¿Cuál es la forma general de la serie de Taylor?', 1, 6, 2),
('¿La serie de Maclaurin es un caso especial de?', 1, 6, 2),
('¿Cuál es la fórmula de la derivada n-ésima?', 1, 6, 2);

-- Integral de Funciones Trigonométricas
INSERT INTO reactivos (pregunta, materia_maestro_id, idTema, idParcial) VALUES
('¿Cuál es la integral de ∫ sin(x) dx?', 1, 7, 2),
('¿Cuál es la integral de ∫ cos(x) dx?', 1, 7, 2),
('¿Cuál es la integral de ∫ sec^2(x) dx?', 1, 7, 2),
('¿Cuál es la integral de ∫ csc^2(x) dx?', 1, 7, 2),
('¿Cuál es la integral de ∫ tan(x) dx?', 1, 7, 2);

-- Opciones para el reactivo '¿El teorema de Taylor se usa para?'
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(26, 'Aproximar funciones', 1),
(26, 'Resolver ecuaciones diferenciales', 0),
(26, 'Calcular integrales', 0),
(26, 'Encontrar máximos y mínimos', 0);

-- Opciones para el reactivo '¿La serie de Taylor de f(x) en x=a se basa en?'
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(27, 'Derivadas de f(a)', 1),
(27, 'Integrales de f(a)', 0),
(27, 'Valores de f(a)', 0),
(27, 'Máximos y mínimos', 0);

-- Opciones para el reactivo '¿Cuál es la forma general de la serie de Taylor?'
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(28, '∑ (f^n(a)/n!)(x-a)^n', 1),
(28, '∑ (f(x)/n!)(x-a)^n', 0),
(28, '∑ (f(a)/n!)(x-a)^n', 0),
(28, '∑ (f''(a)/n!)(x-a)^n', 0);

-- Opciones para el reactivo '¿La serie de Maclaurin es un caso especial de?'
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(29, 'Serie de Taylor', 1),
(29, 'Serie geométrica', 0),
(29, 'Serie de Fourier', 0),
(29, 'Serie de potencias', 0);

-- Opciones para el reactivo '¿Cuál es la fórmula de la derivada n-ésima?'
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(30, 'f^n(a)', 1),
(30, '(n!)^2', 0),
(30, '(n-1)!', 0),
(30, '(n!)', 0);

-- Opciones para el reactivo '¿Cuál es la integral de ∫ sin(x) dx?'
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(31, '-cos(x) + C', 1),
(31, 'cos(x) + C', 0),
(31, 'sin(x) + C', 0),
(31, '-sin(x) + C', 0);

-- Opciones para el reactivo '¿Cuál es la integral de ∫ cos(x) dx?'
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(32, 'sin(x) + C', 1),
(32, '-cos(x) + C', 0),
(32, '-cos(x) + 1', 0),
(32, 'C + sin(x)', 0);

-- Opciones para el reactivo '¿Cuál es la integral de ∫ sec^2(x) dx?'
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(33, 'tan(x) + C', 1),
(33, 'sec(x) + C', 0),
(33, '-cot(x) + C', 0),
(33, '-sin(x) + C', 0);

-- Opciones para el reactivo '¿Cuál es la integral de ∫ csc^2(x) dx?'
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(34, '-cot(x) + C', 1),
(34, 'sec(x) + C', 0),
(34, '-sin(x) + C', 0),
(34, 'tan(x) + C', 0);

-- Opciones para el reactivo '¿Cuál es la integral de ∫ tan(x) dx?'
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(35, '-ln|cos(x)| + C', 1),
(35, 'ln|sin(x)| + C', 0),
(35, '-cos(x) + C', 0),
(35, 'tan(x) + C', 0);

-- //////////////////////////////////////////////////////////
-- CALCULO INTEGRAL / PARCIAL 3
-- //////////////////////////////////////////////////////////

-- Insertar el nuevo tema
INSERT INTO tema (descripcion) VALUES
('Series de Potencias');

-- Insertar los reactivos correspondientes al tema 'Series de Potencias'
INSERT INTO reactivos (pregunta, materia_maestro_id, idTema, idParcial) VALUES
('¿Una serie de potencias tiene la forma?', 1, 8, 3),
('¿Qué representa c en la serie de potencias?', 1, 8, 3),
('¿Cuál es el intervalo de convergencia?', 1, 8, 3),
('¿Cuál es el radio de convergencia?', 1, 8, 3),
('¿Qué se usa para encontrar el radio de convergencia?', 1, 8, 3);

-- Pregunta: ¿Una serie de potencias tiene la forma?
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(36, '∑ a_n(x-c)^n', 1),
(36, '∑ a_nx^n', 0),
(36, '∑ x^n', 0),
(36, '∑ a_n/n!', 0);

-- Pregunta: ¿Qué representa c en la serie de potencias?
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(37, 'El centro de la serie', 1),
(37, 'La convergencia', 0),
(37, 'El radio de convergencia', 0),
(37, 'El término independiente', 0);

-- Pregunta: ¿Cuál es el intervalo de convergencia?
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(38, 'Donde la serie converge', 1),
(38, 'Donde la serie diverge', 0),
(38, 'Donde la serie es continua', 0),
(38, 'Donde la serie es derivable', 0);

-- Pregunta: ¿Cuál es el radio de convergencia?
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(39, 'Valor máximo de |x-c| donde la serie converge', 1),
(39, 'Valor mínimo de |x-c| donde la serie converge', 0),
(39, 'Valor de la serie', 0),
(39, 'Valor absoluto de la serie', 0);

-- Pregunta: ¿Qué se usa para encontrar el radio de convergencia?
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(40, 'Criterio de D\Alembert', 1),
(40, 'Criterio de Raabe', 0),
(40, 'Criterio de Cauchy', 0),
(40, 'Criterio de Leibniz', 0);

-- //////////////////////////////////////////////////////////
-- FÍSICA II / PARCIAL 1
-- //////////////////////////////////////////////////////////

