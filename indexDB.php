<?php
$db = new PDO('mysql:host=localhost;dbname=itis','root', '',[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ]);
//var_dump($db);
//echo $db->getAttribute(PDO::ATTR_DRIVER_NAME);


//READ 1
$query = 'SELECT * FROM studenti';
try{
    $stm = $db->prepare($query);
    $stm->execute();
    while($studente = $stm->fetch()){
        echo 'Matricola: '.$studente->matricola_studente. '<br>';
        echo 'Nome: '.$studente->nome.'<br>';
        echo 'Cognome: '.$studente->cognome.'<br>';
        echo 'Media:' .$studente->media.'<br>';
        echo 'Data iscrizione'.$studente->data_iscrizione.'<br>';
        echo '<hr>';
    }
}catch (Exception $e){
   LogError($e);
}

//READ 2 con bind value
/*$query = 'SELECT media,cognome FROM studenti where nome=:name';
try{
    // stm sta per statement
    $stm = $db->prepare($query);
    $stm->bindValue(':name', 'Antonella');
    $stm->execute();
    while($studente = $stm->fetch()){
        // echo 'Matricola: '.$studente->matricola_studente. '<br>';
        // echo 'Nome: '.$studente->nome.'<br>';
        echo 'Cognome: '.$studente->cognome.'<br>';
        echo 'Media:' .$studente->media.'<br>';
        // echo 'Data iscrizione'.$studente->data_iscrizione.'<br>';
        echo '<hr>';
    }
}catch (Exception $e){
    LogError($e);
}*/

//READ 3 con bind value, per media maggiore di 7
/*$query = 'SELECT media,cognome,nome FROM studenti where media > :media';
try{
    // stm sta per statement
    $stm = $db->prepare($query);
    $stm->bindValue(':media', '7');
    $stm->execute();
    while($studente = $stm->fetch()){
        // echo 'Matricola: '.$studente->matricola_studente. '<br>';
        // echo 'Nome: '.$studente->nome.'<br>';
        echo 'Cognome: '.$studente->cognome.'<br>';
        echo 'Media:' .$studente->media.'<br>';
        // echo 'Data iscrizione'.$studente->data_iscrizione.'<br>';
        echo '<hr>';
    }
}catch (Exception $e){
    LogError($e);
}*/

//CREATE
/*$query2 = 'INSERT INTO studenti(matricola_studente, nome, cognome, media, data_iscrizione) VALUES(:matricola_studente, :nome, :cognome, :media, NOW())';
try {
    $stm = $db->prepare($query2);
    $stm->bindValue(':matricola_studente', '00010');
    $stm->bindValue(':nome', 'Lucy');
    $stm->bindValue(':cognome', 'Taylor');
    $stm->bindValue(':media', 8);
    if($stm->execute())
    {
        $stm->closeCursor();
    }
    else
    {
        throw new PDOException('errore nella query');
    }
}catch (Exception $e)
{
    LogError($e);
}
*/

//UPDATE della media di Lucy
$query = 'UPDATE studenti SET media =:media WHERE nome=:nome';
try{
    $stm = $db->prepare($query);
    $stm->bindValue(':nome', 'Lucy');
    $stm->bindValue(':media', 5);

    if($stm->execute()){
        $stm->closeCursor();
    }
    else
        throw new PDOException('errore nella query');
}
catch(Exception $e){
    logError($e);
    echo 'errore generico';
}


//DELETE
$queryDelete = 'DELETE from studenti where nome=:nome';
try{
    $stm = $db->prepare($queryDelete);
    $stm->bindValue(':nome', 'Lucy');
    if($stm->execute())
        $stm->closeCursor();
    else
        throw new PDOException('errore nella delete ');
}catch (Exception $e)
{
    LogError($e);
    echo 'errore generico';
}
function LogError(Exception $e)
{
    // error_log($e->getMessage().'---'.date('Y-m-d H:i:s'."\n"), 3, 'log/database_log');
    error_log($e->getMessage(), 3, 'log/database_log');
    echo 'A DB error occured. Please try again';
}