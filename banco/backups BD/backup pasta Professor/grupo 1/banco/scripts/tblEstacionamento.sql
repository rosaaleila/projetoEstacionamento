use dbfastparking;

create table tblEstacionamento (
	id int unsigned not null primary key auto_increment,
    nome varchar(80) not null,
    logradouro varchar(100) not null,
    numero varchar(10) not null,
    cep varchar(10) not null,
    bairro varchar(80) not null,
    cidade varchar(60) not null,
    estado varchar(60) not null,
    unique index(id)
);

insert into tblEstacionamento
			(nome,
			logradouro,
            numero,
            cep,
            bairro,
            cidade,
            estado)
			values(
            "Fast Parking",
            "AV. Monteiro Lobato",
            "4250",
            "07180-000",
            "Cidade Jardim Cumbica",
            "Guarulhos",
            "São Paulo"
            );

update tblEstacionamento set
			nome = "",
			logradouro = "",
            numero = "",
            cep = "",
            bairro = "",
            cidade = "",
            estado = ""
            where id = 1;

delete from tblEstacionamento where id = 1;

select * from tblEstacionamento;

###Filtros SQL para a API

#Listar todos os estacionamentos (aberto para uma rede de estacionamentos)
select * from tblEstacionamento order by id desc;

#Selecionar o estacionamento por ID
select * from tblEstacionamento where id = 3

#