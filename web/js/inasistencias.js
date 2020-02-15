function marcarFalta( cmp, obj ){
	// console.log( cmp );
	// if( $( cmp ).val() == 'asistió' ){
		// $( cmp ).val( 'faltó' );
		// $( cmp ).css({color: "red"});
	// }
	// else{
		// $( cmp ).val( 'asistió' );
		// $( cmp ).css({color: "green"});
	// }
	
	data = {
		id_perfiles_x_personas_estudiantes	: obj.estudiante,
		justificada							: "0",
		id_distribuciones_academicas		: obj.distribucionAcademica,
		fecha								: obj.fecha,
		justificacion						: "",
		estado								: 1,
		fecha_ing							: obj.fechaActual,
	};
	
	// console.log( data );
	 
	$.post(
		"index.php?r=inasistencias/create",
		{ 
			Inasistencias: data ,
		},
		function( data )
		{	 
			console.log( data );
			
			 if( data )
			 {
				 switch( data.error )
				 {
					case 0: 	//Se realizo una falta
						$( cmp ).val( 'faltó' );
						$( cmp ).css({color: "red"});
					break;
					
					case 1: 	//Se realizó una asistencia
						$( cmp ).val( 'asistió' );
						$( cmp ).css({color: "green"});
					break;
					
					case 2: 	//Errores
					break;
				 }
			 }
		},
		"json"
	);
	
}