create table tblCliente (
	id int unsigned not null primary key auto_increment,
    nome varchar(80) not null,
    documento varchar(25) not null,
    email varchar(100),
    telefone varchar(20),
	unique index(id)
);

alter table tblCliente
	add column email varchar(100);    
    desc tblCliente;    
	show tables;  


update tblCliente set
			nome = "",
			documento = "",
            email ="",
            telefone =""
            where id = 1;

delete from tblCliente where id = 1;

use dbfastparking;
desc tblCliente;
select * from tblCliente;



    
     
    
   