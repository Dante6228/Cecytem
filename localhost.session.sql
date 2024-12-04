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
    actividad BOOLEAN NOT NULL,
    idTipo INT NOT NULL,
    FOREIGN KEY (idTipo) REFERENCES tipoUsuario(id) ON DELETE CASCADE
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
    FOREIGN KEY (idSemestre) REFERENCES semestre(id) ON DELETE CASCADE, 
    FOREIGN KEY (idGrupo) REFERENCES grupo(id) ON DELETE CASCADE
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
    FOREIGN KEY (idMateria) REFERENCES materia(id) ON DELETE CASCADE,
    FOREIGN KEY (idMaestro) REFERENCES maestro(id) ON DELETE CASCADE
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
    FOREIGN KEY (idParcial) REFERENCES parcial(id) ON DELETE CASCADE,
    FOREIGN KEY (materia_maestro_id) REFERENCES materia_maestro(id) ON DELETE CASCADE,
    FOREIGN KEY (idTema) REFERENCES tema(id) ON DELETE CASCADE
);

CREATE TABLE opciones (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    reactivo_id INT NOT NULL,
    descripcion VARCHAR(50) NOT NULL,
    es_correcta BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (reactivo_id) REFERENCES reactivos(id) ON DELETE CASCADE
);

CREATE TABLE examen(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(100) NOT NULL
);

CREATE TABLE examen_reactivo (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    examen_id INT NOT NULL,
    reactivo_id INT NOT NULL,
    FOREIGN KEY (examen_id) REFERENCES examen(id) ON DELETE CASCADE,
    FOREIGN KEY (reactivo_id) REFERENCES reactivos(id) ON DELETE CASCADE
);

CREATE TABLE examen_preguntas (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    idExamen INT NOT NULL,
    idPregunta INT NOT NULL,
    FOREIGN KEY (idExamen) REFERENCES examen(id) ON DELETE CASCADE,
    FOREIGN KEY (idPregunta) REFERENCES reactivos(id) ON DELETE CASCADE
);

-- //////////////////////////////////////////////////////////
-- INSERCIONES A TABLAS NECESARIAS
-- //////////////////////////////////////////////////////////

INSERT INTO tipoUsuario (descripcion) VALUES 
    ('Director'),
    ('Coordinador Escolar'),
    ("Control Escolar"),
    ("Vinculación"),
    ("Orientación");

INSERT INTO usuario (nombre, ap, am, pswd, usuario, actividad, idTipo) VALUES
    ('Yovany', 'Vergara', 'Cortés', 'Contraseña', 'Director', 1, 1),
    ('Grisel', 'Becerra', 'Olmos', 'Contraseña', 'Grisel', 1, 2),
    ('Marcela', 'Pérez', 'Rodríguez', 'Contraseña', 'Marcela', 1, 2),
    ('Israel', 'Mendoza', 'Enzaldo', 'Contraseña', 'Israel', 1, 3),
    ('Gladys Liliana', 'Cruz', 'Garcia', 'Contraseña', 'Gladys Liliana', 1, 4),
    ('Jaqueline', 'Curiel', 'Rios', 'Contraseña', 'Jaqueline', 1, 4),
    ('Aura Jimena', 'Fajardo', 'Lopez', 'Contraseña', 'Aura Jimena', 1, 4),
    ('Juana Maria', 'Luna', 'Vital', 'Contraseña', 'Juana Maria', 1, 5),
    ('Denesis Pamela', 'Morales', 'Rivero', 'Contraseña', 'Morales Rivero', 1, 5),
    ('Rosario Elena', 'Romo', 'Torres', 'Contraseña', 'Rosario Elena', 1, 5),
    ('Gabriela', 'Rosas', 'Islas', 'Contraseña', 'Gabriela', 1, 5),
    ('Itzel', 'Velazquez', 'Aguilar', 'Contraseña', 'Itzel', 1, 5);

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

-- Insertar el nuevo tema

INSERT INTO tema (descripcion) VALUES
('Cinemática'),
('Movimiento circular'),
('Trabajo y energía');

INSERT INTO reactivos (pregunta, materia_maestro_id, idTema, idParcial) VALUES
('¿Cuál es la fórmula para la posición en movimiento rectilíneo uniformemente acelerado?', 2, 9, 1),
('¿¿Qué representa la pendiente en un gráfico de posición vs. tiempo?', 2, 9, 1),
('¿Qué es la velocidad angular?', 2, 10, 1),
('¿Cuál es la fórmula de la aceleración centrípeta?', 2, 10, 1),
('¿Qué es el trabajo en física?', 2, 11, 1),
('¿Cuál es la unidad de trabajo en el SI?', 2, 11, 1);

