$( document ).ready(function() {
    
	$( "#datosGenerales-tab" ).trigger( "click" );
	$( "#personas-id_municipios" ).trigger( "change" );
	
		llenarPerfilesSelected();
});

/**
* Funcion que pone el select de perfiles en selectes los perfiles que trae
*/
function llenarPerfilesSelected(){
	
	var a = $("#hidSelected").val();
		
	if (a != ""){
		
		var ui = {
			    item: {tallas: a}
			};

			var tallasAux = ui.item.tallas.split(',');

			if (tallasAux.length >= 1) { 

				for (var i = 0; i < tallasAux.length; i++) { 

					// $('#perfiles-id').append('<option value="'+i+'">'+tallasAux[i]+'</option>' );
					// $( "#perfiles-id" ).val(tallasAux[i]);
					$("#perfiles-id option[value='" + tallasAux[i] + "']").prop("selected", true);
				} 

			} 
	}
}

//llenar las comunas segun el municipio que seleccione
$( "#personas-id_municipios" ).change(function() 
{
	
	idMunicipio = $( "#personas-id_municipios" ).val();
	
	if(idMunicipio != "")
	{
		$.get( "index.php?r=personas/comunas&idMunicipio="+idMunicipio,
				function( data )
					{			
						$("#personas-comuna").append(data);
						$("#personas-comuna").val(selectIdcomuna)
						$( "#personas-comuna" ).trigger( "change" );										
					},
			"json");   
	}
});

//llenar los barrios segun la comuna que seleccione
$( "#personas-comuna" ).change(function() 
{
	idComunas = $( "#personas-comuna" ).val();
	alert
	if(idMunicipio != "")
	{
		$.get( "index.php?r=personas/barrios&idComunas="+idComunas,
				function( data )
					{	
						
						$("#personas-id_barrios_veredas").append(data);
						$("#personas-id_barrios_veredas").val(selectIdBarrios);
					},
			"json");   
	}
});



