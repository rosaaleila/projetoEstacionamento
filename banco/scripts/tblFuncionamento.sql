create table tblFuncionamento (
	id int unsigned not null primary key auto_increment,
    horaAbertura TIME not null,
    horaFechamento TIME not null,
    idEstacionamento int unsigned not null,
    idDia int unsigned not null,
    
    constraint FK_Funcionamento_Dia
	foreign key(idDia)
    references tblDia(id),
    
    constraint FK_Funcionamento_Estacionamento
	foreign key(idEstacionamento)
    references tblEstacionamento(id),
    
    unique index(id)
);

insert into tblFuncionamento
			(horaAbertura,
			horaFechamento,
            idEstacionamento,
            idDia)
			values(
            "",
            "",
            "",
            ""
            );

update tblFuncionamento set
			horaAbertura = "",
			horaFechamento = "",
            idEstacionamento = "",
            idDia = ""
            where id = 1;

delete from tblFuncionamento where id = 1;

select * from tblFuncionamento;
