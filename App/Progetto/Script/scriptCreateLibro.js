document.getElementById("FinishCreate").addEventListener('onclick', function (){
const Titolo = document.getElementById('nomeLibro');
const Autore = document.getElementById('')
});

function validateForm() {
    // Ottieni i valori dei campi
    var titolo = document.getElementById('nomeLibro').value;
    var autore = document.getElementById('AutoreLibro').value;
    var genere = document.getElementById('GenereLibro').value;
    var prezzo = document.getElementById('PrezzoLibro').value;
    var anno = document.getElementById('AnnoPubblicazione').value;

    // Controlla se qualche campo è vuoto
    if (titolo == "" || autore == "" || genere == "" || prezzo == "" || anno == "") {
        // Se c'è un campo vuoto, mostra l'alert e impedisci l'invio
        alert("Per favore, compila tutti i campi.");
        return false; // Blocca l'invio del form
    }
    return true; // Permette l'invio del form se tutti i campi sono compilati
}