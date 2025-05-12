-- Creazione del database
CREATE DATABASE artifex_db;
USE artifex_db;

-- Tabella Lingua
CREATE TABLE Lingua (
                        id_lingua INT AUTO_INCREMENT PRIMARY KEY,
                        nome VARCHAR(50) NOT NULL UNIQUE
);

-- Tabella Visita
CREATE TABLE Visita (
                        id_visita INT AUTO_INCREMENT PRIMARY KEY,
                        titolo VARCHAR(100) NOT NULL,
                        descrizione TEXT,
                        durata_media VARCHAR(20) NOT NULL,
                        luogo VARCHAR(100) NOT NULL
);

select *
from artifex_db.visitatore;
-- Tabella Guida
CREATE TABLE Guida (
                       id_guida INT AUTO_INCREMENT PRIMARY KEY,
                       cognome VARCHAR(50) NOT NULL,
                       nome VARCHAR(50) NOT NULL,
                       data_nascita DATE NOT NULL,
                       luogo_nascita VARCHAR(100) NOT NULL,
                       titolo_studio VARCHAR(100) NOT NULL
);

-- Tabella Competenza (relazione N:M tra Guida e Lingua)
CREATE TABLE Competenza (
                            id_guida INT,
                            id_lingua INT,
                            livello_conoscenza ENUM('normale', 'avanzato', 'madre lingua') NOT NULL,
                            PRIMARY KEY (id_guida, id_lingua),
                            FOREIGN KEY (id_guida) REFERENCES Guida(id_guida) ON DELETE CASCADE,
                            FOREIGN KEY (id_lingua) REFERENCES Lingua(id_lingua) ON DELETE CASCADE
);

-- Tabella Visitatore
CREATE TABLE Visitatore (
                            id_visitatore INT AUTO_INCREMENT PRIMARY KEY,
                            nome VARCHAR(50) NOT NULL,
                            cognome VARCHAR(50) NOT NULL,
                            nazionalita VARCHAR(50) NOT NULL,
                            id_lingua_base INT,
                            email VARCHAR(100) NOT NULL UNIQUE,
                            telefono VARCHAR(20) NOT NULL,
                            username VARCHAR(50) NOT NULL UNIQUE,
                            password VARCHAR(255) NOT NULL,
                            data_registrazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                            FOREIGN KEY (id_lingua_base) REFERENCES Lingua(id_lingua)
);

-- Tabella Evento
CREATE TABLE Evento (
                        id_evento INT AUTO_INCREMENT PRIMARY KEY,
                        id_visita INT NOT NULL,
                        id_guida INT NOT NULL,
                        id_lingua INT NOT NULL,
                        prezzo DECIMAL(10,2) NOT NULL,
                        data DATE NOT NULL,
                        ora_inizio TIME NOT NULL,
                        min_partecipanti INT NOT NULL,
                        max_partecipanti INT NOT NULL,
                        FOREIGN KEY (id_visita) REFERENCES Visita(id_visita),
                        FOREIGN KEY (id_guida) REFERENCES Guida(id_guida),
                        FOREIGN KEY (id_lingua) REFERENCES Lingua(id_lingua),
                        CHECK (min_partecipanti > 0 AND max_partecipanti >= min_partecipanti)
);

-- Tabella Carrello
CREATE TABLE Carrello (
                          id_carrello INT AUTO_INCREMENT PRIMARY KEY,
                          id_visitatore INT NOT NULL,
                          data_creazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                          FOREIGN KEY (id_visitatore) REFERENCES Visitatore(id_visitatore) ON DELETE CASCADE
);

-- Tabella DettaglioCarrello
CREATE TABLE DettaglioCarrello (
                                   id_dettaglio INT AUTO_INCREMENT PRIMARY KEY,
                                   id_carrello INT NOT NULL,
                                   id_evento INT NOT NULL,
                                   quantita INT NOT NULL DEFAULT 1,
                                   FOREIGN KEY (id_carrello) REFERENCES Carrello(id_carrello) ON DELETE CASCADE,
                                   FOREIGN KEY (id_evento) REFERENCES Evento(id_evento),
                                   CHECK (quantita > 0)
);

-- Tabella Prenotazione
CREATE TABLE Prenotazione (
                              id_prenotazione INT AUTO_INCREMENT PRIMARY KEY,
                              id_visitatore INT NOT NULL,
                              data_prenotazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                              stato_pagamento ENUM('in attesa', 'pagato', 'annullato') DEFAULT 'in attesa',
                              totale DECIMAL(10,2) NOT NULL,
                              FOREIGN KEY (id_visitatore) REFERENCES Visitatore(id_visitatore)
);

-- Tabella DettaglioPrenotazione
CREATE TABLE DettaglioPrenotazione (
                                       id_dettaglio INT AUTO_INCREMENT PRIMARY KEY,
                                       id_prenotazione INT NOT NULL,
                                       id_evento INT NOT NULL,
                                       quantita INT NOT NULL DEFAULT 1,
                                       prezzo_unitario DECIMAL(10,2) NOT NULL,
                                       FOREIGN KEY (id_prenotazione) REFERENCES Prenotazione(id_prenotazione) ON DELETE CASCADE,
                                       FOREIGN KEY (id_evento) REFERENCES Evento(id_evento),
                                       CHECK (quantita > 0)
);

-- Tabella Amministratore
CREATE TABLE Amministratore (
                                id_admin INT AUTO_INCREMENT PRIMARY KEY,
                                username VARCHAR(50) NOT NULL UNIQUE,
                                password VARCHAR(255) NOT NULL,
                                email VARCHAR(100) NOT NULL UNIQUE,
                                nome VARCHAR(50) NOT NULL,
                                cognome VARCHAR(50) NOT NULL
);

