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


$( document ).ready(function() 
{
	//se oculta la caja de texto de numero de dias incapacidad al cargar la pagina 
	$("[for='apoyoacademico-no_dias_incapaciad']").hide();
	$("#apoyoacademico-no_dias_incapaciad").hide();	
	
	$("#apoyoacademico-incapacidad").click(function() 
	{				 
        if($("#apoyoacademico-incapacidad").is(':checked')) 
		{ 
			//se muestra la caja de texto de numero de dias incapacidad si el checkbox es checked
			$("[for='apoyoacademico-no_dias_incapaciad']").show();
			$("#apoyoacademico-no_dias_incapaciad").show();
		}
		else 
		{
			$("[for='apoyoacademico-no_dias_incapaciad']").css("display", "none");
			$("#apoyoacademico-no_dias_incapaciad").hide();
			$("#apoyoacademico-no_dias_incapaciad").val("");
			
			
		}
    });  
	
});

$( "#datatables_w0" ).click(function() {
  alert( "Handler for .click() called." );
});
