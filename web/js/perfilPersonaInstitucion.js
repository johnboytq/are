/**********
Versión: 001
Fecha: Fecha en formato (26-04-2018)
Desarrollador: Viviana Rodas
Descripción: js Distribuciones academicas
---------------------------------------
*/
$( document ).ready(function() {  
	
	perfilesSelected = $("#hidPerfilSelected").val();
	perfilesPersonasSelected=$("#hidPerfilesPersonasSelected").val();
	modificar=$("#hidModificar").val();
	// idSede=$("#hidIdSede").val();

	//listar(); 
	llenarListasActualizar();




	$( 'div' ).on( 'keydown', '#perfilespersonasinstitucion_id_perfiles_x_persona_chosen input', function(event) {
		if(event.which == 13)
		{
			var info ='';
			filtro = $(this).val();
			if (filtro.length > 3)
			{
				
				idPerfiles = $("#selPerfiles").val();
			
				$.get( "index.php?r=perfiles-personas-institucion/listar-p&idPerfiles="+idPerfiles+"&filtro="+filtro, 
					function( data )
					{
						$('#perfilespersonasinstitucion-id_perfiles_x_persona').find('option:not(:first)').remove();
						for( i = 0; i< data.length; i++ )
						{ 	
							$("#perfilespersonasinstitucion-id_perfiles_x_persona")
							.append('<option value='+data[i].id+'>'+data[i].nombres+'</option>');
							
						}
						 
						if (perfilesPersonasSelected != "")
						{  
							$( "#perfilespersonasinstitucion-id_perfiles_x_persona" ).val(perfilesPersonasSelected);
						}
						$("#perfilespersonasinstitucion-id_perfiles_x_persona").trigger("chosen:updated");
					},'json'
				);
			
			}
		}
	});
	
});

function llenarListasActualizar() 
{
	// if (modificar != ""){
		// $( "#selPerfiles" ).val(perfilesSelected);
	// }
	
	var url = window.location.href; 
	if (url.indexOf('update')!=-1) 
	{
		
		$('#selPerfiles').trigger('change');
		// setTimeout(function(){ llenarListas(); }, 2000);	
	}
}


/**
 * Funcion de listar perfiles por persona
 * 
 * param Parámetro: El onchange del select de perfiles
 * return Tipo de retorno: Retorna los perfiles por persona
 * author : Viviana Rodas
 * exception : No tiene excepciones.
 */
// $("#selPerfiles").change(function(){  
   
	// idPerfiles = $("#selPerfiles").val();
	
	
	// //llenar perfiles por persona
	// $.get( "index.php?r=perfiles-personas-institucion/listar-p&idPerfiles="+idPerfiles+"&filtro=",
				// function( data )
				// {
					// $('#perfilespersonasinstitucion-id_perfiles_x_persona').find('option:not(:first)').remove();
					
					// $("#perfilespersonasinstitucion-id_perfiles_x_persona").append('<option value="dddd">aaaa</option>');
					
					// for( i = 0; i< data.length; i++ )
					// { 	
						// $("#perfilespersonasinstitucion-id_perfiles_x_persona")
						// .append('<option value='+data[i].id+'>'+data[i].nombres+'</option>');
						
					// }
					 
					// if (perfilesPersonasSelected != "")
					// {  
						// $( "#perfilespersonasinstitucion-id_perfiles_x_persona" ).val(perfilesPersonasSelected);
					// }
					// $("#perfilespersonasinstitucion-id_perfiles_x_persona").trigger("chosen:updated");
				// },
		// "json");
		
	
// }); 




