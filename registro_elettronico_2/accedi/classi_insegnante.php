<?php
session_start();
require_once '../DBconnection.php';
require '../header/header.php';
$config = require_once '../DBconfig.php';
$db = registro_elettronico\Db_connection::getDB($config);

// Controllo sessione
if (!isset($_SESSION['username']) || $_SESSION['status'] !== 'insegnante') {
    header('Location: login_insegnante.php');
    exit();
}

// Recupero dati dalla sessione
$id_persona = $_SESSION['id_persona'];

// Recupera classi e materie dell'insegnante
$query = "
    SELECT 
        Classe.anno,
        Classe.sezione,
        Articolazione.nome AS articolazione,
        Materia.nome AS materia
    FROM Classe_Docente_Materia
    INNER JOIN Classe ON Classe_Docente_Materia.id_classe = Classe.id_classe
    INNER JOIN Articolazione ON Classe.id_articolazione = Articolazione.id_articolazione
    INNER JOIN Materia ON Classe_Docente_Materia.id_materia = Materia.id_materia
    WHERE Classe_Docente_Materia.id_docente = :id_docente
    ORDER BY Classe.anno, Classe.sezione, Materia.nome
";
$stmt = $db->prepare($query);
$stmt->bindValue(':id_docente', $id_persona);
$stmt->execute();
$classiMaterie = $stmt->fetchAll();
?>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h2 class="text-center mb-4">Le tue Classi, Articolazioni e Materie</h2>

    <?php if (count($classiMaterie) > 0): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
            <tr>
                <th>Anno</th>
                <th>Sezione</th>
                <th>Articolazione</th>
                <th>Materia</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($classiMaterie as $riga): ?>
                <tr>
                    <td><?= htmlspecialchars($riga['anno']) ?></td>
                    <td><?= htmlspecialchars($riga['sezione']) ?></td>
                    <td><?= htmlspecialchars($riga['articolazione']) ?></td>
                    <td><?= htmlspecialchars($riga['materia']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info text-center" role="alert">
            Non hai ancora classi o materie assegnate.<br>
            Contatta l'amministratore.
        </div>
    <?php endif; ?>
</div>

<div class="text-center mb-5">
    <a href="../logout.php" class="btn btn-danger">Logout</a>
</div>

<?php
require '../footer/footer.php';
?>