-- Opciones para la pregunta 1 del parcial 1
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(41, 'x = x0 + vt + (1/2)at^2', 1),
(41, 'x = vt + (1/2)at^2', 0),
(41, 'x = x0 + vt', 0),
(41, 'x = x0 + v^2t', 0);

-- Opciones para la pregunta 2 del parcial 1
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(42, 'Velocidad', 1),
(42, 'Aceleración', 0),
(42, 'Posición', 0),
(42, 'Desplazamiento', 0);

-- Opciones para la pregunta 3 del parcial 1
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(43, 'La velocidad de un objeto en línea recta', 0),
(43, 'La rapidez en movimiento circular', 0),
(43, 'El cambio de ángulo por unidad de tiempo', 1),
(43, 'La aceleración centrípeta', 0);

-- Opciones para la pregunta 4 del parcial 1
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(44, 'ac = v^2/r', 1),
(44, 'ac = r/v', 0),
(44, 'ac = vt', 0),
(44, 'ac = v^2/2r', 0);

-- Opciones para la pregunta 5 del parcial 1
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(45, 'Fuerza por distancia', 1),
(45, 'Trabajo por energía', 0),
(45, 'Trabajo por velocidad', 0),
(45, 'Energía por distancia', 0);

-- Opciones para la pregunta 6 del parcial 1
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(46, 'Joule (J)', 1),
(46, 'Newton (N)', 0),
(46, 'Pascal (Pa)', 0),
(46, 'Watts (W)', 0);

-- //////////////////////////////////////////////////////////
-- FÍSICA II / PARCIAL 2
-- //////////////////////////////////////////////////////////

-- Insertar el nuevo tema

INSERT INTO tema (descripcion) VALUES
('Dinámica'),
('Fuerzas de fricción'),
('Gravitación');

INSERT INTO reactivos (pregunta, materia_maestro_id, idTema, idParcial) VALUES
('¿Cuál es la segunda ley de Newton?', 2, 12, 2),
('¿La unidad de fuerza en el SI es?', 2, 12, 2),
('¿Qué tipo de fricción se opone al movimiento de un objeto en reposo?', 2, 13, 2),
('¿Cuál es la fórmula de la fuerza de fricción?', 2, 13, 2),
('¿Cuál es la ley de gravitación universal?', 2, 14, 2),
('¿La aceleración debida a la gravedad en la Tierra es aproximadamente?', 2, 14, 2);

-- Opciones para la pregunta 1 del parcial 2
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(47, 'F = ma', 1),
(47, 'F = m + a', 0),
(47, 'F = ma^2', 0),
(47, 'F = m/a', 0);

-- Opciones para la pregunta 2 del parcial 2
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(48, 'Nueva (N)', 1),
(48, 'Kilogramo (kg)', 0),
(48, 'Joule (J)', 0),
(48, 'Watt (W)', 0);

-- Opciones para la pregunta 3 del parcial 2
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(49, 'Fricción estática', 1),
(49, 'Fricción cinética', 0),
(49, 'Fricción dinámica', 0),
(49, 'Fricción de roce', 0);

-- Opciones para la pregunta 4 del parcial 2
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(50, 'Ff = μN', 1),
(50, 'Ff = ma', 0),
(50, 'Ff = mg', 0),
(50, 'Ff = ρV', 0);

-- Opciones para la pregunta 5 del parcial 2
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(51, 'F = G(m1m2/r^2)', 1),
(51, 'F = m1m2', 0),
(51, 'G = m1m2', 0),
(51, 'F = mgh', 0);

-- Opciones para la pregunta 6 del parcial 2
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(52, '9.81 m/s^2', 1),
(52, '10 m/s^2', 0),
(52, '9.8 m/s^2', 0),
(52, '8.9 m/s^2', 0);

-- //////////////////////////////////////////////////////////
-- FÍSICA II / PARCIAL 3
-- //////////////////////////////////////////////////////////

-- Insertar el nuevo tema

INSERT INTO tema (descripcion) VALUES
('Termodinámica'),
('Propiedades de los gases'),
('Fluidos');

