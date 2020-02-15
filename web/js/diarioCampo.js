$( document ).ready(function() {
    
	
	// $("#principal").hide();
	
	
		// llenarPerfilesSelected();
});



//llenar las comunas segun el municipio que seleccione
$( "#selFases" ).change(function() 
{
	
	fase = $( "#selFases" ).val();
	
	 if(fase != "")
	 {
		 if(fase == 1){fase=9; titulo="BITACORA FASE I";}
		 else if(fase == 2){fase = 10; titulo="BITACORA FASE II";}
		 else if(fase == 3){fase = 11; titulo="BITACORA FASE III"}
		$.get( "index.php?r=semilleros-tic-diario-de-campo/opciones-ejecucion-diario-campo&idFase="+fase,
				function( data )
					{			
						$("#titulo").html(titulo);
						$("#encabezado").html(data.html);
						$("#contenido").html(data.contenido);
															
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



