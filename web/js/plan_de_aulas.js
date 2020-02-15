/**********
Versión: 001
Fecha: 27-03-2018
Desarrollador: Edwin Molina Grisales
Descripción: js para sedes
---------------------------------------
Modificaciones:
Fecha: 27-03-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Al seleccionar un municipio muestra las sedes
---------------------------------------
**********/


$( document ).ready(function() {
	
	$( "#plandeaula-id_nivel" ).change( 
		function()
		{
			$.get( "index.php?r=asignaturas-niveles-sedes/asignaturas-x-niveles-sedes&idNivel="+$( this ).val(), 
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
					
					$( "#plandeaula-id_asignatura" ).html( options );
				},
			"json");
		}
	);
	
	
	

	
	
});



