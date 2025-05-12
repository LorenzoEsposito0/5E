<?php
session_start();

// Connessione al database
$host = 'localhost';
$dbname = 'artifex_db';
$username = 'root'; // Sostituisci con le tue credenziali
$password = '';     // Sostituisci con le tue credenziali

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connessione fallita: " . $e->getMessage());
}

// Variabili per i messaggi di errore
$login_error = '';
$username = '';

// Processa il form di login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Verifica se l'utente è un visitatore
    $stmt = $conn->prepare("SELECT id_visitatore, username, password, nome, cognome FROM Visitatore WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $user['password'])) {
            // Login riuscito per visitatore
            $_SESSION['user_id'] = $user['id_visitatore'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = 'visitatore';
            $_SESSION['user_name'] = $user['nome'] . ' ' . $user['cognome'];

            header("Location: index.php");
            exit();
        } else {
            $login_error = "Password non valida";
        }
    } else {
        // Verifica se l'utente è un amministratore
        $stmt = $conn->prepare("SELECT id_admin, username, password, nome, cognome FROM Amministratore WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($password, $admin['password'])) {
                // Login riuscito per amministratore
                $_SESSION['admin_id'] = $admin['id_admin'];
                $_SESSION['username'] = $admin['username'];
                $_SESSION['user_type'] = 'admin';
                $_SESSION['user_name'] = $admin['nome'] . ' ' . $admin['cognome'];

                header("Location: admin/dashboard.php");
                exit();
            } else {
                $login_error = "Password non valida";
            }
        } else {
            $login_error = "Username non trovato";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artifex - Accedi</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .login-button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .login-button:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<!-- Header -->
<header>
    <div class="logo">Artifex</div>
    <div class="slogan">Esplora l'arte e la storia con guide esperte</div>
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="user-welcome">
            <span>Ciao, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            <a href="carrello.php" class="cart-icon">
                🛒
                <?php
                // Opzionale: mostra il conteggio degli articoli nel carrello
                if (isset($_SESSION['cart_count'])) {
                    echo '<span class="cart-count">'.$_SESSION['cart_count'].'</span>';
                }
                ?>
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
    <div class="login-container">
        <h2>Accedi al tuo account</h2>

        <?php if (!empty($login_error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($login_error); ?></div>
        <?php endif; ?>

        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="login-button">Accedi</button>
        </form>

        <div class="register-link">
            Non hai un account? <a href="registrazione.php">Registrati</a>
        </div>
    </div>
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