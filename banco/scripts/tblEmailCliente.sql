
create table tblEmail_Cliente (
	id int unsigned not null primary key auto_increment,
    email varchar(100) not null,
    idCliente int unsigned not null,
    
    constraint FK_Email_Cliente
	foreign key(idCliente)
    references tblCliente(id),
    
    unique index(id)
);

insert into tblEmail_Cliente
			(telefone,
            idCliente)
			values(
            "11 99999-9999",
            1
            );

update tblEmail_Cliente set telefone = "" where id = 1;

delete from tblEmail_Cliente where id = 1;

select * from tblEmail_Cliente;