INSERT INTO reactivos (pregunta, materia_maestro_id, idTema, idParcial) VALUES
('¿Cuál es la primera ley de la termodinámica?', 2, 15, 3),
('¿Qué es el calor?', 2, 15, 3),
('¿La ley de Boyle establece que?', 2, 16, 3),
('¿La unidad de presión en el SI es?', 2, 16, 3),
('¿Qué es la presión en un fluido?', 2, 17, 3),
('¿Cuál es la fórmula para la presión en un fluido?', 2, 17, 3);

-- Opciones para la pregunta 1 del parcial 3
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(53, 'ΔU = Q - W', 1),
(53, 'ΔU = Q + W', 0),
(53, 'ΔU = Q * W', 0),
(53, 'ΔU = Q/W', 0);

-- Opciones para la pregunta 2 del parcial 3
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(54, 'Transferencia de energía debido a temperatura', 1),
(54, 'Movimiento de moléculas', 0),
(54, 'Forma de energía', 0),
(54, 'Trabajo realizado', 0);

-- Opciones para la pregunta 3 del parcial 3
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(55, 'PV = constante', 1),
(55, 'PV = nRT', 0),
(55, 'PV^2 = constante', 0),
(55, 'P = V/T', 0);

-- Opciones para la pregunta 4 del parcial 3
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(56, 'Pascal (Pa)', 1),
(56, 'Bar (bar)', 0),
(56, 'Atmósfera (atm)', 0),
(56, 'Joule (J)', 0);

-- Opciones para la pregunta 5 del parcial 3
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(57, 'Fuerza por unidad de área', 1),
(57, 'Volumen por unidad de área', 0),
(57, 'Masa por volumen', 0),
(57, 'Velocidad por volumen', 0);

-- Opciones para la pregunta 6 del parcial 3
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(58, 'P = F/A', 1),
(58, 'P = m/V', 0),
(58, 'P = V/F', 0),
(58, 'P = A/F', 0);

-- //////////////////////////////////////////////////////////
-- INGLÉS V / PARCIAL 1
-- //////////////////////////////////////////////////////////

-- Insertar el nuevo tema

INSERT INTO tema (descripcion) VALUES
('Tiempos verbales'),
('Vocabulario'),
('Conectores');

INSERT INTO reactivos (pregunta, materia_maestro_id, idTema, idParcial) VALUES
('¿Cuál es la forma correcta del pasado de "go"?', 3, 18, 1),
('¿Cuál es la forma correcta de "he (to eat)" en pasado?', 3, 18, 1),
('¿Cuál es el antónimo de "happy"?', 3, 19, 1),
('¿Qué significa "to encourage"?', 3, 19, 1),
('¿Cuál es el conector correcto para "I like coffee, _____ I don’t drink it often"?', 3, 20, 1),
('¿Qué conector se usa para añadir información?', 3, 20, 1);

-- Opciones para la pregunta 1 del parcial 1 de Inglés
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(59, 'Goed', 0),
(59, 'Went', 1),
(59, 'Goes', 0),
(59, 'Gone', 0);

-- Opciones para la pregunta 2 del parcial 1 de Inglés
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(60, 'He eats', 0),
(60, 'He eat', 0),
(60, 'He ate', 1),
(60, 'He eaten', 0);

-- Opciones para la pregunta 3 del parcial 1 de Inglés
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(61, 'Sad', 1),
(61, 'Angry', 0),
(61, 'Excited', 0),
(61, 'Scared', 0);

-- Opciones para la pregunta 4 del parcial 1 de Inglés
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(62, 'Desanimar', 0),
(62, 'Motivar', 1),
(62, 'Detener', 0),
(62, 'Atacar', 0);

-- Opciones para la pregunta 5 del parcial 1 de Inglés
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(63, 'But', 1),
(63, 'And', 0),
(63, 'So', 0),
(63, 'Or', 0);

-- Opciones para la pregunta 6 del parcial 1 de Inglés
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(64, 'But', 0),
(64, 'And', 1),
(64, 'So', 0),
(64, 'However', 0);

-- //////////////////////////////////////////////////////////
-- INGLÉS V / PARCIAL 2
-- //////////////////////////////////////////////////////////

-- Insertar el nuevo tema

INSERT INTO tema (descripcion) VALUES
('Gramática'),
('Vocabulario'),
('Frases comúnes');

INSERT INTO reactivos (pregunta, materia_maestro_id, idTema, idParcial) VALUES
('¿Cuál es la estructura de la voz pasiva en presente simple?', 3, 21, 2),
('¿Qué forma del verbo se usa para la primera persona del singular en futuro?', 3, 21, 2),
('¿Cuál es el sinónimo de "difficult"?', 3, 22, 2),
('¿Qué significa "to analyze"?', 3, 22, 2),
('¿Cuál es la forma correcta de "I wish I _____ taller"?', 3, 23, 2),
('¿Cómo se dice "¿Cómo te va?" en inglés?', 3, 23, 2);

