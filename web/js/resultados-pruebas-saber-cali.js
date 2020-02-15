$( "#asignaturas-evaluadas" ).change(function(){
	
	//Se revisa los modelos para saber que id tomar
	var model = 'resultadospruebassabercali'
	if( $( "[id^=resultadospruebassaberie]" ).length > 0 ){
		model = 'resultadospruebassaberie';
	}
	
	$( "#"+model+"-id_asignatura_especifica option" )
		.css({
				disabled:true,
				display:'none',
		});
		
	$( "#"+model+"-id_asignatura_especifica" ).val('');
		
	$( "#"+model+"-id_asignatura_especifica option[data-evaluada="+$( "#asignaturas-evaluadas" ).val()+"]" )
		.css({
				disabled:false,
				display:'',
		});
});
