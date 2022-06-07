create table tblPlano (
	id int unsigned not null primary key auto_increment,
    nome varchar(80) not null,
    primeiraHora float not null,
    horasAdicionais float not null,
    diaria float not null,
    unique index(id)
);