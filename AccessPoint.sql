create database AccessPoint;
use AccessPoint;

create table Tipi(
modello varchar(30),
nome varchar(30),
frequenza varchar(10)
);

INSERT INTO Tipi (modello, nome, frequenza) VALUES
('Aironet 4800','Cisco' ,'2.4 GHz'),
('Orbi RBK852', 'Ciao','2.4 GHz'), -- non ritorna ciao nella join perchè diverso dalle tuple di nome di creatori.
('Archer AX73', 'TP-Link','2.4 GHz'),
('UniFi 6 Lite', 'Ubiquiti','2.4 GHz'),
('Archer C80', 'Asus','2.4 GHz'),
('Nighthawk AX12', 'D-Link','2.4 GHz'),
('Aironet 3800', 'MikroTik','2.4 GHz');

CREATE TABLE creatori (
    ID_creatori int auto_increment primary KEY,
    nome VARCHAR(100) NOT NULL,
    paese VARCHAR(50),
    website VARCHAR(255)
);

-- delete
delete from tipi;


-- create
INSERT INTO creatori (nome, paese, website) VALUES
('Cisco', 'USA', 'https://www.cisco.com'),
('Netgear', 'USA', 'https://www.netgear.com'),
('TP-Link', 'China', 'https://www.tp-link.com'),
('Ubiquiti', 'USA', 'https://www.ui.com'),
('Asus', 'Taiwan', 'https://www.asus.com'),
('D-Link', 'Taiwan', 'https://www.dlink.com'),
('MikroTik', 'Latvia', 'https://www.mikrotik.com');

select *
from tipi ;

-- read
select *
from creatori ;

-- update
update creatori 
set paese = 'italy'
where nome = 'MikroTik';


-- JOIN
-- inner join
select tipi.nome
from AccessPoint.tipi
inner join AccessPoint.creatori  
on tipi.nome = creatori.nome;

-- left join
select tipi.nome 
from AccessPoint.tipi
left join AccessPoint.creatori
on tipi.nome = creatori.nome;


-- right join
select tipi.nome
from AccessPoint.tipi
right join AccessPoint.creatori
on tipi.nome = creatori.nome;

-- full join
