
create table tblEmail(
	id int unsigned not null primary key auto_increment,
    email varchar(100) not null,
    idEstacionamento int unsigned not null,
    
    constraint FK_Email_Estacionamento
	foreign key(idEstacionamento)
    references tblEstacionamento(id),
    
    unique index(id)
);

insert into tblEmail
			(email,
            idEstacionamento)
			values(
            "fastparkingofficial@gmail.com",
            1
            );

update tblEmail_Estacionamento set email = "" where id = 1;

delete from tblEmail_Estacionamento where id = 1;

use dbfastparking;

show tables;

select * from tblEmail_Estacionamento;


#select para listar os email do estacionamento por mais recente, ordem descrescente
select * from tblEmail_Estacionamento order by id desc;

# buscar email do estacionamento por id
select * from tblEmail_Estacionamento where id = 3;

#deletar email do estacionamento por id
delete from tblEmail_Estacionamento where id = 3;