-- Opciones para la pregunta 1 del parcial 2 de Inglés
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(65, 'Sujeto + am/is/are + verbo en participio', 1),
(65, 'Sujeto + verb to be + verbo normal', 0),
(65, 'Sujeto + will be + verbo en participio', 0),
(65, 'Sujeto + verbo en participio + verbo normal', 0);

-- Opciones para la pregunta 2 del parcial 2 de Inglés
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(66, 'Am', 0),
(66, 'Will', 1),
(66, 'Be', 0),
(66, 'Have', 0);

-- Opciones para la pregunta 3 del parcial 2 de Inglés
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(67, 'Hard', 1),
(67, 'Easy', 0),
(67, 'Complex', 0),
(67, 'Simple', 0);

-- Opciones para la pregunta 4 del parcial 2 de Inglés
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(68, 'Analizar', 1),
(68, 'Interpretar', 0),
(68, 'Comparar', 0),
(68, 'Contrastar', 0);

-- Opciones para la pregunta 5 del parcial 2 de Inglés
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(69, 'Am', 0),
(69, 'Was', 1),
(69, 'Will be', 0),
(69, 'Be', 0);

-- Opciones para la pregunta 6 del parcial 2 de Inglés
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(70, 'How are you?', 0),
(70, 'How is it going?', 0),
(70, 'How do you do?', 0),
(70, 'All of the above', 1);

-- //////////////////////////////////////////////////////////
-- INGLÉS V / PARCIAL 3
-- //////////////////////////////////////////////////////////

-- Insertar el nuevo tema

INSERT INTO tema (descripcion) VALUES
('Redacción'),
('Conversación'),
('Pronunciación');

INSERT INTO reactivos (pregunta, materia_maestro_id, idTema, idParcial) VALUES
('¿Cuál es la estructura correcta de un párrafo?', 3, 24, 3),
('¿Qué se necesita para tener una buena introducción?', 3, 24, 3),
('¿Cuál es la forma correcta de hacer una pregunta en presente?', 3, 25, 3),
('¿Qué frase usarías para pedir ayuda?', 3, 25, 3),
('¿Cuál de las siguientes palabras tiene el sonido /ʃ/?', 3, 26, 3),
('¿Qué palabra tiene un sonido de vocal diferente?', 3, 26, 3);

-- Opciones para la pregunta 1 del parcial 3 de Inglés
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(71, 'Tema, apoyo, conclusión', 1),
(71, 'Tema, conclusión, apoyo', 0),
(71, 'Soporte, tema, resumen', 0),
(71, 'Tema, apoyo, resumen', 0);

-- Opciones para la pregunta 2 del parcial 3 de Inglés
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(72, 'Un resumen de los puntos', 0),
(72, 'Una frase impactante', 1),
(72, 'Una conclusión clara', 0),
(72, 'Un tema vago', 0);

-- Opciones para la pregunta 3 del parcial 3 de Inglés
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(73, 'Do you like?', 1),
(73, 'Do you likes?', 0),
(73, 'Are you liking?', 0),
(73, 'Does you like?', 0);

-- Opciones para la pregunta 4 del parcial 3 de Inglés
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(74, 'Help me, please!', 1),
(74, 'Can I help you?', 0),
(74, 'I can do it alone.', 0),
(74, 'Do not help me.', 0);

-- Opciones para la pregunta 5 del parcial 3 de Inglés
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(75, 'Shop', 1),
(75, 'Stop', 0),
(75, 'Cap', 0),
(75, 'Top', 0);

-- Opciones para la pregunta 6 del parcial 3 de Inglés
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(76, 'Beat', 0),
(76, 'Bit', 1),
(76, 'Bat', 0),
(76, 'Bite', 0);

-- //////////////////////////////////////////////////////////
-- CIENCIAS SOCIALES / PARCIAL 1
-- //////////////////////////////////////////////////////////

-- Insertar el nuevo tema

INSERT INTO tema (descripcion) VALUES
('Valores'),
('Sociedad'),
('Ética'),
('Derechos humanos'),
('Problemas sociales');

