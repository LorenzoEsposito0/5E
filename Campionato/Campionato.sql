create database campionato;
use campionato;

create table campionato.casa
(
	nome VARCHAR(100) primary key,
    colore VARCHAR(50) not null
);

create table campionato.pilota
(
	numero int primary key,
	nome VARCHAR(100) not null,
    cognome VARCHAR(100) not null,
    nazionalita VARCHAR(50) not null,
    nome_casa VARCHAR(100),
    foreign key (nome_casa) references campionato.casa(nome)
);

create table campionato.gara 
(
	data date,
	localita VARCHAR(100) not null,
	primary key (data, localita)
);

create table campionato.partecipazione
(
	numero int,
    data DATE,
    localita VARCHAR(100),
    posizione INT check (posizione >= 1),
    giro_veloce time,
    primary key (numero, data, localita),
    foreign key (numero) references campionato.pilota(numero),
    foreign key (data, localita) references campionato.gara(data, localita)
);
