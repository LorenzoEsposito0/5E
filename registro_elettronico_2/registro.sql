-- CREAZIONE DATABASE
CREATE DATABASE IF NOT EXISTS db_registro;
USE db_registro;

-- TABELLE

-- 1. Indirizzo
CREATE TABLE Indirizzo (
    id_indirizzo INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL
);
CREATE TABLE Credenziali (
    username VARCHAR(50) PRIMARY KEY,
    psw VARCHAR(255) NOT NULL
);

-- 2. Materia
CREATE TABLE Materia (
    id_materia INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL
);

-- 3. Persona
CREATE TABLE Persona (
    id_persona INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    cognome VARCHAR(50) NOT NULL,
    data_nascita DATE NOT NULL
);

-- 4. Articolazione
CREATE TABLE Articolazione (
    id_articolazione INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    id_indirizzo INT NOT NULL,
    FOREIGN KEY (id_indirizzo) REFERENCES Indirizzo(id_indirizzo) ON DELETE CASCADE
);

-- 5. Classe
CREATE TABLE Classe (
    id_classe INT PRIMARY KEY AUTO_INCREMENT,
    anno INT NOT NULL,
    sezione CHAR(1) NOT NULL,
    id_articolazione INT NOT NULL,
    FOREIGN KEY (id_articolazione) REFERENCES Articolazione(id_articolazione) ON DELETE CASCADE
);

-- 6. Docente
CREATE TABLE Docente (
    id_persona INT PRIMARY KEY,
    FOREIGN KEY (id_persona) REFERENCES Persona(id_persona) ON DELETE CASCADE
);

-- 7. Personale
CREATE TABLE Personale (
    id_persona INT PRIMARY KEY,
    FOREIGN KEY (id_persona) REFERENCES Persona(id_persona) ON DELETE CASCADE
);

-- 8. Genitore
CREATE TABLE Genitore (
    id_persona INT PRIMARY KEY,
    FOREIGN KEY (id_persona) REFERENCES Persona(id_persona) ON DELETE CASCADE
);

-- 9. Studente
CREATE TABLE Studente (
    id_persona INT PRIMARY KEY,
    id_classe INT,
    FOREIGN KEY (id_persona) REFERENCES Persona(id_persona) ON DELETE CASCADE,
    FOREIGN KEY (id_classe) REFERENCES Classe(id_classe) ON DELETE CASCADE
);

-- 10. Piano di Studio
CREATE TABLE Piano_di_Studio (
    id_piano INT PRIMARY KEY AUTO_INCREMENT,
    id_materia INT NOT NULL,
    FOREIGN KEY (id_materia) REFERENCES Materia(id_materia) ON DELETE CASCADE
);

-- 11. Classe_Docente_Materia
CREATE TABLE Classe_Docente_Materia (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_classe INT NOT NULL,
    id_docente INT NOT NULL,
    id_materia INT NOT NULL,
    FOREIGN KEY (id_classe) REFERENCES Classe(id_classe) ON DELETE CASCADE,
    FOREIGN KEY (id_docente) REFERENCES Docente(id_persona) ON DELETE CASCADE,
    FOREIGN KEY (id_materia) REFERENCES Materia(id_materia) ON DELETE CASCADE
);

-- 12. Genitore_Studente
CREATE TABLE Genitore_Studente (
    id_genitore INT NOT NULL,
    id_studente INT NOT NULL,
    PRIMARY KEY (id_genitore, id_studente),
    FOREIGN KEY (id_genitore) REFERENCES Genitore(id_persona) ON DELETE CASCADE,
    FOREIGN KEY (id_studente) REFERENCES Studente(id_persona) ON DELETE CASCADE
);

-- POPOLAMENTO DATI BASE

-- Indirizzi
INSERT INTO Indirizzo (nome) VALUES 
('Informatica'),
('Elettronica'),
('Meccanica');

-- Articolazioni
INSERT INTO Articolazione (nome, id_indirizzo) VALUES
('Sistemi e Reti', 1),
('Telecomunicazioni', 1),
('Automazione', 2),
('Robotica', 2),
('Macchine Utensili', 3);

-- Classi
INSERT INTO Classe (anno, sezione, id_articolazione) VALUES
(3, 'A', 1),
(4, 'A', 1),
(5, 'A', 1),
(3, 'B', 2),
(4, 'B', 2),
(5, 'B', 2),
(3, 'C', 3),
(4, 'C', 3),
(5, 'C', 3);

-- Materie
INSERT INTO Materia (nome) VALUES
('Matematica'),
('Informatica'),
('Sistemi e Reti'),
('Telecomunicazioni'),
('Elettronica'),
('Meccanica'),
('Robotica');

-- Piano di Studio
INSERT INTO Piano_di_Studio (id_materia) VALUES
(1), (2), (3), (4), (5), (6), (7);

-- INSERIMENTO 5 DOCENTI (solo Persona + Docente)

-- Persona
INSERT INTO Persona (nome, cognome, data_nascita) VALUES
('Mario', 'Rossi', '1980-05-15'),
('Lucia', 'Bianchi', '1978-03-10'),
('Paolo', 'Verdi', '1985-11-20'),
('Giovanna', 'Neri', '1982-07-08'),
('Alessandro', 'Russo', '1975-01-25');

-- Docente
INSERT INTO Docente (id_persona) VALUES
(1), (2), (3), (4), (5);

-- ASSOCIAZIONE DOCENTI CON MATERIE E CLASSI

INSERT INTO Classe_Docente_Materia (id_classe, id_docente, id_materia) VALUES
(1, 1, 2), -- Mario Rossi: Informatica (3A)
(2, 1, 2), -- Mario Rossi: Informatica (4A)
(3, 1, 3), -- Mario Rossi: Sistemi e Reti (5A)

(1, 2, 1), -- Lucia Bianchi: Matematica (3A)
(2, 2, 1), -- Lucia Bianchi: Matematica (4A)
(4, 2, 1), -- Lucia Bianchi: Matematica (3B)

(4, 3, 4), -- Paolo Verdi: Telecomunicazioni (3B)
(5, 3, 4), -- Paolo Verdi: Telecomunicazioni (4B)

(6, 4, 5), -- Giovanna Neri: Elettronica (5B)

(7, 5, 6), -- Alessandro Russo: Meccanica (3C)
(8, 5, 7); -- Alessandro Russo: Robotica (4C)
