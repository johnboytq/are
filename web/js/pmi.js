$( "#area-gestion" ).change(function(){
	$( "#sub-proceso-evaluacion option" )
		.css({
				disabled:true,
				display:'none',
		});
	$( "#sub-proceso-evaluacion" ).val('');
	$( "#pmi-id_proceso_especifico" ).val('');
		
	$( "#sub-proceso-evaluacion option[data-area="+$( "#area-gestion" ).val()+"]" )
		.css({
				disabled:false,
				display:'',
		});
});

$( "#sub-proceso-evaluacion" ).change(function(){
	$( "#pmi-id_proceso_especifico option" )
		.css({
				disabled:true,
				display:'none',
		});
		
	$( "#pmi-id_proceso_especifico" ).val('');	
		
	$( "#pmi-id_proceso_especifico option[data-sub-proceso="+$( "#sub-proceso-evaluacion" ).val()+"]" )
		.css({
				disabled:false,
				display:'',
		});
});