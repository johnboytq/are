/**********
Versión: 001
Fecha: 27-03-2018
Desarrollador: Edwin Molina Grisales
Descripción: js para sedes
---------------------------------------
**********/


function getPefiles(){
	
	// $( "#plandeaula-id_nivel" ).change( 
		// function()
		// {
			$.get( "index.php?r=participacion-proyectos-maestro/get-perfil&persona="+$( "#participacionproyectosmaestro-participante" ).val(), 
				function( data )
				{
					var options = "";
					
					if(data)
					{
						options += "<option value='"+data.codigo+"'>"+data.descripcion+"</option>";
					}
					
					$( "#participacionproyectosmaestro-tipo" ).html( options );
				},
			"json");
		// }
	// );
};