INSERT INTO reactivos (pregunta, materia_maestro_id, idTema, idParcial) VALUES
('¿Qué son los valores?', 4, 27, 1),
('¿Cuál es una característica de una sociedad inclusiva?', 4, 28, 1),
('¿Qué estudia la ética?', 4, 29, 1),
('¿Cuál es un derecho humano fundamental?', 4, 30, 1),
('¿Qué es la pobreza?', 4, 31, 1);

-- Opciones para la pregunta 1 del parcial 1 de Ciencias Sociales
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(77, 'Principios que guían el comportamiento', 1),
(77, 'Habilidades técnicas', 0),
(77, 'Normas de conducta', 0),
(77, 'Ciencias sociales', 0);

-- Opciones para la pregunta 2 del parcial 1 de Ciencias Sociales
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(78, 'Exclusión de grupos', 0),
(78, 'Respeto por la diversidad', 1),
(78, 'Desigualdad económica', 0),
(78, 'Desinterés por los demás', 0);

-- Opciones para la pregunta 3 del parcial 1 de Ciencias Sociales
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(79, 'Las leyes naturales', 0),
(79, 'Las relaciones entre individuos', 0),
(79, 'Los valores y principios morales', 1),
(79, 'Las técnicas de investigación', 0);

-- Opciones para la pregunta 4 del parcial 1 de Ciencias Sociales
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(80, 'Derecho a la educación', 1),
(80, 'Derecho a la tecnología', 0),
(80, 'Derecho a la ciencia', 0),
(80, 'Derecho a la riqueza', 0);

-- Opciones para la pregunta 5 del parcial 1 de Ciencias Sociales
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(81, 'Falta de acceso a recursos económicos', 1),
(81, 'Situación de salud precaria', 0),
(81, 'Desigualdad de género', 0),
(81, 'Acceso a la educación', 0);

-- //////////////////////////////////////////////////////////
-- CIENCIAS SOCIALES / PARCIAL 2
-- //////////////////////////////////////////////////////////

-- Insertar el nuevo tema

INSERT INTO tema (descripcion) VALUES
('Valores'),
('Sociedad'),
('Ética'),
('Derechos humanos'),
('Problemas sociales');

INSERT INTO reactivos (pregunta, materia_maestro_id, idTema, idParcial) VALUES
('¿Cuál de los siguientes es un valor ético?', 4, 32, 2),
('¿Qué es la cultura?', 4, 33, 2),
('¿Qué implica ser ético?', 4, 34, 2),
('¿Qué organización defiende los derechos humanos a nivel mundial?', 4, 35, 2),
('¿Cuál es un problema social actual?', 4, 36, 2);

-- Opciones para la pregunta 1 del parcial 2 de Ciencias Sociales
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(82, 'Respeto', 1),
(82, 'Avaricia', 0),
(82, 'Desprecio', 0),
(82, 'Indiferencia', 0);

-- Opciones para la pregunta 2 del parcial 2 de Ciencias Sociales
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(83, 'Conjunto de costumbres y creencias', 1),
(83, 'Un grupo social específico', 0),
(83, 'Una rama de la ciencia', 0),
(83, 'Un tipo de tecnología', 0);

-- Opciones para la pregunta 3 del parcial 2 de Ciencias Sociales
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(84, 'Actuar solo por interés personal', 0),
(84, 'Considerar el bienestar de los demás', 1),
(84, 'Ignorar las consecuencias de las acciones', 0),
(84, 'Buscar la riqueza', 0);

-- Opciones para la pregunta 4 del parcial 2 de Ciencias Sociales
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(85, 'La ONU', 1),
(85, 'La OEA', 0),
(85, 'La UNESCO', 0),
(85, 'La Cruz Roja', 0);

-- Opciones para la pregunta 5 del parcial 2 de Ciencias Sociales
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(86, 'Cambio climático', 1),
(86, 'Avance tecnológico', 0),
(86, 'Desarrollo económico', 0),
(86, 'Conservación de la cultura', 0);

-- //////////////////////////////////////////////////////////
-- CIENCIAS SOCIALES / PARCIAL 3
-- //////////////////////////////////////////////////////////

-- Insertar el nuevo tema

INSERT INTO tema (descripcion) VALUES
('Valores'),
('Sociedad'),
('Ética'),
('Derechos humanos'),
('Problemas sociales');

INSERT INTO reactivos (pregunta, materia_maestro_id, idTema, idParcial) VALUES
('¿Cuál es un valor que promueve la igualdad?', 4, 37, 3),
('¿Qué es la globalización?', 4, 38, 3),
('¿Cómo se aplica la ética en la sociedad?', 4, 39, 3),
('¿Cuál es un derecho de la infancia?', 4, 40, 3),
('¿Qué es el machismo?', 4, 41, 3);

