/**********
Versión: 001
Fecha: Fecha en formato (19-03-2018)
Desarrollador: Viviana Rodas
Descripción: js horario
---------------------------------------
*/
$( document ).ready(function() {
    
	(function($) {  
    $.get = function(key)   {  
        key = key.replace(/[\[]/, '\\[');  
        key = key.replace(/[\]]/, '\\]');  
        var pattern = "[\\?&]" + key + "=([^&#]*)";  
        var regex = new RegExp(pattern);  
        var url = unescape(window.location.href);  
        var results = regex.exec(url);  
        if (results === null) {  
            return null;  
        } else {  
            return results[1];  
        }  
    }  
})(jQuery); 
	
	var idSede = $.get("idSede");
	
	// alert(idSede);
	var table;
	

	listarBloques(idSede); 
	
cargarInformacionEnTabla();	
	
	
});




/**
 * Funcion de listar asignaturas por niveles sedes
 * 
 * param Parámetro: El onchange del select de niveles
 * return Tipo de retorno: Retorna asignaturas por niveles sedes
 * author : Viviana Rodas
 * exception : No tiene excepciones.
 */

// function cargarInformacionEnTabla(data){
function cargarInformacionEnTabla(data){
		
		
		//se destruye el datatable al inicio
	if(typeof table !== "undefined"){
            table.destroy(); 
            $('#tablaHorario').empty();
        }
		
		
		 table = $('#tablaHorario').DataTable({
			 "data": data,
			columns: [
			{ title: "Número" },
			{ title: "Bloque" },
			{ title: "Lunes" },
			{ title: "Martes" },
			// { title: "Miércoles" },
			// { title: "Jueves" },
			// { title: "Viernes" },
			// { title: "Sábado" },
			// { title: "Domingo" },
			],
			"paging":   true,
			"info":     false,
			// "order": [[ 3, "desc" ]],
			"scrollY": "300px",
			"scrollX": true,
			"bDestroy": true,
			"scrollCollapse": true,
			// "columnDefs": [
			// {"targets": [ 0 ],"visible": true,"searchable": true},
			// {"targets": [ 1 ],"visible": false,"searchable": false},
			// {"targets": [ 3 ],"visible": false,"searchable": false},
			// {"targets": [ 5 ],"visible": false,"searchable": false},
			// {"targets": [ 15 ],"visible": false,"searchable": false},
			// {"targets": [ 13 ],"visible": false,"searchable": false},
			// {"targets": [ 16 ],"visible": false,"searchable": false},
			// {"targets": [ 17 ],"visible": false,"searchable": false}
			// ],
			"language": {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
                "sProcessing":     "Procesando...",
				"sSearch": "Filtrar:",
				"zeroRecords": "Ningún resultado encontrado",
				"infoEmpty": "No hay registros disponibles",
				"Search:": "Filtrar"
			}
		});
		// $('#tablaModulos tbody').on('click', 'tr', function () {
			// if ( $(this).hasClass('selected')) {
				// $(this).removeClass('selected');
				// seleccionado = false;
			// }else{
				// table.$('tr.selected').removeClass('selected');
				// $(this).addClass('selected');
				// seleccionado = true;
			// }
			// if(typeof(Storage) !== "undefined") {
				// sessionStorage.Docente = table.row(this).data()[0];
				// sessionStorage.IdPreprogramacion = table.row(this).data()[1];
				// sessionStorage.Salon = table.row(this).data()[2];
				// sessionStorage.IdCurso = table.row(this).data()[3];
				// sessionStorage.Curso = table.row(this).data()[4];
				// sessionStorage.IdModulo = table.row(this).data()[5];
				// sessionStorage.Modulo = table.row(this).data()[6];
				// sessionStorage.FechaInicial = table.row(this).data()[7];
				// sessionStorage.FechaFinal = table.row(this).data()[8];
				// sessionStorage.Duracion = table.row(this).data()[9];
				// sessionStorage.Sede = table.row(this).data()[10];
				// sessionStorage.DiasCurso = table.row(this).data()[11];
				// sessionStorage.Horario = table.row(this).data()[12];
				// sessionStorage.IntensidadHorariaDiaria = table.row(this).data()[13];
				// sessionStorage.Inscritos = table.row(this).data()[14];
				// sessionStorage.Ruta = table.row(this).data()[15];
				// sessionStorage.Modalidad = table.row(this).data()[16];
				// sessionStorage.cantidadSesiones = table.row(this).data()[17]; 
				
			// } else {
				// PopUpError("Por favor actualice su navegador o utilice otro: SessionStorage");
			// }
		// } );
	}



/**
 * Funcion de listar las distribucines academicas.
 * 
 * param Parámetro: No recibe parametros
 * return Tipo de retorno: Retorna la lista de distribuciones
 * author : Viviana Rodas
 * exception : No tiene excepciones.
 */



function listarBloques(idSede){
	
	// alert(idSede+"listarbloques");
	
	$.post( "../../views/distribuciones-academicas/distribuciones_academicas.php", 
				{
					idSede    :idSede,
					accion    : 'consultar_bloques_sede',
				},
				function( data )
				{
					cargarInformacionEnTabla(data);	
					
				},
		"json");
}

