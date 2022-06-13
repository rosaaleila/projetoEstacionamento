show databases;

use dbfastparking;

show tables;

select * from tblveiculo;

select * from tblcliente;

select * from tblregistro;

select * from tblvagas;

select * from tblplano;

select count(tblvagas.numero) from tblvagas inner join tblregistro on tblvagas.id = tblregistro.idvagas and tblregistro.diasaida is null;

select tblveiculo.placa, tblregistro.id from tblveiculo inner join tblregistro on tblveiculo.id = tblregistro.idveiculo and tblregistro.diasaida is null;

select count(tblvagas.numero) from tblvagas;

select distinct((select count(tblvagas.numero) from tblvagas) - (select count(tblvagas.numero) from tblvagas inner join tblregistro on tblvagas.id = tblregistro.idvagas and tblregistro.diasaida is null)) as vagasLivres from tblregistro;

# Endpoint retornando todos os carros estacionados e o valor total de lucro, baseando de um periodo ao outro

select tblregistro.precofinal, tblveiculo.placa, tblregistro.diaentrada from tblregistro inner join tblveiculo on tblveiculo.id = tblregistro.idveiculo and tblregistro.diaEntrada between '2022-06-03' and  '2022-06-08';
