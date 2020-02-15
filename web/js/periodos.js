$( document ).ready(function() {
    
	
	$( "#periodos-fecha_inicio" ).parent()
		.on( 'change', {}, function(){ 
			$( '#periodos-fecha_fin' ).parent().datepicker('setStartDate', $( "#periodos-fecha_inicio" ).val() );
		});
		
	$( "#periodos-fecha_fin" ).parent()
		.on( 'change', {}, function(){ 
			$( '#periodos-fecha_inicio' ).parent().datepicker('setEndDate', $( "#periodos-fecha_fin" ).val() );
		});
	
});