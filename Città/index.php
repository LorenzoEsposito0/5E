<?php
session_start();
$citta = [
    "Nord" => [
        "Milano", "Torino", "Genova", "Bologna", "Venezia", "Verona", "Padova", "Trieste", "Brescia", "Parma", "Livorno", "Ravenna", "Ferrara", "Rimini"
    ],
    "Centro" => ["Firenze", "Bari", "Perugia", "Prato", "Modena", "Reggio Calabria", "Cagliari"
    ],
    "Sud" => ["Roma", "Napoli", "Palermo", "Catania", "Messina", "Taranto", "Sassari", "Lecce"
    ]
];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="post" action="actionname.php">
        <h1 id="timer">HAI 60 SECONDI PER COMPILARE IL FORM</h1>
        <script>
            let time = 60;
            const TimerNumber = document.getElementById("timer");

            const countdown = setInterval(function (){
                time--;
                TimerNumber.textContent = time;

                if(time <= 0)
                {
                    alert("FINITO IL TEMPO");
                }
            },1000);
        </script>

        <?php
        ?>
        <label>NORD</label><br><br>
        <?php
        foreach($citta['Nord'] as $nomeCitta) { ?>
        <label>Inserisci voto <?= $nomeCitta ?>:</label><br>
        <input type="number" name="<?= $nomeCitta ?>"  min="1" max="5"/><br>
        <?php
        }

        ?>
        <label>CENTRO</label><br><br>
        <?php
        foreach($citta['Centro'] as $nomeCitta) { ?>
        <label>Inserisci voto <?= $nomeCitta ?>:</label><br>
        <input type="number" name="<?= $nomeCitta ?>"  min="1" max="5"/><br>
        <?php
        }

        ?>
        <label>SUD</label><br><br>
        <?php
        foreach($citta['Sud'] as $nomeCitta) { ?>
        <label>Inserisci voto <?= $nomeCitta ?>:</label><br>
        <input type="number" name="<?= $nomeCitta ?>" min="1" max="5"/><br>
        <?php
         }
        ?>

        <button type="submit">Invia</button>
    </form>
</body>
</html>
