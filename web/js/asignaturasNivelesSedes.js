/**********
Versión: 001
Fecha: 27-03-2018
---------------------------------------
Modificaciones:
Fecha: 01-05-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se agrega filtro por AREAS DE ENSEÑANZA al CRUD
---------------------------------------
**********/

$( document ).ready(function() {
	
	llenarListas(idModelo);
});


function llenarAreas( sede, idModelo = 0 )
{		
		
	$.get( "index.php?r=asignaturas-niveles-sedes/areas-ensenanza&sede="+sede+"&idModelo="+idModelo,
			function( data )
			{
				$("[name=areas]").html( data.areas );
				$("[name=areas]").val( data.selectAreas );
				
				if( idModelo != 0 )
					llenarListaAsignatura( idModelo );
			},
		"json");
	
}

function llenarListas( idModelo=0 )
{		

	var areae = $("[name=areas]").val() || 0;
		
	$.get( "index.php?r=asignaturas-niveles-sedes/niveles-sedes&idSede="+$( "#sedes-descripcion" ).val()+"&idModelo="+idModelo+"&area="+areae, 
			function( data )
			{
				$("#asignaturasnivelessedes-id_sedes_niveles").html(data.niveles);
				$("#asignaturasnivelessedes-id_asignaturas").html(data.asignaturas);
				
				$("#asignaturasnivelessedes-id_sedes_niveles").val(data.selectNiveles);
				$("#asignaturasnivelessedes-id_asignaturas").val(data.selectAsignatura);
				
				llenarAreas( $( "#sedes-descripcion" ).val(), idModelo );
			},
		"json");
	
}

function llenarListaAsignatura( idModelo=0 )
{		

	var areae = $("[name=areas]").val() || 0;
		
	$.get( "index.php?r=asignaturas-niveles-sedes/niveles-sedes&idSede="+$( "#sedes-descripcion" ).val()+"&idModelo="+idModelo+"&area="+areae, 
			function( data )
			{
				$("#asignaturasnivelessedes-id_asignaturas").html(data.asignaturas);
				$("#asignaturasnivelessedes-id_asignaturas").val(data.selectAsignatura);
			},
		"json");
	
}

function llenarComboGrupo()
{
	
	idDocente =	$("#selDocentes").val();
	idNivel   =	$("#selGrado").val();
	//si el idNivel esta vacio no hace nada
	if(idNivel == "")
	{
		//si grado tiene ningun nombre seleccionado se vacia el combo de grado y se pone ese html
		$("#selGrupo").html("<option value=''>Seleccione...<\/option>");
		return false;
	}
	
	//consulta los niveles que tiene asociado ese docente
	$.get( "index.php?r=calificaciones/grupo-niveles-docente&idDocente="+idDocente+"&idNivel="+idNivel, 
			function( data )
			{
				$("#selGrupo").html(data);
			},
	"json");
		
}