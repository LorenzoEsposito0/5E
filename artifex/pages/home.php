<?php
function getColorByLocation($location) {
    $colors = [
        'Roma' => '#3498db',
        'Firenze' => '#e74c3c',
        'Venezia' => '#9b59b6',
        'Milano' => '#2ecc71',
        'Napoli' => '#f1c40f',
        'Torino' => '#1abc9c',
        'Verona' => '#e67e22'
    ];

    return $colors[$location] ?? '#2c3e50';
}

function getInitials($title) {
    $words = explode(' ', $title);
    $initials = '';

    foreach ($words as $word) {
        $initials .= strtoupper(substr($word, 0, 1));
    }

    return substr($initials, 0, 3);
}
$content = 'ArtiFex';
require_once '../strutture_pagina/functions_active_navbar.php';
require '../strutture_pagina/navbar.php';

// Configurazione del DB
$config = require '../connessione_db/db_config.php';
require '../connessione_db/DB_Connect.php';
require_once '../connessione_db/functions.php';

// Connessione al DB
$db = DataBase_Connect::getDB($config);

// Function to get featured tours
function getFeaturedTours($db) {
    $sql = "SELECT v.id, v.titolo, v.descrizione, v.durata_media, v.luogo 
            FROM visite v 
            LIMIT 7";

    $stmt = $db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get upcoming events
function getUpcomingEvents($db) {
    $today = date('Y-m-d');

    $sql = "SELECT e.id, e.data_evento, e.ora_inizio, e.lingua, e.prezzo, 
                  e.min_partecipanti, e.max_partecipanti, v.titolo, v.luogo, 
                  g.nome, g.cognome,
                  (SELECT COUNT(*) FROM elementi_carrello ec 
                   JOIN carrelli c ON ec.id_carrello = c.id 
                   WHERE ec.id_evento = e.id AND c.stato = 'pagato') as posti_occupati
            FROM eventi e
            JOIN visite v ON e.id_visita = v.id
            JOIN guide g ON e.id_guida = g.id
            WHERE e.data_evento >= :today
            ORDER BY e.data_evento ASC
            LIMIT 3";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':today', $today);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get featured guides
function getFeaturedGuides($db) {
    $sql = "SELECT g.id, g.nome, g.cognome, g.titolo_studio, g.luogo_nascita
            FROM guide g
            LIMIT 4";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $guides = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get language skills for each guide
    foreach ($guides as &$guide) {
        $sql_languages = "SELECT lingua, livello 
                         FROM competenze_linguistiche 
                         WHERE id_guida = :id_guida";

        $stmt_languages = $db->prepare($sql_languages);
        $stmt_languages->bindParam(':id_guida', $guide['id']);
        $stmt_languages->execute();

        $guide['lingue'] = $stmt_languages->fetchAll(PDO::FETCH_ASSOC);
    }

    return $guides;
}

// Get data from the database
$featuredTours = getFeaturedTours($db);
$upcomingEvents = getUpcomingEvents($db);
$featuredGuides = getFeaturedGuides($db);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../style/style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Home</title>
</head>
<body>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content fadeIn">
        <h1>Scopri l'arte con Artifex</h1>
        <p>Visite guidate ai più affascinanti siti di interesse storico-culturale in Italia e nel mondo</p>
        <div class="hero-cta">
            <a href="eventi.php" class="btn btn-primary">Esplora le Visite</a>
        </div>
    </div>
</section>

<!-- Featured Tours Section -->
<!-- Featured Tours Section - Modified Layout -->
<section class="section">
    <div class="section-header">
        <h2 class="section-title">Esperienze da non perdere</h2>
        <p class="section-subtitle">Itinerari curati per scoprire il meglio di ogni destinazione</p>
    </div>

    <div class="tours-container">
        <?php foreach ($featuredTours as $tour): ?>
            <div class="tour-card-horizontal">
                <div class="tour-image">
                    <!-- Immagine di sfondo dinamica basata sul luogo -->
                    <div class="image-placeholder" style="background-color: <?php echo getColorByLocation($tour['luogo']); ?>;">
                        <span><?php echo getInitials($tour['titolo']); ?></span>
                    </div>
                </div>
                <div class="tour-details">
                    <div class="tour-header">
                        <span class="tour-location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($tour['luogo']); ?></span>
                        <h3 class="tour-title"><?php echo htmlspecialchars($tour['titolo']); ?></h3>
                    </div>

                    <div class="tour-meta">
                        <div class="meta-item">
                            <i class="far fa-clock"></i>
                            <span><?php echo $tour['durata_media']/60; ?> ore</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-users"></i>
                            <span>Fino a 20 persone</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-star"></i>
                            <span>4.8/5 (120 recensioni)</span>
                        </div>
                    </div>

                    <p class="tour-excerpt"><?php echo htmlspecialchars(substr($tour['descrizione'], 0, 120)) . '...'; ?></p>

                    <div class="tour-footer">
                        <?php
                        $stmt = $db->prepare("SELECT AVG(prezzo) as prezzo_medio FROM eventi WHERE id_visita = :id");
                        $stmt->bindParam(':id', $tour['id']);
                        $stmt->execute();
                        $avgPrice = $stmt->fetch(PDO::FETCH_ASSOC);
                        $price = $avgPrice['prezzo_medio'] ? number_format($avgPrice['prezzo_medio'], 2) : "N/A";
                        ?>
                        <div class="tour-price">
                            <span class="price">€<?php echo $price; ?></span>
                            <span class="per-person">a persona</span>
                        </div>
                        <a href="eventi.php?id=<?php echo $tour['id']; ?>" class="btn btn-book">
                            Prenota ora <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="text-center mt-3">
        <a href="servizi.php" class="btn btn-view-all">
            Scopri tutti i tour <i class="fas fa-chevron-down"></i>
        </a>
    </div>
</section>

<!-- How It Works Section -->
<

<!-- Guide Section -->
<section class="section">
    <div class="section-header">
        <h2 class="section-title">Le Nostre Guide</h2>
        <p class="section-subtitle">Professionisti esperti e multilingue per accompagnarti alla scoperta del patrimonio culturale</p>
    </div>

    <div class="tours-grid">
        <?php foreach ($featuredGuides as $index => $guide): ?>
            <div class="tour-card">
                <div class="tour-content">
                    <h3 class="tour-title"><?php echo htmlspecialchars($guide['nome'] . ' ' . $guide['cognome']); ?></h3>
                    <div class="event-details">
                        <div class="event-detail">
                            <i class="fa-solid fa-graduation-cap detail-icon"></i>
                            <span><?php echo htmlspecialchars($guide['titolo_studio']); ?></span>
                        </div>
                        <div class="event-detail">
                            <i class="fa-solid fa-language detail-icon"></i>
                            <span>
                            <?php
                            $languages = [];
                            foreach ($guide['lingue'] as $lang) {
                                $languages[] = $lang['lingua'] . ' (' . $lang['livello'] . ')';
                            }
                            echo htmlspecialchars(implode(', ', $languages));
                            ?>
                        </span>
                        </div>
                        <div class="event-detail">
                            <i class="fa-solid fa-location-dot detail-icon"></i>
                            <span><?php echo htmlspecialchars($guide['luogo_nascita']); ?></span>
                        </div>
                    </div>
                    <?php
                    // Get random description for guide
                    $descriptions = [
                        "Specializzato in arte rinascimentale e barocca, vi accompagnerà alla scoperta dei più importanti siti culturali.",
                        "Con oltre 10 anni di esperienza nel settore, è la guida ideale per scoprire i segreti dell'arte e della storia.",
                        "Esperto di arte e archeologia, rende ogni visita un'esperienza indimenticabile ricca di aneddoti e curiosità."
                    ];
                    $randomDesc = $descriptions[array_rand($descriptions)];
                    ?>
                    <p class="tour-description"><?php echo $randomDesc; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>




<?php
require '../strutture_pagina/footer.php';
?>


</body>
</html>