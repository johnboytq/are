/**********
Versión: 001
Fecha: 04-04-2018
---------------------------------------
Modificaciones:
Fecha: 04-04-2018
Persona encargada: Edwin Molina Grisales
Se muestra el código de los indicadores y se mejora la carga y mostrada de las notas
---------------------------------------
**********/

$( document ).ready(function(){
	
	//Solo números enteros
	var table = $( "#tbTemas" );
	var inKids = $( "tbody > tr input:text", table );
	
	$( inKids ).keypress(function(e){
			
		var tecla = e.keyCode || e.which;

		//Tecla de retroceso para borrar, siempre la permite
		if ( tecla==8 || tecla == 13 || tecla == 9 ){
			return true;
		}
			
		// Patron de entrada, en este caso solo acepta numeros
		var patron=  /^[0-9]+$/
		tecla_final = String.fromCharCode(tecla);
		return patron.test(tecla_final);
	});
	
})

$( ".content a" ).click(function(){
	 
	// if( idDocente != '' ){
		
		var table = $( "#tbTemas" );
		 
		var temas = $( "tbody > tr", table );

		var data = [];
		 
		temas.each(function(x){

			// inCalificaciones.each(function(y){

				data.push({
					id				: $( "[name=id]", this ).val() == '' ? 0 : $( "[name=id]", this ).val(),
					id_sede			: $( "#sede" ).val(),
					id_tema			: $( "[name=tema]", this ).val()*1,
					ninos			: $( "[name=ninos]", this ).val()*1,
					ninas			: $( "[name=ninas]", this ).val()*1,
					observaciones	: '',
					estado			: 1,
				});
			// });
		});
		
		
		// return;
		$.post(
			"index.php?r=sedes-cobertura/create",
			{ 
				data: data 
			},
			function( data ){
				
				try{
					$( data ).each(function(x){
						$( "[name=id]", temas.eq(x) ).val( this.id );
					});
					
					swal({
						text: "Datos guardadas correctamente",
						icon: "success",
						button: "Cerrar",
					});
				}
				catch(e){ console.log(e);
					swal({
						text: "Hubo un error al guardar los datos",
						icon: "warning",
						button: "Cerrar",
					});
				}
			},
			"json"
		);
	// }
	
	return false;
});
