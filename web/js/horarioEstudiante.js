/**********
Versión: 001
Fecha: Fecha en formato (27-04-2018)
Desarrollador: Oscar David lopez
Descripción: Horario docente 
---------------------------------------

*/

$( document ).ready(function() {
    
	
		
  listarHorario(); 
	var tabla="";
});


function listarHorario(){
		
	idDocente = $("#horariodocente-id_perfiles_x_personas_docentes").val();
	
	//si no tien ningun docente seleccionado oculat la tabla
	if(idDocente =="")
	{
		$('#tablaModulos_wrapper').hide();
		$('#tablaModulosLabel').hide();
		return false;
		
	}
	$.get( "index.php?r=horario-estudiante/index", 
				function( data )
				{
					$('#tablaModulosLabel').show();
					cargarInformacionEnTabla(data);
					
				},
		"json");
}

//llenar el datatable del horario
function cargarInformacionEnTabla(data)
{
		
		//se destruye el datatable al inicio
	if(typeof table !== "undefined")
	{
		
        table.destroy(); 
        $('#tablaModulos').empty();
    }
		
			
		 table = $('#tablaModulos').DataTable({
			"data": data,
			columns: [
			{ data: "bloques"},
			{ data: "LUNES"},
			{ data: "MARTES"},
			{ data: "MIERCOLES" },
			{ data: "JUEVES" },
			{ data: "VIERNES" },
			{ data: "SABADO" },
			{ data: "DOMINGO" },
			
			// {data: null, className: "center", defaultContent: '<a id="view-link" class="edit-link" href="#" title="Edit">Estudiantes por Salón </a>'},
			// {data: null, className: "center", defaultContent: '<a id="asistencias-link" class="asistencias-link" href="#" title="Edit">Asistencias</a>'}
			],
			"info":     false,
			"order": [[ 0, "asc" ]],
			"scrollY": "300px",
			"scrollX": true,
			"bDestroy": true,
			"bSort": false,
			"scrollCollapse": true,
			"searching": false,
			"paging": false,
			"filter":false,
			"columnDefs": [
			// {"targets": [ 0 ],"visible": true,"searchable": true},
			// {"targets": [ 1 ],"visible": true,"searchable": false},
			// {"targets": [ 3 ],"visible": false,"searchable": false},
			// {"targets": [ 5 ],"visible": false,"searchable": false},
			// {"targets": [ 15 ],"visible": false,"searchable": false},
			// {"targets": [ 13 ],"visible": false,"searchable": false},
			// {"targets": [ 16 ],"visible": false,"searchable": false},
			// {"targets": [ 17 ],"visible": false,"searchable": false}
			],
			"language": {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
                "sProcessing":     "Procesando...",
				"sSearch": "Filtrar:",
				"zeroRecords": "Ningún resultado encontrado",
				"infoEmpty": "No hay registros disponibles",
				"Search:": "Filtrar"
			}
		});
		
}



