show databases;

use dbfastparking;

show tables;

select * from tblveiculo;

select * from tblcliente;

select * from tblregistro;

select * from tblvagas;

select * from tblcliente;

select * from tblplano;

# retorna os carros estacionados
select tblveiculo.placa, tblregistro.id from tblveiculo inner join tblregistro on tblveiculo.id = tblregistro.idveiculo and tblregistro.diasaida is null;

# Retorna a quantidade de vagas ocupadas
select tblvagas.numero from tblvagas inner join tblregistro on tblvagas.id = tblregistro.idvagas and tblregistro.diasaida is null;

# retorna a quantidade total de vagas
select count(tblvagas.numero) from tblvagas;

# select retornando a quantidade de vagas livres
select distinct((select count(tblvagas.numero) from tblvagas) - (select count(tblvagas.numero) from tblvagas inner join tblregistro on tblvagas.id = tblregistro.idvagas and tblregistro.diasaida is not null)) as vagasLivres from tblregistro;

# select retornando todos os carros estacionados e o valor total de lucro, baseando de um periodo ao outro
select count(tblveiculo.id) as veiculosEstacionados, SUM(tblregistro.precofinal) as valorTotal from tblregistro inner join tblveiculo on tblveiculo.id = tblregistro.idveiculo and tblregistro.diaEntrada between '2022-06-03' and '2022-06-08' and tblregistro.diasaida is not null;

