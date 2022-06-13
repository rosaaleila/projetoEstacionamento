
create table tblSetor (
	id int unsigned not null primary key auto_increment,
    nome varchar(1) not null,
	unique index(id)
);

insert into tblSetor(nome) values("F");

update tblSetor set nome = "A" where id = 1;

delete from tblSetor where id = 1;

select * from tblSetor;