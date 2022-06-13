
create table tblRegistro (
	id int unsigned not null primary key auto_increment,
    horaEntrada time not null,
    horaSaida time,
    precoFinal float,
    diaEntrada date not null,
    diaSaida date,
    idVagas int unsigned not null,
    idVeiculo int unsigned not null,
    
    constraint FK_Registro_Vagas
	foreign key(idVagas)
    references tblVagas(id),
    
    constraint FK_Registro_Veiculo
	foreign key(idVeiculo)
    references tblVeiculo(id),
    unique index(id)
);