-- Opciones para la pregunta 1 del parcial 3 de Ciencias Sociales
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(87, 'Equidad', 1),
(87, 'Competencia', 0),
(87, 'Individualismo', 0),
(87, 'Desigualdad', 0);

-- Opciones para la pregunta 2 del parcial 3 de Ciencias Sociales
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(88, 'Interconexión de economías y culturas', 1),
(88, 'Aislamiento cultural', 0),
(88, 'Desarrollo de tecnologías locales', 0),
(88, 'Disminución del comercio internacional', 0);

-- Opciones para la pregunta 3 del parcial 3 de Ciencias Sociales
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(89, 'Definiendo normas morales', 1),
(89, 'Promoviendo la desigualdad', 0),
(89, 'Ignorando las leyes', 0),
(89, 'Rechazando valores', 0);

-- Opciones para la pregunta 4 del parcial 3 de Ciencias Sociales
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(90, 'Derecho a la educación', 1),
(90, 'Derecho a trabajar', 0),
(90, 'Derecho a votar', 0),
(90, 'Derecho a poseer propiedades', 0);

-- Opciones para la pregunta 5 del parcial 3 de Ciencias Sociales
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(91, 'Una forma de igualdad de género', 0),
(91, 'Una actitud de superioridad hacia las mujeres', 1),
(91, 'Un tipo de liderazgo femenino', 0),
(91, 'Un movimiento social', 0);

-- //////////////////////////////////////////////////////////
-- BASES DE DATOS / PARCIAL 1
-- //////////////////////////////////////////////////////////

-- Insertar el nuevo tema

INSERT INTO tema (descripcion) VALUES
('Fundamentos'),
('Modelado'),
('SQL'),
('Relaciones'),
('Integridad');

INSERT INTO reactivos (pregunta, materia_maestro_id, idTema, idParcial) VALUES
('¿Qué es una base de datos?', 5, 42, 1),
('¿Cuál es el objetivo del modelo entidad-relación?', 5, 43, 1),
('¿Qué significa SQL?', 5, 44, 1),
('¿Cuál es una clave primaria?', 5, 45, 1),
('¿Qué es la integridad referencial?', 5, 46, 1);

-- Opciones para la pregunta 1 del parcial 1
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(92, 'Conjunto de datos estructurados', 1),
(92, 'Archivo de texto sin formato', 0),
(92, 'Sistema operativo', 0),
(92, 'Programa de diseño', 0);

-- Opciones para la pregunta 2 del parcial 1
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(93, 'Definir la estructura de la base de datos', 1),
(93, 'Almacenar datos de manera eficiente', 0),
(93, 'Crear aplicaciones web', 0),
(93, 'Desarrollar software', 0);

-- Opciones para la pregunta 3 del parcial 1
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(94, 'Structured Query Language', 1),
(94, 'Standard Query Language', 0),
(94, 'Sequential Query Language', 0),
(94, 'Structured Quality Language', 0);

-- Opciones para la pregunta 4 del parcial 1
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(95, 'Atributo único que identifica un registro', 1),
(95, 'Un campo que permite duplicados', 0),
(95, 'Atributo que se puede modificar', 0),
(95, 'Un campo que no se usa en la base de datos', 0);

-- Opciones para la pregunta 5 del parcial 1
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(96, 'Asegurar que las relaciones entre tablas sean válidas', 1),
(96, 'Eliminar datos duplicados', 0),
(96, 'Proteger datos sensibles', 0),
(96, 'Crear copias de seguridad', 0);

-- //////////////////////////////////////////////////////////
-- BASES DE DATOS / PARCIAL 2
-- //////////////////////////////////////////////////////////

-- Insertar el nuevo tema

INSERT INTO tema (descripcion) VALUES
('SQL'),
('Funciones'),
('Indices'),
('Normalización'),
('Trasacciones');

INSERT INTO reactivos (pregunta, materia_maestro_id, idTema, idParcial) VALUES
('¿Qué comando se usa para seleccionar datos en SQL?', 5, 47, 2),
('¿Qué es una función en SQL?', 5, 48, 2),
('¿Cuál es la función de un índice en una base de datos?', 5, 49, 2),
('¿Qué es la normalización en bases de datos?', 5, 50, 2),
('¿Qué asegura una transacción en bases de datos?', 5, 51, 2);

