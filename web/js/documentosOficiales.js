var consecutivo = 1;

function agregarCampos(){
	
	$.post( 
		"index.php?r=documentos-oficiales/agregar-campos",
		{
			consecutivo : consecutivo,
		},
		function( data ){
			$( "#dvTable" ).append( data );
			
			//oculto el boton eliminar
			$( "#btnEliminar" ).css({display:""});
			
			//agrego las validaciones correspondientes a los campos
			
			$( "#w0" ).yiiActiveForm( 'add', {
				"id":"documentosoficiales-"+consecutivo.toString()+"-id_instituciones",
				"name":"["+consecutivo.toString()+"]id_instituciones",
				"container":".field-documentosoficiales-"+consecutivo.toString()+"-id_instituciones",
				"input":"#documentosoficiales-"+consecutivo.toString()+"-id_instituciones",
				"validate":function (attribute, value, messages, deferred, $form) {
					yii.validation.required(value, messages, {"message":"Institución no puede estar vacío."});
					yii.validation.number(value, messages, {"pattern":/^\s*[+-]?\d+\s*$/,"message":"Institución debe ser un número entero.","skipOnEmpty":1});
				}
			});
			
			$( "#w0" ).yiiActiveForm( 'add', {
				"id":"documentosoficiales-"+consecutivo.toString()+"-id_tipo_documentos",
				"name":"["+consecutivo.toString()+"]id_tipo_documentos",
				"container":".field-documentosoficiales-"+consecutivo.toString()+"-id_tipo_documentos",
				"input":"#documentosoficiales-"+consecutivo.toString()+"-id_tipo_documentos",
				"validate":function (attribute, value, messages, deferred, $form) {
					yii.validation.required(value, messages, {"message":"Tipo de Documento no puede estar vacío."});
					yii.validation.number(value, messages, {"pattern":/^\s*[+-]?\d+\s*$/,"message":"Tipo de Documento debe ser un número entero.","skipOnEmpty":1});
				}
			});
			
			$( "#w0" ).yiiActiveForm( 'add', {
				"id":"documentosoficiales-"+consecutivo.toString()+"-file",
				"name":"["+consecutivo.toString()+"]file",
				"container":".field-documentosoficiales-"+consecutivo.toString()+"-file",
				"input":"#documentosoficiales-"+consecutivo.toString()+"-file",
				"validate":function (attribute, value, messages, deferred, $form) {
					yii.validation.required(value, messages, {"message":"File no puede estar vacío."});
					yii.validation.file(attribute, messages, {"message":"Falló la subida del archivo.","skipOnEmpty":true,"mimeTypes":[],"wrongMimeType":"Sólo se aceptan archivos con los siguientes tipos MIME: .","extensions":[],"wrongExtension":"Sólo se aceptan archivos con las siguientes extensiones: ","maxFiles":1,"tooMany":"Puedes subir como máximo 1 archivo."});
				}
			});
			
			$( "#w0" ).yiiActiveForm( 'add', {
				"id":"documentosoficiales-"+consecutivo.toString()+"-estado",
				"name":"["+consecutivo.toString()+"]estado",
				"container":".field-documentosoficiales-"+consecutivo.toString()+"-estado",
				"input":"#documentosoficiales-"+consecutivo.toString()+"-estado",
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
	
	try{
		
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
	
		setTimeout( function(){
			$( "#w0" ).yiiActiveForm( 'add', {
				"id":"documentosoficiales-0-file",
				"name":"[0]file",
				"container":".field-documentosoficiales-0-file",
				"input":"#documentosoficiales-0-file",
				"validate":function (attribute, value, messages, deferred, $form) {
					yii.validation.required(value, messages, {"message":"File no puede estar vacío."});
					yii.validation.file(attribute, messages, {"message":"Falló la subida del archivo.","skipOnEmpty":true,"mimeTypes":[],"wrongMimeType":"Sólo se aceptan archivos con los siguientes tipos MIME: .","extensions":[],"wrongExtension":"Sólo se aceptan archivos con las siguientes extensiones: ","maxFiles":1,"tooMany":"Puedes subir como máximo 1 archivo."});
				}
			});
		}, 1000 );
	}
	catch(e){}

});