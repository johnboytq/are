function seleccionarTabla( cmp )
{
	
	$.get( 'index.php?r=poblar-tabla/columnas-por-tabla&tabla='+$( cmp ).val(), function(data){
		
		$( "#pCsvExample").html("");
	  
		if( data.data )
		{
			$( data.data ).each(function(x){
				
				var coma = "";
				
				if( x > 0 )
					coma = ";";

				$( "#pCsvExample").html( $( "#pCsvExample").html() + coma + '"' + data.data[x] +'"' );
			});
			
			$( "#pCsvExample" ).html( $( "#pCsvExample" ).html() + "<br>" + $( "#pCsvExample" ).html()  + "<br>" + $( "#pCsvExample" ).html() + "<br>..." );
			
			
			$( "#dvCampos").html("");
			$( data.data ).each(function(x){
				$( "#dvCampos").append( "<div class=campos>" + x +". "+ data.data[x] + "</div>" );
			});
		}
	  
	}, "json" );
}