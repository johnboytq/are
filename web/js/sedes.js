/**********
Versión: 001
Fecha: 08-03-2018
Desarrollador: Edwin Molina Grisales
Descripción: js para sedes
---------------------------------------
Modificaciones:
Fecha: 08-03-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Al seleccionar un municipio muestra las sedes
---------------------------------------
**********/


$( document ).ready(function() {
	
	$( "#sedes-id_municipios" ).change( 
		function()
		{
			$.get( "index.php?r=sedes/get-comunas&idMunicipio="+$( this ).val(), 
				function( data )
				{
					var options = "<option value=''>Seleccione...</option>";
					
					if(data)
					{	
						for( var id in data )
						{
							options += "<option value='"+id+"'>"+data[id]+"</option>";
						}
					}
					
					$( "#sedes-comuna" ).html( options );
				},
			"json");
		}
	);
});