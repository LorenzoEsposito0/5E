<?php
session_start();
require_once '../DBconnection.php';

$config = require_once '../DBconfig.php';
$db = registro_elettronico\Db_connection::getDB($config);

$alertMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST['tipo'];
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($tipo === 'docente') {
        // Gestione DOCENTE (mantengo esattamente come volevi)
        if ($password !== "insegnante123") {
            $alertMessage = "Password errata!";
        } else {
            $query = "SELECT id_persona FROM Persona WHERE CONCAT(LOWER(nome), '.', LOWER(cognome)) = :username";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':username', strtolower($username));
            $stmt->execute();
            $persona = $stmt->fetch();

            if ($persona) {
                $_SESSION['username'] = $username;
                $_SESSION['id_persona'] = $persona['id_persona'];
                $_SESSION['status'] = 'insegnante';
                header("Location: classi_insegnante.php");
                exit();
            } else {
                $alertMessage = "Username non trovato!";
            }
        }
    } else {
        // Gestione Studente, Genitore, Personale
        $passwordCorretta = match ($tipo) {
            "studente" => "studente123",
            "genitore" => "genitore123",
            "personale" => "admin123",
            default => null
        };

        if ($password !== $passwordCorretta) {
            $alertMessage = "Password errata per il tipo selezionato!";
        } else {
            try {
                $checkQuery = "SELECT username FROM Credenziali WHERE username = :username";
                $checkStmt = $db->prepare($checkQuery);
                $checkStmt->bindValue(':username', $username);
                $checkStmt->execute();

                if ($checkStmt->fetch()) {
                    $alertMessage = "Username già registrato!";
                } else {
                    $db->beginTransaction();

                    // Inserisci Persona
                    $insertPersona = "INSERT INTO Persona (nome, cognome, data_nascita) VALUES (:nome, 'Registrato', CURDATE())";
                    $stmtPersona = $db->prepare($insertPersona);
                    $stmtPersona->bindValue(':nome', ucfirst($tipo));
                    $stmtPersona->execute();
                    $idPersona = $db->lastInsertId();

                    // Inserisci Studente/Genitore/Personale
                    switch ($tipo) {
                        case "studente":
                            $query = "INSERT INTO Studente (id_persona) VALUES (:id_persona)";
                            break;
                        case "genitore":
                            $query = "INSERT INTO Genitore (id_persona) VALUES (:id_persona)";
                            break;
                        case "personale":
                            $query = "INSERT INTO Personale (id_persona) VALUES (:id_persona)";
                            break;
                    }
                    $stmtTipo = $db->prepare($query);
                    $stmtTipo->bindValue(':id_persona', $idPersona, PDO::PARAM_INT);
                    $stmtTipo->execute();

                    // Inserisci Credenziali
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $insertCredenziali = "INSERT INTO Credenziali (username, psw) VALUES (:username, :psw)";
                    $stmtCredenziali = $db->prepare($insertCredenziali);
                    $stmtCredenziali->bindValue(':username', $username);
                    $stmtCredenziali->bindValue(':psw', $hashedPassword);
                    $stmtCredenziali->execute();

                    $db->commit();

                    $_SESSION['username'] = $username;
                    $_SESSION['status'] = $tipo;
                    header("Location: ../action/action_page.php");
                    exit();
                }
            } catch (Exception $e) {
                $db->rollBack();
                $alertMessage = "Errore durante la registrazione: " . $e->getMessage();
            }
        }
    }
}
?>

<?php if (!empty($alertMessage)): ?>
    <script>alert("<?= htmlspecialchars($alertMessage) ?>");</script>
<?php endif; ?>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card p-4 shadow" style="width: 400px;">
        <h2 class="mb-4 text-center">Registrazione</h2>
        <form method="post" action="registrati.php">
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo utente</label>
                <select name="tipo" id="tipo" class="form-select" required>
                    <option value="">Seleziona...</option>
                    <option value="studente">Studente</option>
                    <option value="genitore">Genitore</option>
                    <option value="personale">Personale</option>
                    <option value="docente">Docente</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Registrati</button>
        </form>
    </div>
</div>

<?php
require '../footer/footer.php';
?>
