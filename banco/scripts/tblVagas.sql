
create table tblVagas (
	id int unsigned not null primary key auto_increment,
    numero INT not null,
    idSetor int unsigned not null,
    idEstacionamento int unsigned not null,
    idPlano int unsigned not null,
    
    constraint FK_Vagas_Setor
	foreign key(idSetor)
    references tblSetor(id),
    
    constraint FK_Vagas_Estacionamento
	foreign key(idEstacionamento)
    references tblEstacionamento(id),
    
    constraint FK_Vagas_Plano
	foreign key(idPlano)
    references tblPlano(id),
    
    unique index(id)
);

insert into tblVagas
			(numero,
			idSetor,
            idEstacionamento,
            idPlano)
			values(
            "",
            "",
            "",
            ""
            );

update tblVagas set
			numero = "",
			idSetor = "",
            idEstacionamento = "",
            idPlano = ""
            where id = 1;

delete from tblVagas where id = 1;

select * from tblVagas;
