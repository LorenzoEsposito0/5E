<?php
// Configurazione del DB
$config = require '../connessione_db/db_config.php';
require '../connessione_db/DB_Connect.php';
require_once '../connessione_db/functions.php';

// Connessione al DB
$db = DataBase_Connect::getDB($config);

// Ottieni tutte le visite disponibili
$query = "SELECT v.id, v.titolo, v.descrizione, v.durata_media, v.luogo, 
          COUNT(DISTINCT e.id) AS num_eventi, MIN(e.prezzo) AS prezzo_min 
          FROM visite v 
          LEFT JOIN eventi e ON v.id = e.id_visita 
          WHERE e.data_evento >= CURDATE() 
          GROUP BY v.id 
          ORDER BY v.titolo";

$stmt = $db->prepare($query);
$stmt->execute();
$visite = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Funzioni helper per il nuovo layout
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
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artifex - Servizi Turistici</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../style/style1.css">
</head>
<body>
<?php include '../strutture_pagina/navbar.php'; ?>

<!-- Featured Tours Section - Modified Layout -->
<section class="section">
    <div class="section-header">
        <h2 class="section-title">Esperienze da non perdere</h2>
        <p class="section-subtitle">Itinerari curati per scoprire il meglio di ogni destinazione</p>
    </div>

    <div class="tours-container">
        <?php foreach ($visite as $visita): ?>
            <div class="tour-card-horizontal">
                <div class="tour-image">
                    <!-- Immagine di sfondo dinamica basata sul luogo -->
                    <div class="image-placeholder" style="background-color: <?php echo getColorByLocation($visita['luogo']); ?>;">
                        <span><?php echo getInitials($visita['titolo']); ?></span>
                    </div>
                </div>
                <div class="tour-details">
                    <div class="tour-header">
                        <span class="tour-location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($visita['luogo']); ?></span>
                        <h3 class="tour-title"><?php echo htmlspecialchars($visita['titolo']); ?></h3>
                    </div>

                    <div class="tour-meta">
                        <div class="meta-item">
                            <i class="far fa-clock"></i>
                            <span><?php echo round($visita['durata_media']/60, 1); ?> ore</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-users"></i>
                            <span>Fino a 20 persone</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-calendar"></i>
                            <span><?php echo $visita['num_eventi']; ?> date disponibili</span>
                        </div>
                    </div>

                    <p class="tour-excerpt"><?php echo htmlspecialchars(substr($visita['descrizione'], 0, 120)) . '...'; ?></p>

                    <div class="tour-footer">
                        <div class="tour-price">
                            <?php if ($visita['num_eventi'] > 0): ?>
                                <span class="price">€<?php echo number_format($visita['prezzo_min'], 2); ?></span>
                                <span class="per-person">a persona</span>
                            <?php else: ?>
                                <span class="price">Nessun evento</span>
                            <?php endif; ?>
                        </div>
                        <a href="eventi.php?id=<?php echo $visita['id']; ?>" class="btn btn-book">
                            <?php echo ($visita['num_eventi'] > 0) ? 'Prenota ora' : 'Scopri di più'; ?>
                            <i class="fas fa-arrow-right"></i>
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

<!-- Newsletter Section -->
<section class="newsletter">
    <div class="newsletter-container">
        <h2>Resta Aggiornato</h2>
        <p>Iscriviti alla nostra newsletter per ricevere aggiornamenti sui nuovi tour ed offerte speciali.</p>
        <form class="newsletter-form">
            <input type="email" placeholder="La tua email" class="newsletter-input" required>
            <button type="submit" class="newsletter-btn">Iscriviti</button>
        </form>
    </div>
</section>

<?php include '../strutture_pagina/footer.php'; ?>
</body>
</html>