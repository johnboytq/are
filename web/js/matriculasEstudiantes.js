/**********
Versión: 001
Fecha: Fecha en formato (15-03-2018)
Desarrollador: Viviana Rodas
Descripción: js Distribuciones academicas
---------------------------------------
*/
$( document ).ready(function() {
    
	
	//listar(); 
	llenarListasActualizar();	
	
});

function llenarListasActualizar() 
{
	var url = window.location.href; 
	if (url.indexOf('update')!=-1) 
	{
		
		$('#selSedesNivel').trigger('change');
		setTimeout(function(){  }, 2000);	
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
	$.get( "index.php?r=estudiantes/listar-paralelos-sedes&idNivel="+idSedesNiveles+"&idSede="+idSede, 
				function( data )
				{
					$("#estudiantes-id_paralelos").html(data);
					$("#estudiantes-id_paralelos").val(idParalelos);
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



function listar(){
	
	
	
	$.get( "index.php?r=distribuciones-academicas/listar&idMunicipio=1006", 
				function( data )
				{
					alert(data);
					
				},
		"json");

}

