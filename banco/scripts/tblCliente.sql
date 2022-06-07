create table tblCliente (
	id int unsigned not null primary key auto_increment,
    nome varchar(80) not null,
    documento varchar(25) not null,

	unique index(id)
);

insert into tblCliente
			(nome,
            documento)
			values(
            "",
            ""
            );

update tblCliente set
			nome = "",
			documento = ""
            where id = 1;

delete from tblCliente where id = 1;

select * from tblCliente;