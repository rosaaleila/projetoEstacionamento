create table tblVeiculo (
	id int unsigned not null primary key auto_increment,
    placa varchar(8) not null,
    idCliente int unsigned not null,
    
    constraint FK_Veiculo_Cliente
	foreign key(idCliente)
    references tblCliente(id),
    
    unique index(id)
);