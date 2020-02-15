/**********
Versión: 001
Fecha: Fecha en formato (27-04-2018)
Desarrollador: Oscar David lopez
Descripción: Horario docente 
---------------------------------------

*/

$( document ).ready(function() {
    
	
	
	
});
	
	//se muestra el horario al seleccionar un docente
$(".btn-success").click(function() 
{
	var url = window.location.href;
	//saber si se guarda desde el update
	if (url.indexOf('update')!=-1) 
	{	
		cantidaPonderacion(idPonderacion);
	}
	
	if (url.indexOf('create')!=-1) 
	{
		cantidaPonderacion(0);
	}
  
// return false;  
});


function cantidaPonderacion(idPonderacion){
	
	
	
	ponderacion = $("#ponderacionresultados-calificacion");
	idSede = $("#ponderacionresultados-id_sede").val();
	
	$.get( "index.php?r=ponderacion-resultados/cantidad-ponderacion&idSede="+idSede+"&ponderacion="+ponderacion.val()+"&idPonderacion="+idPonderacion, 
				function( data )
				{
					if (data.error==1)
					{
						ponderacion.val("");
						alert("la ponderacion es mayor al 100%");
						return false;
					}
				},
		"json");
}
