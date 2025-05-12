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

// Variabili per i messaggi di errore e successo
$errors = [];
$success_message = '';

// Dati del form
$form_data = [
    'nome' => '',
    'cognome' => '',
    'nazionalita' => '',
    'email' => '',
    'telefono' => '',
    'username' => '',
    'lingua_base' => ''
];

// Elenco delle lingue disponibili
$lingue = [];
$stmt = $conn->query("SELECT id_lingua, nome FROM Lingua ORDER BY nome");
$lingue = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Processa il form di registrazione
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recupera e sanitizza i dati del form
    $form_data['nome'] = trim($_POST['nome']);
    $form_data['cognome'] = trim($_POST['cognome']);
    $form_data['nazionalita'] = trim($_POST['nazionalita']);
    $form_data['email'] = trim($_POST['email']);
    $form_data['telefono'] = trim($_POST['telefono']);
    $form_data['username'] = trim($_POST['username']);
    $form_data['lingua_base'] = $_POST['lingua_base'];
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validazione
    if (empty($form_data['nome'])) {
        $errors['nome'] = "Il nome è obbligatorio";
    }

    if (empty($form_data['cognome'])) {
        $errors['cognome'] = "Il cognome è obbligatorio";
    }

    if (empty($form_data['nazionalita'])) {
        $errors['nazionalita'] = "La nazionalità è obbligatoria";
    }

    if (empty($form_data['email'])) {
        $errors['email'] = "L'email è obbligatoria";
    } elseif (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Formato email non valido";
    } else {
        // Verifica se l'email esiste già
        $stmt = $conn->prepare("SELECT id_visitatore FROM Visitatore WHERE email = :email");
        $stmt->bindParam(':email', $form_data['email']);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $errors['email'] = "Questa email è già registrata";
        }
    }

    if (empty($form_data['telefono'])) {
        $errors['telefono'] = "Il telefono è obbligatorio";
    }

    if (empty($form_data['username'])) {
        $errors['username'] = "Lo username è obbligatorio";
    } elseif (strlen($form_data['username']) < 4) {
        $errors['username'] = "Lo username deve avere almeno 4 caratteri";
    } else {
        // Verifica se lo username esiste già
        $stmt = $conn->prepare("SELECT id_visitatore FROM Visitatore WHERE username = :username");
        $stmt->bindParam(':username', $form_data['username']);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $errors['username'] = "Questo username è già in uso";
        }
    }

    if (empty($form_data['lingua_base']) || !is_numeric($form_data['lingua_base'])) {
        $errors['lingua_base'] = "Seleziona una lingua";
    }

    if (empty($password)) {
        $errors['password'] = "La password è obbligatoria";
    } elseif (strlen($password) < 8) {
        $errors['password'] = "La password deve avere almeno 8 caratteri";
    }

    if ($password !== $confirm_password) {
        $errors['confirm_password'] = "Le password non coincidono";
    }

    // Se non ci sono errori, procedi con la registrazione
    if (empty($errors)) {
        // Hash della password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Inserimento nel database
        try {
            $stmt = $conn->prepare("INSERT INTO Visitatore (nome, cognome, nazionalita, id_lingua_base, email, telefono, username, password) 
                                   VALUES (:nome, :cognome, :nazionalita, :id_lingua_base, :email, :telefono, :username, :password)");

            $stmt->bindParam(':nome', $form_data['nome']);
            $stmt->bindParam(':cognome', $form_data['cognome']);
            $stmt->bindParam(':nazionalita', $form_data['nazionalita']);
            $stmt->bindParam(':id_lingua_base', $form_data['lingua_base']);
            $stmt->bindParam(':email', $form_data['email']);
            $stmt->bindParam(':telefono', $form_data['telefono']);
            $stmt->bindParam(':username', $form_data['username']);
            $stmt->bindParam(':password', $password_hash);

            $stmt->execute();

            // Registrazione completata con successo
            $success_message = "Registrazione completata con successo! Ora puoi effettuare il login.";

            // Resetta i dati del form
            $form_data = [
                'nome' => '',
                'cognome' => '',
                'nazionalita' => '',
                'email' => '',
                'telefono' => '',
                'username' => '',
                'lingua_base' => ''
            ];

        } catch(PDOException $e) {
            $errors['database'] = "Errore durante la registrazione: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artifex - Registrazione</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .registration-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .registration-container h2 {
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

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }

        .success-message {
            color: green;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .register-button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        .register-button:hover {
            background-color: #45a049;
        }

        .login-link {
            text-align: center;
            margin-top: 15px;
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .form-group {
            flex: 1;
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
    <div class="registration-container">
        <h2>Crea un account</h2>

        <?php if (!empty($success_message)): ?>
            <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>

        <?php if (isset($errors['database'])): ?>
            <div class="error-message"><?php echo htmlspecialchars($errors['database']); ?></div>
        <?php endif; ?>

        <form action="registrazione.php" method="post">
            <div class="form-row">
                <div class="form-group">
                    <label for="nome">Nome*</label>
                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($form_data['nome']); ?>" required>
                    <?php if (isset($errors['nome'])): ?>
                        <div class="error-message"><?php echo htmlspecialchars($errors['nome']); ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="cognome">Cognome*</label>
                    <input type="text" id="cognome" name="cognome" value="<?php echo htmlspecialchars($form_data['cognome']); ?>" required>
                    <?php if (isset($errors['cognome'])): ?>
                        <div class="error-message"><?php echo htmlspecialchars($errors['cognome']); ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="nazionalita">Nazionalità*</label>
                    <input type="text" id="nazionalita" name="nazionalita" value="<?php echo htmlspecialchars($form_data['nazionalita']); ?>" required>
                    <?php if (isset($errors['nazionalita'])): ?>
                        <div class="error-message"><?php echo htmlspecialchars($errors['nazionalita']); ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="lingua_base">Lingua preferita*</label>
                    <select id="lingua_base" name="lingua_base" required>
                        <option value="">Seleziona una lingua</option>
                        <?php foreach ($lingue as $lingua): ?>
                            <option value="<?php echo $lingua['id_lingua']; ?>" <?php echo ($form_data['lingua_base'] == $lingua['id_lingua']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($lingua['nome']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['lingua_base'])): ?>
                        <div class="error-message"><?php echo htmlspecialchars($errors['lingua_base']); ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email*</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($form_data['email']); ?>" required>
                <?php if (isset($errors['email'])): ?>
                    <div class="error-message"><?php echo htmlspecialchars($errors['email']); ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="telefono">Telefono*</label>
                <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($form_data['telefono']); ?>" required>
                <?php if (isset($errors['telefono'])): ?>
                    <div class="error-message"><?php echo htmlspecialchars($errors['telefono']); ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="username">Username*</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($form_data['username']); ?>" required>
                <?php if (isset($errors['username'])): ?>
                    <div class="error-message"><?php echo htmlspecialchars($errors['username']); ?></div>
                <?php endif; ?>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password*</label>
                    <input type="password" id="password" name="password" required>
                    <?php if (isset($errors['password'])): ?>
                        <div class="error-message"><?php echo htmlspecialchars($errors['password']); ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Conferma Password*</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                    <?php if (isset($errors['confirm_password'])): ?>
                        <div class="error-message"><?php echo htmlspecialchars($errors['confirm_password']); ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <button type="submit" class="register-button">Registrati</button>
        </form>

        <div class="login-link">
            Hai già un account? <a href="login.php">Accedi</a>
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