<?php
session_start();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artifex - Visite Guidate</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
// Dati delle visite con immagini reali
$featured_tours = [
    [
        'id' => 1,
        'title' => 'Musei Vaticani e Cappella Sistina',
        'location' => 'Roma',
        'duration' => '3 ore',
        'description' => 'Un percorso affascinante attraverso una delle collezioni d\'arte più importanti al mondo, culminando con la visita alla magnifica Cappella Sistina.',
        'image' => 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&h=400&q=80'
    ],
    [
        'id' => 2,
        'title' => 'Sito archeologico di Pompei',
        'location' => 'Pompei',
        'duration' => '4 ore',
        'description' => 'Un viaggio indietro nel tempo per scoprire la vita quotidiana dell\'antica città romana, perfettamente conservata dalla tragica eruzione del Vesuvio.',
        'image' => 'https://images.unsplash.com/photo-1531572753322-ad063cecc140?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&h=400&q=80'
    ],
    [
        'id' => 3,
        'title' => 'Galleria degli Uffizi',
        'location' => 'Firenze',
        'duration' => '2.5 ore',
        'description' => 'Un percorso tra i capolavori del Rinascimento italiano in uno dei musei più celebri al mondo, con opere di Botticelli, Leonardo, Michelangelo e Raffaello.',
        'image' => 'https://images.unsplash.com/photo-1575517111478-7f6afd0973db?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&h=400&q=80'
    ],
    [
        'id' => 4,
        'title' => 'Colosseo e Foro Romano',
        'location' => 'Roma',
        'duration' => '3 ore',
        'description' => 'Visita al più famoso anfiteatro romano e all\'area archeologica del Foro Romano, cuore della vita politica e sociale dell\'antica Roma.',
        'image' => 'https://images.unsplash.com/photo-1529260830199-42c24126f198?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&h=400&q=80'
    ],
    [
        'id' => 5,
        'title' => 'Duomo di Milano e Galleria Vittorio Emanuele',
        'location' => 'Milano',
        'duration' => '2.5 ore',
        'description' => 'Tour della cattedrale gotica più grande d\'Italia e della splendida galleria commerciale del XIX secolo, simboli del capoluogo lombardo.',
        'image' => 'https://images.unsplash.com/photo-1528720208104-3d9bd03cc9d4?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&h=400&q=80'
    ],
    [
        'id' => 6,
        'title' => 'Reggia di Caserta e Giardini',
        'location' => 'Caserta',
        'duration' => '4 ore',
        'description' => 'Visita alla maestosa reggia borbonica, patrimonio UNESCO, con i suoi splendidi appartamenti reali e l\'immenso parco con fontane monumentali.',
        'image' => 'https://images.unsplash.com/photo-1603665270146-bbdfd8a2a7b5?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&h=400&q=80'
    ],
];
?>

<!-- Header -->
<header>
    <div class="logo">Artifex</div>
    <div class="slogan">Esplora l'arte e la storia con guide esperte</div>
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="user-welcome">
            <span>Ciao, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            <a href="carrello.php" class="cart-icon">
                🛒
                <?php if (isset($_SESSION['cart_count'])): ?>
                    <span class="cart-count"><?php echo $_SESSION['cart_count']; ?></span>
                <?php endif; ?>
            </a>
        </div>
    <?php endif; ?>
</header>

<!-- Navbar -->
<nav>
    <div class="navbar">
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="visite.php">Visite</a></li>
            <li><a href="guide.php">Guide</a></li>
            <li><a href="chi-siamo.php">Chi Siamo</a></li>
            <li><a href="contatti.php">Contatti</a></li>
        </ul>
        <div class="auth-buttons">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="profilo.php" class="profile">Profilo</a>
                <a href="logout.php" class="logout">Esci</a>
            <?php else: ?>
                <a href="login.php" class="login">Accedi</a>
                <a href="registrazione.php" class="register">Registrati</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="main-content">
    <section class="hero">
        <h1>Scopri il patrimonio culturale con guide professionali</h1>
        <p>Artifex ti offre esperienze culturali indimenticabili con guide specializzate in diverse lingue. Esplora i tesori artistici e storici d'Italia con i nostri tour guidati.</p>
        <a href="visite.php" class="cta-button">Scopri le nostre visite</a>
    </section>

    <section>
        <h2 class="section-title">Visite in evidenza</h2>
        <div class="featured-tours">
            <?php foreach ($featured_tours as $tour): ?>
                <div class="tour-card">
                    <div class="tour-image" style="background-image: url('<?php echo $tour['image']; ?>')"></div>
                    <div class="tour-content">
                        <h3 class="tour-title"><?php echo $tour['title']; ?></h3>
                        <div class="tour-info">
                            <span><?php echo $tour['location']; ?></span>
                            <span>Durata: <?php echo $tour['duration']; ?></span>
                        </div>
                        <p class="tour-description"><?php echo $tour['description']; ?></p>
                        <a href="dettaglio-visita.php?id=<?php echo $tour['id']; ?>" class="tour-button">Scopri di più</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="why-us">
        <h2 class="section-title">Perché scegliere Artifex</h2>
        <div class="features">
            <div class="feature">
                <div class="feature-icon">🌟</div>
                <h3 class="feature-title">Guide esperte</h3>
                <p>Guide professioniste multilingue con profonda conoscenza storica e artistica.</p>
            </div>
            <div class="feature">
                <div class="feature-icon">🔍</div>
                <h3 class="feature-title">Piccoli gruppi</h3>
                <p>Visite in piccoli gruppi per un'esperienza più personale e coinvolgente.</p>
            </div>
            <div class="feature">
                <div class="feature-icon">🎫</div>
                <h3 class="feature-title">Biglietti salta fila</h3>
                <p>Evita le lunghe attese con i nostri biglietti prioritari inclusi nel prezzo.</p>
            </div>
            <div class="feature">
                <div class="feature-icon">💬</div>
                <h3 class="feature-title">Multilingua</h3>
                <p>Visite disponibili in diverse lingue per accogliere visitatori da tutto il mondo.</p>
            </div>
        </div>
    </section>
</div>

<!-- Footer -->
<footer>
    <div class="footer-content">
        <div class="footer-column">
            <h3>Artifex</h3>
            <p>Società leader nell'organizzazione di visite guidate a siti di interesse storico-culturale in Italia.</p>
            <div class="social-links">
                <a href="#" class="social-icon">f</a>
                <a href="#" class="social-icon">in</a>
                <a href="#" class="social-icon">ig</a>
            </div>
        </div>
        <div class="footer-column">
            <h3>Link utili</h3>
            <ul class="footer-links">
                <li><a href="chi-siamo.php">Chi siamo</a></li>
                <li><a href="visite.php">Le nostre visite</a></li>
                <li><a href="guide.php">Guide</a></li>
                <li><a href="faq.php">FAQ</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>Servizi</h3>
            <ul class="footer-links">
                <li><a href="prenotazioni.php">Prenotazioni</a></li>
                <li><a href="gruppi.php">Visite per gruppi</a></li>
                <li><a href="aziende.php">Per aziende</a></li>
                <li><a href="scuole.php">Per scuole</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>Contatti</h3>
            <ul class="footer-links">
                <li>Email: info@artifex.it</li>
                <li>Telefono: +39 06 1234567</li>
                <li>Indirizzo: Via Roma 123, Roma</li>
            </ul>
        </div>
    </div>
    <div class="copyright">
        &copy; <?php echo date('Y'); ?> Artifex S.r.l. - P.IVA 12345678901 - Tutti i diritti riservati
    </div>
</footer>
</body>
</html>