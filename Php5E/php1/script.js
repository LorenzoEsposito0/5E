// Validazione del primo modulo
document.getElementById('submit1').addEventListener('click', function () {
    const name = document.getElementById('name');
    const surname = document.getElementById('surname');
    const email = document.getElementById('email');
    const password = document.getElementById('password');

    let isValid = true;

    // Nome
    if (!/^[a-zA-ZÀ-ÿ\s]{2,}$/.test(name.value)) {
        document.getElementById('error-name').textContent = "Inserisci un nome valido.";
        isValid = false;
    } else {
        document.getElementById('error-name').textContent = "";
    }

    // Cognome
    if (!/^[a-zA-ZÀ-ÿ\s]{2,}$/.test(surname.value)) {
        document.getElementById('error-surname').textContent = "Inserisci un cognome valido.";
        isValid = false;
    } else {
        document.getElementById('error-surname').textContent = "";
    }

    // Email
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
        document.getElementById('error-email').textContent = "Inserisci un'email valida.";
        isValid = false;
    } else {
        document.getElementById('error-email').textContent = "";
    }

    // Password
    if (password.value.length < 6) {
        document.getElementById('error-password').textContent = "La password deve essere almeno di 6 caratteri.";
        isValid = false;
    } else {
        document.getElementById('error-password').textContent = "";
    }

    if (isValid) {
        document.getElementById('form1').style.display = "none";
        document.getElementById('form2').style.display = "block";
    }
});

// Validazione del secondo modulo
document.getElementById('submit2').addEventListener('click', function () {
    const q1 = document.querySelector('input[name="question1"]:checked');
    const q2 = document.querySelector('input[name="question2"]:checked');
    const q3 = document.getElementById('domanda3').value.trim();

    const correctAnswers = {
        question1: "MySQL",
        question2: "Database Management System",
    };

    let resultsHTML = "";

    // Domanda 1
    resultsHTML += `<p>Domanda 1: ${q1 ? q1.value : "Non risposto"} 
        ${q1 && q1.value === correctAnswers.question1 ? '<span class="correct">✔</span>' : '<span class="incorrect">✘</span>'}</p>`;

    // Domanda 2
    resultsHTML += `<p>Domanda 2: ${q2 ? q2.value : "Non risposto"} 
        ${q2 && q2.value === correctAnswers.question2 ? '<span class="correct">✔</span>' : '<span class="incorrect">✘</span>'}</p>`;

    // Analisi del testo per la risposta aperta
    const wordCount = q3.split(/\s+/).filter(word => word.length > 0).length;
    const consonants = (q3.match(/[^aeiouAEIOU\s\d]/g) || []).length;
    const vowels = (q3.match(/[aeiouAEIOU]/g) || []).length;
    const numbers = (q3.match(/\d/g) || []).length;

    const analysisHTML = `
        <p>Numero di parole: ${wordCount}</p>
        <p>Numero di consonanti: ${consonants}</p>
        <p>Numero di vocali: ${vowels}</p>
        <p>Numero di caratteri numerici: ${numbers}</p>
    `;

    document.getElementById('results-questions').innerHTML = resultsHTML;
    document.getElementById('text-analysis').innerHTML = analysisHTML;

    document.getElementById('form2').style.display = "none";
    document.getElementById('results').style.display = "block";
});
