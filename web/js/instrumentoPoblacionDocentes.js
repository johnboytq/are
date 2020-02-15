

$( document ).ready(function(){
	
	var institucion = $( "#instrumentopoblaciondocentes-id_institucion" );
	var sedes 		= $( "#instrumentopoblaciondocentes-id_sede" );
	var docentes	= $( "#instrumentopoblaciondocentes-id_persona" );
	var asignaturas	= $( "#instrumentopoblaciondocentes-id_asignaturas_niveles_sedes" );
	var niveles		= $( "#instrumentopoblaciondocentes-id_niveles" );
	var profesion	= $( "#instrumentopoblaciondocentes-profesion" );
	var ultimonivel = $( "#instrumentopoblaciondocentes-ultimo_nivel" );
	var wform		= $( "#w0" );
	
	
	function mostrarSede(){
		try{
			$.post(
				"index.php?r=instrumento-poblacion-docentes/sede",
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
				"index.php?r=instrumento-poblacion-docentes/niveles-por-sedes-por-docente",
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
	
	profesion.change(function(){
		mostrarFases();
	});
	
	ultimonivel.change(function(){
		mostrarFases();
	});
	
	asignaturas.change(function(){
		
		// if( $.trim( profesion.val() ) == '' && $.trim( ultimonivel.val() ) == '' ){
		
			try{
				
				$.get(
					"index.php?r=instrumento-poblacion-docentes/data-poblacion",
					{
						institucion	: institucion.val(),
						sede		: sedes.val(),
						docente		: docentes.val(),
						asignatura	: asignaturas.val(),
						nivel		: niveles.val(),
					},
					function( data ){
						try{
							
							// if( $.trim( profesion.val() ) == '' ){
								profesion.val( data['profesion'] );
							// }
							
							// if( $.trim( ultimonivel.val() ) == '' ){
								ultimonivel.val( data['ultimo_nivel'] )
							// }
							
							mostrarFases();
						}
						catch(e){
							mostrarFases();
						}
					},
					"json"
				);
			}
			catch(e){
				mostrarFases();
			}
		// }
	});
	
	niveles.change(function(){
		
		asignaturas.html('');
		asignaturas.val('');
		asignaturas.trigger("chosen:updated");
		
		try{
			$.get(
				"index.php?r=instrumento-poblacion-docentes/asignaturas-por-niveles-sedes-por-docente",
				{
					institucion	:	institucion.val(),
					sede		:	sedes.val(),
					docente		:	docentes.val(),
					nivel		:	niveles.val(),
				},
				function( data ){
					
					try{
						asignaturas.html('');
						asignaturas.append( "<option>Seleccione...</option>" );
						for( var x in data["asignaturas"] ){
							asignaturas.append( "<option value='"+x+"'>"+data["asignaturas"][x]+"</option>" );
						}
						
						asignaturas.trigger("chosen:updated");
						mostrarFases();
					}
					catch(e){
						console.log(e);
						mostrarFases();
					}
				},
				"json",
			);
		}
		catch(e){
			mostrarFases();
		}
		
	});
	
	docentes.change(function(){
		try{
			
			$( "#dv-estudiante" ).html( '' );
			$( "#dv-fases" ).html( '' );
			
			niveles.html('');
			niveles.val('');
			niveles.trigger("chosen:updated");
			
			asignaturas.html('');
			asignaturas.val('');
			asignaturas.trigger("chosen:updated");
			
			if( docentes.val() != '' ){
			
				$.post(
					"index.php?r=instrumento-poblacion-docentes/docentes",
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
		
		asignaturas.html('');
		asignaturas.val('');
		asignaturas.trigger("chosen:updated");
		
		try{
			$.get(
				"index.php?r=instrumento-poblacion-docentes/docentes-por-institucion",
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
		
		niveles.html('');
		niveles.val('');
		niveles.trigger("chosen:updated");
		
		asignaturas.html('');
		asignaturas.val('');
		asignaturas.trigger("chosen:updated");
		
		ultimonivel.val( '' );
		ultimonivel.change();
		profesion.val( '' );
		profesion.change();
		 
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
		
		var val = true;
		$('#w0 [id^=instrumentopoblaciondocentes-]').each(function(x){
			$( "#w0" ).yiiActiveForm( 'validateAttribute', this.id );
			
			if( $( ".field-"+this.id ).hasClass( 'has-error' ) ){
				val = false;
			}
		});
		
		if( institucion.val() && sedes.val() && docentes.val() && niveles.val() && asignaturas.val() && profesion.val() && ultimonivel.val() ){
		
			$.post(
				"index.php?r=instrumento-poblacion-docentes/guardar",
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
		}
	});
	
	function mostrarFases(){
		
		$( "#dv-fases" ).html( '' );
		
		if( institucion.val() && sedes.val() && docentes.val() && niveles.val() && asignaturas.val() ){
			
			$.post(
				"index.php?r=instrumento-poblacion-docentes/view-fases",
				{
					institucion	: institucion.val(),
					sede		: sedes.val(),
					docente		: docentes.val(),
					asignatura	: asignaturas.val(),
					nivel		: niveles.val(),
				},
				function( data ){
					// console.log(data);
					$( "#dv-fases" ).html( data );
					
					$( ".panel-body" ).each(function(){
	
						var spanTotal 	= $( "[total]", this );
						var inputs		= $( "input:text", this );
						var _self = this;
						
						function calcularTotal(){
							
							var sum = 0;
							
							inputs.each(function(){
								sum += $( this ).val()*1;
							});
							
							spanTotal.html( sum );
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