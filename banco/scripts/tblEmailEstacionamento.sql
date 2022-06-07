
create table tblEmail_Estacionamento (
	id int unsigned not null primary key auto_increment,
    email varchar(100) not null,
    idEstacionamento int unsigned not null,
    
    constraint FK_Email_Estacionamento
	foreign key(idEstacionamento)
    references tblEstacionamento(id),
    
    unique index(id)
);

insert into tblEmail_Estacionamento
			(email,
            idEstacionamento)
			values(
            "fastparkingofficial@gmail.com",
            1
            );

update tblEmail_Estacionamento set email = "" where id = 1;

delete from tblEmail_Estacionamento where id = 1;

select * from tblEmail_Estacionamento;