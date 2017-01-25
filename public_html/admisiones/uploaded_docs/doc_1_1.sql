exec curs_para_nota_peri_dist_view_NEW N'1467',N'692'

select * from notas_permisos order by nota_perm_codi desc

select * from periodos_distribucion

exec nota_perm_add_NEW N'3',N'254',N'692',N'20150723',N'20150723',N'admin'
exec curs_para_nota_peri_dist_view_prof N'',N'692'
nota_perm_view 44042

select * from materias

select 
	[curs_para_mate_prof_codi]--,
	--@peri_dist_codi,
	--@nota_peri_fec_ini,
	--@nota_peri_fec_fin,
	--@usua_codi 
from 
[dbo].[Cursos_Paralelos_Materias_Profesor] where [curs_para_mate_codi] in
					(select [curs_para_mate_codi] from [dbo].[Cursos_Paralelos_Materias] where [curs_para_codi]=254)
					
					
dbcc checkident (materias, reseed, 488)

select * from materias where mate_codi>488
select * from materias_periodos where mate_codi>406
select * from notas_referencia_cab

exec curs_para_alums_view N'615'
exec curs_para_alums_view N'217'
exec prof_curs_para_view 112,10
exec curs_para_alums_view N'617'
exec curs_para_alums_view N'618'

exec curs_para_alums_view N'273'


select * from cursos

select
	*
from
	alumnos_cursos_paralelos_materias
where
	alumnos_cursos_paralelos_materias.curs_para_mate_prof_codi=615
	
	--delete cursos_paralelos_materias_profesor where curs_para_mate_prof_codi=618

select * from alumnos_cursos_paralelos_materias where curs_para_mate_prof_codi=615

exec curs_para_mate_prof_add N'0',N'1557',N'112',N'14'
--@curs_para_mate_prof_codi bigint,
--@curs_para_mate_codi bigint,
--@prof_codi int,
--@aula_codi int

select count(*) from cursos_paralelos_materias_profesor 
			where curs_para_mate_codi=1557 and prof_codi=112
			
select count(*) from cursos_paralelos_materias_profesor
				where curs_para_mate_codi=1557
	
select * from cursos_paralelos_materias where curs_para_mate_codi=1557

	select * from
		alumnos_cursos_paralelos_materias
	where
		curs_para_mate_codi is null
		

	
	
------------select *  from alumnos_cursos_paralelos_materias where curs_para_mate_codi in
------------(
------------select curs_para_mate_codi from cursos_paralelos_materias where mate_codi>280
------------)

select * from alumnos where alum_codi=2013320018

alum_curs_peri_mate_view 2013320018, 264
alum_curs_peri_mate_view
exec prof_curs_para_mate_view 112,10
select * from periodos_distribucion
select * from notas_referencia_cab

select * from materias


--Eliminación para empezar de nuevo
--delete from alumnos_cursos_paralelos_materias where curs_para_mate_codi in
--(
--	select curs_para_mate_codi from cursos_paralelos_materias where mate_codi>=191
--)

--delete from cursos_paralelos_materias where mate_codi>=191

select * from cursos_paralelos_materias_profesor where curs_para_mate_codi in
(
	select curs_para_mate_codi from cursos_paralelos_materias where mate_codi>191
)




select 
	materias_periodos.mate_codi,
	materias_periodos.mate_deta,
	materias_periodos.mate_tipo,
	case when (select count(mate_codi) from materias_periodos MP where MP.mate_padr=materias_periodos.mate_codi)>0 
		then 'SI' 
		else 'NO' 
	end
	tiene_hijos,
	dbo.F_Materia_Nivel(materias_periodos.mate_codi) nivel
from 
	cursos_paralelos_materias
	join materias_periodos
	on cursos_paralelos_materias.mate_codi=materias_periodos.mate_codi
where
	cursos_paralelos_materias.curs_para_codi=250
order by
	cursos_paralelos_materias.curs_para_mate_orde asc
	
	
	
declare @nivel as int, @padre as int
set @nivel=0
set @padre=403

while (@padre<>-1)
begin
	select
		@padre=mate_padr
	from
		materias_periodos
	where
		mate_codi=@padre
		
	set @nivel=@nivel+1
end


select 
	* 
from 
	periodos_distribucion 
where 
	peri_dist_padr=691 and
	nota_refe_cab_codi=(case  when  nota_refe_cab_codi is not null then 4 end)