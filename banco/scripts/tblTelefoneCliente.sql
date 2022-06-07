
create table tblTelefone_Cliente (
	id int unsigned not null primary key auto_increment,
    telefone varchar(20) not null,
    idCliente int unsigned not null,
    
    constraint FK_Telefone_Cliente
	foreign key(idCliente)
    references tblCliente(id),
    
    unique index(id)
);

insert into tblTelefone_Cliente
			(telefone,
            idCliente)
			values(
            "11 99999-9999",
            1
            );


update tblTelefone_Cliente set telefone = "" where id = 1;

delete from tblTelefone_Cliente where id = 1;

select * from tblTelefone_Cliente;