-- Opciones para la pregunta 1 del parcial 2
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(97, 'SELECT', 1),
(97, 'INSERT', 0),
(97, 'UPDATE', 0),
(97, 'DELETE', 0);

-- Opciones para la pregunta 2 del parcial 2
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(98, 'Código que realiza una tarea específica', 1),
(98, 'Un tipo de base de datos', 0),
(98, 'Una tabla que almacena datos', 0),
(98, 'Un índice de búsqueda', 0);

-- Opciones para la pregunta 3 del parcial 2
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(99, 'Mejorar el rendimiento de las consultas', 1),
(99, 'Almacenar datos temporales', 0),
(99, 'Eliminar datos duplicados', 0),
(99, 'Crear tablas nuevas', 0);

-- Opciones para la pregunta 4 del parcial 2
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(100, 'Proceso de eliminar redundancias en los datos', 1),
(100, 'Aumento del tamaño de la base de datos', 0),
(100, 'Copiar datos en múltiples tablas', 0),
(100, 'Crear claves primarias', 0);

-- Opciones para la pregunta 5 del parcial 2
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(101, 'Consistencia de los datos', 1),
(101, 'Eliminación de datos', 0),
(101, 'Velocidad de acceso', 0),
(101, 'Ampliación de la base de datos', 0);

-- //////////////////////////////////////////////////////////
-- BASES DE DATOS / PARCIAL 3
-- //////////////////////////////////////////////////////////

-- Insertar el nuevo tema

INSERT INTO tema (descripcion) VALUES
('Consultas'),
('Joins'),
('Stored Procedures'),
('Seguridad'),
('Backup');

INSERT INTO reactivos (pregunta, materia_maestro_id, idTema, idParcial) VALUES
('¿Cuál es el propósito de una consulta en SQL?', 5, 52, 3),
('¿Qué hace un JOIN en SQL?', 5, 53, 3),
('¿Qué es un procedimiento almacenado?', 5, 54, 3),
('¿Cuál es una práctica de seguridad en bases de datos?', 5, 55, 3),
('¿Qué es un backup de base de datos?', 5, 56, 3);

-- Opciones para la pregunta 1 del parcial 3
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(102, 'Extraer datos específicos de la base de datos', 1),
(102, 'Eliminar datos de la base de datos', 0),
(102, 'Modificar datos existentes', 0),
(102, 'Crear nuevos índices', 0);

-- Opciones para la pregunta 2 del parcial 3
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(103, 'Combina datos de diferentes tablas', 1),
(103, 'Elimina datos duplicados', 0),
(103, 'Agrega nuevos datos', 0),
(103, 'Modifica la estructura de la tabla', 0);

-- Opciones para la pregunta 3 del parcial 3
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(104, 'Código SQL guardado para su reutilización', 1),
(104, 'Una tabla que almacena datos', 0),
(104, 'Un tipo de índice', 0),
(104, 'Un comando para insertar datos', 0);

-- Opciones para la pregunta 4 del parcial 3
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(105, 'Controlar el acceso a los datos', 1),
(105, 'Eliminar datos sin respaldo', 0),
(105, 'Compartir contraseñas', 0),
(105, 'No usar cifrado', 0);

-- Opciones para la pregunta 5 del parcial 3
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(106, 'Copia de seguridad de los datos', 1),
(106, 'Eliminación de datos obsoletos', 0),
(106, 'Un proceso de actualización', 0),
(106, 'Un tipo de consulta', 0);

-- //////////////////////////////////////////////////////////
-- Páginas Web - Primer Parcial
-- //////////////////////////////////////////////////////////

-- Insertar el nuevo tema

INSERT INTO tema (descripcion) VALUES
('Conexión'),
('Sintaxis'),
('Errores'),
('Configuración');

INSERT INTO reactivos (pregunta, materia_maestro_id, idTema, idParcial) VALUES
('¿Cuál es el primer paso para conectar PHP a MySQL?', 6, 57, 1),
('¿Cuál es la sintaxis correcta para crear una conexión en PHP?', 6, 58, 1),
('¿Qué función se usa para manejar errores de conexión en MySQLi?', 6, 59, 1),
('¿Qué archivo se usa comúnmente para almacenar credenciales de conexión en un proyecto PHP?', 6, 60, 1);

-- Opciones para la pregunta 1 del parcial 1
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(107, 'Definir la consulta SQL', 0),
(107, 'Establecer la conexión con MySQL', 1),
(107, 'Cerrar la conexión', 0),
(107, 'Seleccionar la base de datos', 0);