-- Inserimento dati di esempio per Lingua
INSERT INTO Lingua (nome) VALUES
                              ('Italiano'),
                              ('Inglese'),
                              ('Francese'),
                              ('Spagnolo'),
                              ('Tedesco'),
                              ('Russo'),
                              ('Cinese'),
                              ('Giapponese');

-- Inserimento dati di esempio per Visita
INSERT INTO Visita (titolo, descrizione, durata_media, luogo) VALUES
                                                                  ('Musei Vaticani e Cappella Sistina', 'Un percorso affascinante attraverso una delle collezioni d\'arte più importanti al mondo, culminando con la visita alla magnifica Cappella Sistina.', '3 ore', 'Roma'),
('Sito archeologico di Pompei', 'Un viaggio indietro nel tempo per scoprire la vita quotidiana dell\'antica città romana, perfettamente conservata dalla tragica eruzione del Vesuvio.', '4 ore', 'Pompei'),
                                                                  ('Galleria degli Uffizi', 'Un percorso tra i capolavori del Rinascimento italiano in uno dei musei più celebri al mondo, con opere di Botticelli, Leonardo, Michelangelo e Raffaello.', '2.5 ore', 'Firenze'),
                                                                  ('Arena di Verona', 'Visita guidata all\'anfiteatro romano di Verona, secondo per dimensioni solo al Colosseo di Roma.', '1.5 ore', 'Verona'),
('Santa Maria del Fiore e Cupola del Brunelleschi', 'Visita completa al Duomo di Firenze e salita sulla celebre cupola del Brunelleschi.', '2 ore', 'Firenze');

-- Inserimento dati di esempio per Guida
INSERT INTO Guida (cognome, nome, data_nascita, luogo_nascita, titolo_studio) VALUES
('Rossi', 'Marco', '1985-05-10', 'Roma', 'Laurea in Storia dell\'Arte'),
                                                                  ('Bianchi', 'Laura', '1979-12-15', 'Firenze', 'Laurea in Archeologia'),
                                                                  ('Verdi', 'Giuseppe', '1988-03-22', 'Napoli', 'Laurea in Architettura'),
                                                                  ('Russo', 'Anna', '1990-09-30', 'Milano', 'Laurea in Storia dell\'Arte'),
('Ferrari', 'Paolo', '1982-07-18', 'Venezia', 'Laurea in Lingue');

-- Inserimento relazioni di competenza linguistica
INSERT INTO Competenza (id_guida, id_lingua, livello_conoscenza) VALUES
(1, 1, 'madre lingua'), -- Marco Rossi: italiano madrelingua
(1, 2, 'avanzato'),     -- Marco Rossi: inglese avanzato
(1, 3, 'normale'),      -- Marco Rossi: francese normale
(2, 1, 'madre lingua'), -- Laura Bianchi: italiano madrelingua
(2, 2, 'avanzato'),     -- Laura Bianchi: inglese avanzato
(2, 4, 'normale'),      -- Laura Bianchi: spagnolo normale
(3, 1, 'madre lingua'), -- Giuseppe Verdi: italiano madrelingua
(3, 5, 'avanzato'),     -- Giuseppe Verdi: tedesco avanzato
(4, 1, 'madre lingua'), -- Anna Russo: italiano madrelingua
(4, 2, 'madre lingua'), -- Anna Russo: inglese madrelingua
(4, 3, 'avanzato'),     -- Anna Russo: francese avanzato
(5, 1, 'madre lingua'), -- Paolo Ferrari: italiano madrelingua
(5, 2, 'avanzato'),     -- Paolo Ferrari: inglese avanzato
(5, 6, 'avanzato');     -- Paolo Ferrari: russo avanzato

-- Inserimento eventi di esempio
INSERT INTO Evento (id_visita, id_guida, id_lingua, prezzo, data, ora_inizio, min_partecipanti, max_partecipanti) VALUES
(1, 1, 2, 35.00, '2025-06-15', '09:30:00', 5, 20),   -- Musei Vaticani in inglese con Marco Rossi
(1, 4, 3, 35.00, '2025-06-15', '14:00:00', 5, 20),   -- Musei Vaticani in francese con Anna Russo
(2, 2, 2, 30.00, '2025-06-20', '10:00:00', 6, 25),   -- Pompei in inglese con Laura Bianchi
(2, 3, 1, 30.00, '2025-06-21', '10:00:00', 6, 25),   -- Pompei in italiano con Giuseppe Verdi
(3, 4, 2, 28.00, '2025-06-18', '11:00:00', 4, 18),   -- Uffizi in inglese con Anna Russo
(3, 5, 1, 28.00, '2025-06-19', '11:00:00', 4, 18),   -- Uffizi in italiano con Paolo Ferrari
(4, 3, 5, 20.00, '2025-06-25', '15:30:00', 6, 30),   -- Arena di Verona in tedesco con Giuseppe Verdi
(5, 5, 2, 25.00, '2025-06-22', '09:00:00', 5, 15);   -- Santa Maria del Fiore in inglese con Paolo Ferrari

-- Inserimento amministratore di sistema
INSERT INTO Amministratore (username, password, email, nome, cognome) VALUES
('admin', '$2y$10$VH51vYMjOiVM/6.n6Q5hce0fJXJ.3QWvCu60nMGS1GJQEHiJyRjDK', 'admin@artifex.it', 'Admin', 'Sistema'); -- password: admin123 (hashed)