# select retornando id veiculo, placa, nome cliente, rg, dia e hora entrada, tempo atual, valor atual, vaga, setor e plano
select
	tblveiculo.id as idVeiculo,
    tblveiculo.placa,
    tblcliente.nome as nomeCliente,
    tblcliente.documento as RG,
    tblregistro.horaentrada,
    tblregistro.diaentrada,
    (select timestampdiff(hour, 
    (select concat(tblregistro.diaentrada, ' ', tblregistro.horaentrada)), 
    current_timestamp()))
    as tempoTotal,
    (select distinct
	(select IF((select hour(timediff((select tblregistro.horaentrada), curtime()))) != 1, (select hour(timediff((select tblregistro.horaentrada), curtime())) - 1) * (select tblplano.horasAdicionais) +
    (select tblplano.primeiraHora), (select hour(timediff((select tblregistro.horaentrada),
    curtime()) + (select tblplano.primeiraHora)))
    +
    (select (select datediff(curdate(), (select tblregistro.diaentrada))) *
    (select tblplano.diaria))
    )
	as valorTotal,
    tblvagas.numero as vaga,
    tblsetor.nome as setor,
    tblplano.nome as plano
    from tblveiculo 
    inner join tblcliente 
    on tblcliente.id = tblveiculo.idcliente 
    inner join tblregistro 
    on tblveiculo.id = tblregistro.idveiculo 
    and tblveiculo.placa = 'JFK-4857'
    inner join tblvagas
    on tblvagas.id = tblregistro.idvagas
    inner join tblsetor
    on tblsetor.id = tblvagas.idsetor
    inner join tblplano
    on tblplano.id = tblvagas.idplano
    ;

select tblregistro.id, (select IF((select hour(timediff((select tblregistro.horaentrada), curtime()))) != 1,
	(select hour(timediff((select tblregistro.horaentrada), curtime())) - 1) * (select tblplano.horasAdicionais) +
    (select tblplano.primeiraHora), (select hour(timediff((select tblregistro.horaentrada),
    curtime()) + (select tblplano.primeiraHora))))
    +
    (select (select datediff(curdate(), (select tblregistro.diaentrada))) *
    (select tblplano.diaria))
    ) from tblregistro, tblplano where tblregistro.id = 1;

select distinct
    ((select count(tblvagas.numero) from tblvagas) - (select count(tblvagas.numero)
    from tblvagas 
    inner join tblregistro on tblvagas.id = tblregistro.idvagas
    and tblregistro.diasaida is null))
    as vagasLivres from tblregistro;

# endpoint para saida - placa, id registro, id plano de todos carros estacionados
select tblregistro.id as idRegistro, tblplano.id as idPlano, tblveiculo.placa from tblveiculo inner join tblregistro on tblveiculo.id = tblregistro.idveiculo and tblregistro.diasaida is null inner join tblvagas on tblregistro.idvagas = tblvagas.id inner join tblplano on tblvagas.idplano = tblplano.id;

# endpoint para calcular o tempo total (timestamp)
select timestampdiff(hour, (select concat(tblregistro.diaentrada, ' ', tblregistro.horaentrada)), current_timestamp());

# tempo total separado
select hour(timediff((select tblregistro.horaentrada from tblregistro, tblveiculo where tblveiculo.id = tblregistro.idveiculo and tblveiculo.id = 2), curtime())) - 1;
select datediff(curdate(), (select tblregistro.diaentrada from tblregistro, tblveiculo where tblveiculo.id = tblregistro.idveiculo and tblveiculo.id = 2)) as diasTotais;
select concat(tblregistro.diaentrada, ' ', tblregistro.horaentrada) from tblregistro, tblveiculo where tblveiculo.id = tblregistro.idveiculo;

# calcular valor total
select tblplano.primeiraHora from tblplano where tblplano.id = 1;
select tblplano.horasadicionais from tblplano where tblplano.id = 1;
select tblplano.diaria from tblplano where tblplano.id = 1;

# valor total hora
select distinct IF(
	(select hour(timediff((select tblregistro.horaentrada)
    , curtime())) - 1) != 0,
    (select hour(timediff((select tblregistro.horaentrada),
    curtime())) - 1) * (select tblplano.horasAdicionais) +
    (select tblplano.primeiraHora), null)
    as totalHoras from tblplano, tblregistro, tblveiculo where tblplano.id = 1 and tblveiculo.id = tblregistro.idveiculo and tblveiculo.id = 2;

# valor total dia
select distinct IF(
	(select datediff(curdate(), (select tblregistro.diaentrada))) != 0,
    (select datediff(curdate(), (select tblregistro.diaentrada))) *
    (select tblplano.diaria), null)
    as totalDiaria from tblregistro, tblveiculo, tblplano where tblveiculo.id = tblregistro.idveiculo and tblveiculo.id = 2 and tblplano.id = 1;

# valor total
select distinct
	(
	select IF((select hour(timediff((select tblregistro.horaentrada)
    , curtime() ))) != 0,
    (select hour(timediff((select tblregistro.horaentrada),
    curtime() )) - 1) * (select tblplano.horasAdicionais) +
    (select tblplano.primeiraHora), null)
    )
    +
    (
    select IF((select datediff(curdate(), (select tblregistro.diaentrada))) != 0,
    (select datediff(curdate(), (select tblregistro.diaentrada))) *
    (select tblplano.diaria), null)
    )
    as valorTotal
    from tblregistro, tblveiculo, tblplano where tblveiculo.id = tblregistro.idveiculo and tblveiculo.id = 2 and tblplano.id = 1;

select distinct
		tblveiculo.id as idVeiculo,
		tblveiculo.placa,
		tblcliente.nome as nomeCliente,
		tblcliente.documento as RG,
		tblregistro.horaentrada,
		tblregistro.diaentrada,
    tblvagas.numero as vaga,
		tblsetor.nome as setor,
		tblplano.nome as plano,
				(select timestampdiff(hour, (select concat(tblregistro.diaentrada, ' ', tblregistro.horaentrada)), 
										current_timestamp()) ) as tempoTotal,
				(select
					(select IF((select hour(timediff((select tblregistro.horaentrada), curtime() ))) != 0,
								(select hour(timediff((select tblregistro.horaentrada),	curtime() )) - 1) 
										 * (select tblplano.horasAdicionais) 
										 + (select tblplano.primeiraHora), null)
						)
						+ (select IF((select datediff(curdate(), (select tblregistro.diaentrada))) != 0,
								(select datediff(curdate(), (select tblregistro.diaentrada))) 
									* (select tblplano.diaria), null)) 
					) as valorTotal		
	  from tblveiculo 
    inner join tblcliente 
		on tblcliente.id = tblveiculo.idcliente 
    inner join tblregistro 
		on tblveiculo.id = tblregistro.idveiculo and tblveiculo.placa = 'JFK-4857'
    inner join tblvagas
		on tblvagas.id = tblregistro.idvagas
    inner join tblsetor
		on tblsetor.id = tblvagas.idsetor
    inner join tblplano
		on tblplano.id = tblvagas.idplano;

select tblregistro.id as idRegistro, tblplano.id as idPlano, tblveiculo.placa from tblveiculo inner join tblregistro on tblveiculo.id = tblregistro.idveiculo and tblregistro.diasaida is null inner join tblvagas on tblregistro.idvagas = tblvagas.id inner join tblplano on tblvagas.idplano = tblplano.id;

select
    tblregistro.id as idRegistro,
    tblplano.id as idPlano,
    tblveiculo.placa
    from tblveiculo
    inner join tblregistro
    on tblveiculo.id = tblregistro.idveiculo
    and tblregistro.diasaida is null
    inner join tblvagas
    on tblregistro.idvagas = tblvagas.id
    inner join tblplano
    on tblvagas.idplano = tblplano.id;

#"placa": string,
#"vaga": int,
#"nomeCliente": string
#"rg": string,
#"horaEntrada": string,
#"dataEntrada": string,
#"valorAtual": float,
#"tempoTotal": float,
#"valorTotal": float,
#"plano": string