

$( document ).ready(function(){
	
	var institucion = $( "#estudiantesoperativo-id_institucion" );
	var sedes 		= $( "#estudiantesoperativo-id_sede" );
	var docentes	= $( "#estudiantesoperativo-id_profesional" );
	var niveles		= $( "#estudiantesoperativo-id_nivel" );
	var wform		= $( "#w0" );
	
	
	function mostrarSede(){
		try{
			$.post(
				"index.php?r=estudiantes-operativo/sede",
				{
					sede		:	sedes.val(),
					institucion	:	institucion.val(),
				},
				function( data ){
					
					try{
						$( "#dv-institucion-sede" ).html( data );
					}
					catch(e){
						console.log(e);
					}
				},
			);
		}
		catch(e){
			mostrarFases();
		}
	}
	
	function nivelesPorSedesPorDocente(){
		
		try{
			$.get(
				"index.php?r=estudiantes-operativo/niveles-por-sedes-por-docente",
				{
					institucion	:	institucion.val(),
					sede		:	sedes.val(),
					docente		:	docentes.val(),
				},
				function( data ){
					
					try{
						niveles.html('');
						niveles.append( "<option>Seleccione...</option>" );
						for( var x in data["niveles"] ){
							niveles.append( "<option value='"+x+"'>"+data["niveles"][x]+"</option>" );
						}
						
						niveles.trigger("chosen:updated");
					}
					catch(e){
						console.log(e);
					}
				},
				"json",
			);
		}
		catch(e){
			mostrarFases();
		}
		
	}
	
	niveles.change(function(){
		mostrarFases();
	});
	
	docentes.change(function(){
		try{
			
			$( "#dv-estudiante" ).html( '' );
			$( "#dv-fases" ).html( '' );
			
			niveles.html('');
			niveles.val('');
			niveles.trigger("chosen:updated");
			
			if( docentes.val() != '' ){
			
				$.post(
					"index.php?r=estudiantes-operativo/docentes",
					{
						docente	:	docentes.val(),
						sede	:	sedes.val(),
						nivel	:	niveles.val(),
					},
					function( data ){
						
						try{
							$( "#dv-estudiante" ).html( data );
						}
						catch(e){
							console.log(e);
						}
						
						nivelesPorSedesPorDocente();
						mostrarFases();
					},
				);
			}
			else{
				mostrarFases();
			}
		}
		catch(e){
			mostrarFases();
		}
	});
	
	sedes.change(function(){
		
		$( "#dv-estudiante" ).html( '' );
		docentes.html('');
		docentes.val('');
		docentes.trigger("chosen:updated");
		$( "#dv-institucion-sede" ).html( '' );
		$( "#dv-fases" ).html( '' );
		
		niveles.html('');
		niveles.val('');
		niveles.trigger("chosen:updated");
		
		try{
			$.get(
				"index.php?r=estudiantes-operativo/docentes-por-institucion",
				{
					institucion:	institucion.val(),
				},
				function( data ){
					
					try{
						docentes.html('');
						docentes.append( "<option>Seleccione...</option>" );
						for( var x in data ){
							docentes.append( "<option value='"+data[x].id+"'>"+data[x].identificacion+" - "+data[x].nombres+" "+data[x].apellidos+"</option>" );
						}
						
						docentes.trigger("chosen:updated");
						
						mostrarSede();
					}
					catch(e){
						console.log(e);
					}
					
					mostrarFases();
				},
				"json",
			);
		}
		catch(e){
			mostrarFases();
		}
	});
	
	institucion.change(function(){
		
		$( "#dv-estudiante" ).html( '' );
		$( "#dv-fases" ).html( '' );
		sedes.html('');
		sedes.trigger("chosen:updated");
		docentes.val('');
		docentes.trigger("chosen:updated");
		$( "#dv-institucion-sede" ).html( '' );
		
		try{
			$.get(
				"index.php?r=sedes/sedes",
				{
					idInstitucion:	institucion.val(),
				},
				function( data ){
					
					try{
						sedes.html('');
						sedes.append( "<option>Seleccione...</option>" );
						for( var x in data ){
							sedes.append( "<option value='"+x+"'>"+data[x]+"</option>" );
						}
						
						sedes.trigger("chosen:updated");
					}
					catch(e){
						console.log(e);
					}
					
					mostrarFases();
				},
				"json",
			);
		}
		catch(e){
			mostrarFases();
		}
		
	});

	$( "#bt-guardar" ).click(function(){
		$.post(
			"index.php?r=estudiantes-operativo/guardar",
			$( "#w0" ).serialize(),
			function( data ){
				// $( "#dv-fases" ).html( data );
				
				if( data['error'] == 0 ){
					
					swal({
						text: "Registros guardados correctamente",
						icon: "success",
						button: "Cerrar",
					});
				}
				else{
					swal({
						text: "Hubo un error al guardar los datos",
						icon: "success",
						button: "Cerrar",
					});
				}
			},
			"json",
		);
	});
	
	function mostrarFases(){
		
		$( "#dv-fases" ).html( '' );
		
		if( institucion.val() && sedes.val() && docentes.val() && niveles.val() ){
			
			$.post(
				"index.php?r=estudiantes-operativo/view-fases",
				{
					institucion	: institucion.val(),
					sede		: sedes.val(),
					docente		: docentes.val(),
					nivel		: niveles.val(),
				},
				function( data ){
					// console.log(data);
					$( "#dv-fases" ).html( data );
					
					$( ".panel-body" ).each(function(){
	
						var spanTotal 	= $( "[total]", this );
						var inputs		= $( "input:text[id$=asistentes]", this );
						var _self = this;
						
						function calcularTotal(){
							
							var sum = 0;
							
							inputs.each(function(){
								sum += $( this ).val()*1;
							});
							
							spanTotal.html( sum/inputs.length );
						}
						
						inputs
							.change(function(){
								calcularTotal();
							})
							.keyup(function (){
								this.value = (this.value + '').replace(/[^0-9]/g, '');
							});
						
						calcularTotal();
					});

				},
			);
		}
	}
});