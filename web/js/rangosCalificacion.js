/**********
Versión: 001
Fecha: 17-04-2018
Desarrollador: 
Descripción: js para Apoyo academico
---------------------------------------
Modificaciones:
Fecha: 17-04-2018
Persona encargada: 
Cambios realizados: se habilita el campo 
---------------------------------------
**********/

$(document).ready(function()
{
	
	$(".btn, .btn-success").click(function()
	{
		
		min = $("#rangoscalificacion-valor_minimo").val()*1;
		max = $("#rangoscalificacion-valor_maximo").val()*1;
		
		if(min > max || min == max)
		{
			swal("\"Valor máximo\" debe ser mayor"," ","error");
			return false;
		}
		
	});
});



//cuando se haga blur mirar el valor de valor_minimo, el valor de valor_maximo y mirar so maximo es mayor