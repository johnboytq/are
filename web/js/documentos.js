var consecutivo = 1;

function agregarCampos(){
	
	$.post( 
		"index.php?r=documentos/agregar-campos",
		{
			consecutivo : consecutivo,
		},
		function( data ){
			$( "#dvTable" ).append( data );
			
			//oculto el boton eliminar
			$( "#btnEliminar" ).css({display:""});
			
			//agrego las validaciones correspondientes a los campos
			
			$( "#w0" ).yiiActiveForm( 'add', {
				"id":"documentos-"+consecutivo.toString()+"-id_persona",
				"name":"["+consecutivo.toString()+"]id_persona",
				"container":".field-documentos-"+consecutivo.toString()+"-id_persona",
				"input":"#documentos-"+consecutivo.toString()+"-id_persona",
				"validate":function (attribute, value, messages, deferred, $form) {
					yii.validation.required(value, messages, {"message":"Persona no puede estar vacío."});
					yii.validation.number(value, messages, {"pattern":/^\s*[+-]?\d+\s*$/,"message":"Persona debe ser un número entero.","skipOnEmpty":1});
				}
			});
			
			$( "#w0" ).yiiActiveForm( 'add', {
				"id":"documentos-"+consecutivo.toString()+"-tipo_documento",
				"name":"["+consecutivo.toString()+"]tipo_documento",
				"container":".field-documentos-"+consecutivo.toString()+"-tipo_documento",
				"input":"#documentos-"+consecutivo.toString()+"-tipo_documento",
				"validate":function (attribute, value, messages, deferred, $form) {
					yii.validation.required(value, messages, {"message":"Tipo de Documento no puede estar vacío."});
					yii.validation.number(value, messages, {"pattern":/^\s*[+-]?\d+\s*$/,"message":"Tipo de Documento debe ser un número entero.","skipOnEmpty":1});
				}
			});
			
			$( "#w0" ).yiiActiveForm( 'add', {
				"id":"documentos-"+consecutivo.toString()+"-file",
				"name":"["+consecutivo.toString()+"]file",
				"container":".field-documentos-"+consecutivo.toString()+"-file",
				"input":"#documentos-"+consecutivo.toString()+"-file",
				"validate":function (attribute, value, messages, deferred, $form) {
					yii.validation.file(attribute, messages, {"message":"Falló la subida del archivo.","skipOnEmpty":true,"mimeTypes":[],"wrongMimeType":"Sólo se aceptan archivos con los siguientes tipos MIME: .","extensions":[],"wrongExtension":"Sólo se aceptan archivos con las siguientes extensiones: ","maxFiles":1,"tooMany":"Puedes subir como máximo 1 archivo."});
					}
			});
			
			$( "#w0" ).yiiActiveForm( 'add', {
				"id":"documentos-"+consecutivo.toString()+"-estado",
				"name":"["+consecutivo.toString()+"]estado",
				"container":".field-documentos-"+consecutivo.toString()+"-estado",
				"input":"#documentos-"+consecutivo.toString()+"-estado",
				"validate":function (attribute, value, messages, deferred, $form) {
					yii.validation.required(value, messages, {"message":"Estado no puede estar vacío."});
					yii.validation.number(value, messages, {"pattern":/^\s*[+-]?\d+\s*$/,"message":"Estado debe ser un número entero.","skipOnEmpty":1});
				}
			});
			
			consecutivo++;
		},
		"text"
	);
}

function eliminarCampos(){
	
	var rows = $( "#dvTable div.row" );
	
	rows.eq( rows.length-1 ).remove();
	consecutivo--;
	
	if( consecutivo == 1 )
		$( "#btnEliminar" ).css({display:"none"});
}

$( document ).ready(function(){
	
	//Solo cuando se llama al index
	setTimeout( function(){
		if( $( "[name=guardado]" ).length > 0 ){
			swal({
				text: "Archivos guardadas exitosamente",
				icon: "success",
				button: "Cerrar",
			});
		}
	}, 1000 );
});