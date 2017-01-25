select 
	* 
from 
	notas 
where 
	alum_curs_para_mate_codi=10971 and peri_dist_codi=639
	
--select * from periodos_distribucion

select * from notas_periodo_cualitativo
select * from materias_periodos




	select 
		mate_padr 
	from 
		materias_periodos 
	where 
		mate_codi in(
					select
						mate_codi
					from
						cursos_paralelos_materias
					where
						curs_para_mate_codi 
						in (
							select
								curs_para_mate_codi
							from
								alumnos_cursos_paralelos_materias
							where
								alum_curs_para_mate_codi=10971
							)
						) and peri_codi=10