/**********
Versión: 001
Fecha: 24-05-2018
Desarrollador: Oscar David Lopez villa
Descripción: js para participacion proyectos jornada
---------------------------------------
Modificaciones:
Fecha: 25-05-2018
Persona encargada: Oscar David Lopez villa
Cambios realizados: Cuando se seleciona un tipo se llenan las personas de ese tipo y de esa institucion
---------------------------------------
Modificaciones:
Fecha: 26-05-2018
Persona encargada: Oscar David Lopez villa
Cambios realizados: si no tiene un tipo selecionado el campo nombre participante se vacia
---------------------------------------
**********/


$( document ).ready(function() 
{
	
	var url = window.location.href; 
	if (url.indexOf('update')!=-1) 
	{	
		llenarParticipantes();
	}
	
	$( "#participacionproyectosjornada-tipo" ).change(function() 
	{
		llenarParticipantes();
	});
		
});

function llenarParticipantes()
{
	
	
	idInstitucion 	= $("#participacionproyectosjornada-id_institucion").val();
			idPerfil 		= $( "#participacionproyectosjornada-tipo" ).val();
			if (idPerfil == "")
			{
				$( "#participacionproyectosjornada-nombre_participante" ).html( "" );
			}
			else
			{
				$.get( "index.php?r=participacion-proyectos-jornada/nombre-persona&idInstitucion="+idInstitucion+"&idPerfil="+idPerfil, 
					function( data )
					{
						
						var options = "<option value=''>Seleccione...</option>";
						
						data.forEach(function(e) {
							console.log(e);
							options += "<option value='"+e.id+"'>"+e.nombre+"</option>";
							
						});
						
						
						$("#participacionproyectosjornada-nombre_participante").html( options );
						$("#participacionproyectosjornada-nombre_participante").val(idParticipante);
					},
				"json");
			}
}