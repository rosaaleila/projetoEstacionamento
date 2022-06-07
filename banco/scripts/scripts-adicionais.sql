show databases;

use dbfastparking;

show tables;

select * from tblveiculo;

select * from tblcliente;

select * from tblregistro;

select * from tblvagas;

select * from tblplano;

# retorna os carros estacionados
select tblveiculo.placa, tblregistro.id from tblveiculo inner join tblregistro on tblveiculo.id = tblregistro.idveiculo and tblregistro.diasaida is null;

# Retorna a quantidade de vagas ocupadas
select count(tblvagas.numero) from tblvagas inner join tblregistro on tblvagas.id = tblregistro.idvagas and tblregistro.diasaida is null;

# retorna a quantidade total de vagas
select count(tblvagas.numero) from tblvagas;

# Endpoints retornando a quantidade de vagas livres
select distinct((select count(tblvagas.numero) from tblvagas) - (select count(tblvagas.numero) from tblvagas inner join tblregistro on tblvagas.id = tblregistro.idvagas and tblregistro.diasaida is null)) as vagasLivres from tblregistro;

# Endpoint retornando todos os carros estacionados e o valor total de lucro, baseando de um periodo ao outro
select count(tblveiculo.placa) as veiculosEstacionados, SUM(tblregistro.precofinal) as valorTotal from tblregistro inner join tblveiculo on tblveiculo.id = tblregistro.idveiculo and tblregistro.diaEntrada between '2022-06-03' and  '2022-06-08' and tblregistro.diasaida is not null;

select tblveiculo.placa, tblveiculo.id as idVeiculo from tblveiculo where tblveiculo.placa = 'DCE-1587';