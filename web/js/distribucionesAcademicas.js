/**********
Versión: 001
Fecha: Fecha en formato (15-03-2018)
Desarrollador: Viviana Rodas
Descripción: js Distribuciones academicas
---------------------------------------
Versión: 002
Fecha: Fecha en formato (26-04-2018)
Desarrollador: Oscar David lopez
Descripción: Horario con datatables
---------------------------------------

*/

$( document ).ready(function() 
{
	//variable para saber si se borra la districion academica 
	borrar="";
	
	modificar = $("#hidModificar").val();
	asignaturas_distribucion=$("#hidAsig").val();
	paralelos_distribucion=$("#hidPara").val();
	idSede=$("#hidIdSede").val();
	$('#tablaModulosLabel').hide();
	
	var table="";
	llenarListasActualizar();
	
});
	
	//se muestra el horario al seleccionar un grupo
$("#distribucionesacademicas-id_paralelo_sede").change(function() 
{
  listarHorario(); 
});

//evento del boton de borrar
function borrarDA(obj)
{	
	borrar = "Si";
	
	
}


function listarHorario()
{
		
	var idParalelo = $("#distribucionesacademicas-id_paralelo_sede").val();
	
	//si no tien ningun grupo seleccionado se oculta la tabla
	if(idParalelo =="")
	{
		$('#tablaModulos_wrapper').hide();
		$('#tablaModulosLabel').hide();
		return false;
		
	}
	$.get( "index.php?r=distribuciones-academicas/horario&idParalelo="+idParalelo, 
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


//se obtiene el valor de la celda de dia y bloque
	$('#tablaModulos').on( 'click', 'tbody td', function () 
	{
		
		columna = "";
		fila = "";
		informacion = "";
		
		var dataColumn = table.column( this).data();
		var idx = table.cell( this ).index().row;
		var datafila = table.cells( idx, '' ).render( 'display' );
		
		//saber que dia se la semana escojieron 
		dia = dataColumn[0];
		
		//saber que bloque seleccionaron
		bloque = datafila[0];
		
		//saber que dato tiene la celda
		informacion = table.cell( this ).data();
	
		
		//saber si se borrara la distribucion academica borrar == "Si"
		if (borrar == "Si")
		{
			
			
			swal({
				  title: '¿Esta seguro?',
				  text: "¿Realmente desea borrar la distribución académica?",
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonText:'Si',
				  cancelButtonText: 'No',
				}).then((result) => {
				  if (result.value) 
				  {
						pos  = informacion.indexOf("</actualizar=");
						idDA = informacion.substr(pos+13);
						
						//borrar la DA
						$.get( "index.php?r=distribuciones-academicas/borrar-d-a&bloque="+bloque+"&dia="+dia,
							function( data )
							{
								listarHorario();
							},
						"json");
				  } 
				})
			borrar = "";
			return false
		}
	
		nivel = $("#selSedesNivel").val();
		grupo = $("#distribucionesacademicas-id_paralelo_sede").val();
		aula  = $("#distribucionesacademicas-id_aulas_x_sedes").val();
		asignatura = $("#distribucionesacademicas-id_asignaturas_x_niveles_sedes").val();
		
		fecha_ingreso = $("#distribucionesacademicas-fecha_ingreso").val();
		
		idDocente = $("#distribucionesacademicas-id_perfiles_x_personas_docentes").val();
		
		if (nivel=="" || idDocente=="" || aula==""|| asignatura=="")
		{
			swal("Campos vacios","Debe llenar todo los campos ","info");
		}
		else
		{
			
		idDocente = $("#distribucionesacademicas-id_perfiles_x_personas_docentes").val();
			
			$.post( "index.php?r=distribuciones-academicas/create",
			{
				id_asignaturas_x_niveles_sedes:asignatura,
				id_perfiles_x_personas_docentes:idDocente,
				id_aulas_x_sedes		:aula,
				estado					:1,
				id_paralelo_sede		:grupo,
				fecha_ingreso			:fecha_ingreso,
				informacionCelda		:informacion,
				dia						:dia,
				bloque					:bloque,
			},
				function( data )
				{
					if(data.error == 1)
					{
						alert(data.mensaje);
						return false;
					}
					
					listarHorario();
					
				},
		"json");
			
			
		}
		
	} );
	



function llenarListasActualizar() 
{
	var url = window.location.href; 
	if (url.indexOf('update')!=-1) 
	{	
		$('#selSedesNivel').trigger('change');		
		setTimeout(function()
		{
			$('#distribucionesacademicas-id_paralelo_sede').trigger('change');	
		
		}, 1000);
		
	}
}


/**
 * Funcion de listar asignaturas por niveles sedes
 * 
 * param Parámetro: El onchange del select de niveles
 * return Tipo de retorno: Retorna asignaturas por niveles sedes
 * author : Viviana Rodas
 * exception : No tiene excepciones.
 */
$("#selSedesNivel").change(function(){ 
   
	idSedesNiveles = $("#selSedesNivel").val();
	idSedes = $("#hidIdSede").val();
	
	//llenar asignaturas
	$.get( "index.php?r=distribuciones-academicas/listar-a&idSedesNiveles="+idSedesNiveles, 
				function( data )
				{
					// console.log(data);
					$('#distribucionesacademicas-id_asignaturas_x_niveles_sedes').find('option:not(:first)').remove();
					for( i = 0; i< data.length; i++ ){ 
						
						$("#distribucionesacademicas-id_asignaturas_x_niveles_sedes").append('<option value='+data[i].id+'>'+data[i].descripcion+'</option>');
					}
					 
					 // setTimeout(function(){ 
						if (asignaturas_distribucion != ""){  
							$( "#distribucionesacademicas-id_asignaturas_x_niveles_sedes" ).val(asignaturas_distribucion);
						 }
					// }, 2000);
					 
				},
		"json");
		
		//llenar grupos paralelos
	$.get( "index.php?r=distribuciones-academicas/listar-g&idSedesNiveles="+idSedesNiveles, 
				function( data )
				{
					// console.log(data);
					$('#distribucionesacademicas-id_paralelo_sede').find('option:not(:first)').remove();
					for( i = 0; i< data.length; i++ ){ 
						
						$("#distribucionesacademicas-id_paralelo_sede").append('<option value='+data[i].id+'>'+data[i].descripcion+'</option>');
					}
						if (paralelos_distribucion != ""){ 
							$( "#distribucionesacademicas-id_paralelo_sede" ).val(paralelos_distribucion);
						 }
					 
				},
		"json");
	
	
}); 

/**
 * Funcion de listar las distribucines academicas.
 * 
 * param Parámetro: No recibe parametros
 * return Tipo de retorno: Retorna la lista de distribuciones
 * author : Viviana Rodas
 * exception : No tiene excepciones.
 */



function Abrir_ventana (pagina) {
var opciones="toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=300,height=300,top=85,left=140";
window.open(pagina,"",opciones);
}