-- Opciones para la pregunta 2 del parcial 1
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(108, '$conn = new mysqli("host", "user", "pass", "db")', 1),
(108, '$conn = mysqli.new("host", "user", "pass", "db")', 0),
(108, '$conn = mysql.connect("host", "user", "pass", "db")', 0),
(108, '$conn = mysqli.create("host", "user", "pass", "db")', 0);

-- Opciones para la pregunta 3 del parcial 1
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(109, 'mysqli_connect_error()', 1),
(109, 'mysqli_error()', 0),
(109, 'mysqli_connect_fail()', 0),
(109, 'mysqli_error_handling()', 0);

-- Opciones para la pregunta 4 del parcial 1
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(110, '.ftpconfig', 0),
(110, '.env', 0),
(110, 'config.php', 1),
(110, 'credentials.json', 0);

-- //////////////////////////////////////////////////////////
-- Páginas Web - Segundo Parcial
-- //////////////////////////////////////////////////////////

-- Insertar el nuevo tema

INSERT INTO tema (descripcion) VALUES
('Consultas'),
('Join'),
('PDO'),
('Seguridad');

INSERT INTO reactivos (pregunta, materia_maestro_id, idTema, idParcial) VALUES
('¿Cuál es la función para ejecutar una consulta SQL en MySQLi?', 6, 61, 2),
('¿Qué tipo de JOIN combina registros de dos tablas que tienen un valor coincidente?', 6, 62, 2),
('¿Cuál es la principal ventaja de usar PDO en lugar de MySQLi?', 6, 63, 2),
('¿Cuál es una forma de protegerse contra inyecciones SQL?', 6, 64, 2);

-- Opciones para la pregunta 1 del parcial 2
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(111, 'mysqli_query()', 1),
(111, 'mysqli_execute()', 0),
(111, 'mysqli_run_query()', 0),
(111, 'mysqli_fetch()', 0);

-- Opciones para la pregunta 2 del parcial 2
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(112, 'INNER JOIN', 1),
(112, 'OUTER JOIN', 0),
(112, 'CROSS JOIN', 0),
(112, 'LEFT JOIN', 0);

-- Opciones para la pregunta 3 del parcial 2
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(113, 'Compatibilidad con múltiples bases de datos', 1),
(113, 'Mayor velocidad de conexión', 0),
(113, 'Menor uso de memoria', 0),
(113, 'Simplicidad en la sintaxis', 0);

-- Opciones para la pregunta 4 del parcial 2
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(114, 'Usar consultas directas', 0),
(114, 'Escapar entradas del usuario', 1),
(114, 'Eliminar campos de entrada', 0),
(114, 'No usar bases de datos', 0);

-- //////////////////////////////////////////////////////////
-- Páginas Web - Tercer Parcial
-- //////////////////////////////////////////////////////////

-- Insertar el nuevo tema

INSERT INTO tema (descripcion) VALUES
('Procedimientos'),
('Trasacciones'),
('Backup'),
('Debugging');

INSERT INTO reactivos (pregunta, materia_maestro_id, idTema, idParcial) VALUES
('¿Qué es un procedimiento almacenado en MySQL?', 6, 65, 3),
('¿Qué comando se usa para iniciar una transacción en MySQL?', 6, 66, 3),
('¿Qué se debe hacer antes de realizar una actualización de base de datos?', 6, 67, 3),
('¿Qué herramienta se puede usar para depurar errores en PHP?', 6, 68, 3);

-- Opciones para la pregunta 1 del parcial 3
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(115, 'Código SQL guardado para su reutilización', 1),
(115, 'Un tipo de índice', 0),
(115, 'Una consulta de eliminación', 0),
(115, 'Un comando para insertar datos', 0);

-- Opciones para la pregunta 2 del parcial 3
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(116, 'BEGIN', 0),
(116, 'START TRANSACTION', 1),
(116, 'OPEN', 0),
(116, 'BEGIN TRANSACTION', 0);

-- Opciones para la pregunta 3 del parcial 3
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(117, 'Hacer un backup', 1),
(117, 'Eliminar la base de datos', 0),
(117, 'Agregar nuevos datos', 0),
(117, 'Modificar la estructura', 0);

-- Opciones para la pregunta 4 del parcial 3
INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES
(118, 'Xdebug', 1),
(118, 'Apache Server', 0),
(118, 'phpMyAdmin', 0),
(118, 'Postman', 0);
