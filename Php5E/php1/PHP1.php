<?php
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>REGG</title>
</head>
<body>
<!-- Primo modulo -->
<body>
<!-- Modulo iniziale -->
<form id="form1">
    <h1>Inserisci i tuoi dati</h1>
    <label for="name">Nome:</label>
    <input type="text" id="name" placeholder="Inserisci il tuo nome">
    <span class="error" id="error-name"></span>

    <label for="surname">Cognome:</label>
    <input type="text" id="surname" placeholder="Inserisci il tuo cognome">
    <span class="error" id="error-surname"></span>

    <label for="email">E-mail:</label>
    <input type="email" id="email" placeholder="Inserisci la tua email">
    <span class="error" id="error-email"></span>

    <label for="password">Password:</label>
    <input type="password" id="password" placeholder="Inserisci una password">
    <span class="error" id="error-password"></span>

    <button type="button" id="submit1">Procedi</button>
</form>

<!-- Modulo per le domande -->
<form id="form2" style="display: none;">
    <h1>Rispondi alle seguenti domande:</h1>
    <label>1. Quale dei seguenti è un software per la gestione di database?</label>
    <br>
    <br>
    <input type="radio" id="q1a" name="question1" value="MySQL">
    <label for="q1a">MySQL</label><br>
    <input type="radio" id="q1b" name="question1" value="Photoshop">
    <label for="q1b">Photoshop</label><br>
    <input type="radio" id="q1c" name="question1" value="Firefox">
    <label for="q1c">Firefox</label><br>
    <input type="radio" id="q1d" name="question1" value="Microsoft Word">
    <label for="q1d">Microsoft Word</label><br>
    <br>
    <label>2. Qual è l'acronimo di DBMS?</label>
    <br>
    <br>
    <input type="radio" id="q2a" name="question2" value="Database Management System">
    <label for="q2a">Database Management System</label><br>
    <input type="radio" id="q2b" name="question2" value="Data Binary Management System">
    <label for="q2b">Data Binary Management System</label><br>
    <input type="radio" id="q2c" name="question2" value="Digital Backup Management System">
    <label for="q2c">Digital Backup Management System</label><br>
    <input type="radio" id="q2d" name="question2" value="Database Binary Monitoring Software">
    <label for="q2d">Database Binary Monitoring Software</label><br>
    <br>
    <label for="domanda3">3. Scrivi un esempio di linguaggio di programmazione di alto livello:</label>
    <br>
    <input type="text" id="domanda3" placeholder=""><br>

    <button type="button" id="submit2">Invia Risposte</button>
</form>

<!-- Risultati -->
<div id="results" style="display: none;">
    <h1>Risultati</h1>
    <div id="results-questions"></div>
    <h2>Analisi Risposta Aperta</h2>
    <p id="text-analysis"></p>
</div>

<script src="script.js"></script>
</body>
</html>
