<?php
if(@$_SESSION['sesion']=="si")
{ 
	// echo $_SESSION['nombre'];
} 
//si no tiene sesion se redirecciona al login
else
{
	echo "<script> window.location=\"index.php?r=site%2Flogin\";</script>";
	die;
}

/**********
Versión: 001
Fecha: 02-03-2018
Desarrollador: Edwin Molina Grisales
Descripción: CRUD de sedes
---------------------------------------
Modificaciones:
Fecha: 08-03-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: se agrega script js que crea los options para comunes una vez se seleccione un municipio
---------------------------------------
Fecha: 07-03-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se agrega select para el campo comunas
---------------------------------------
Fecha: 02-03-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se deja seleccionado por defecto la institución seleccionada que viene de la lista de sedes
---------------------------------------
**********/

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/sedes.js',['depends' => [\yii\web\JqueryAsset::className()]]);

/* @var $this yii\web\View */
/* @var $model app\models\Sedes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sedes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true, 'placeHolder' => 'Digite la descripción' ]) ?>
	
	<?= $form->field($model, 'codigo_dane')->textInput(['maxlength' => true, 'placeHolder' => 'Digite el Codigo Dane']) ?>

    <?= $form->field($model, 'direccion')->textInput(['maxlength' => true, 'placeHolder' => 'Digite la dirección']) ?>
	
	<?= $form->field($model, 'telefonos')->textInput(['maxlength' => true, 'placeHolder' => 'Digite el teléfono' ]) ?>

    <?= $form->field($model, 'area')->textInput(['placeHolder' => 'Digite el área']) ?>

    <?= $form->field($model, 'id_instituciones' )->dropDownList( $instituciones, [ 'prompt' => 'Seleccione...', 'value' => $idInstitucion ] ) ?>

    <?= $form->field($model, 'latitud')->textInput(['placeHolder' => 'Digite la latitud']) ?>

    <?= $form->field($model, 'longitud')->textInput(['placeHolder' => 'Digite la longitud']) ?>

    <?= $form->field($model, 'id_zonificaciones')->dropDownList( $zonificaciones, [ 'prompt' => 'Seleccione...' ] ) ?>

    <?= $form->field($model, 'id_tenencias')->dropDownList( $tenencias, [ 'prompt' => 'Seleccione...' ] ) ?>

    <?= $form->field($model, 'id_modalidades')->dropDownList( $modalidades, [ 'prompt' => 'Seleccione...' ] ) ?>

    <?= $form->field($model, 'id_municipios')->dropDownList( $municipios, [ 'prompt' => 'Seleccione...' ]) ?>

    <?= $form->field($model, 'id_generos_sedes' )->dropDownList( $generosSedes, [ 'prompt' => 'Seleccione...' ] ) ?>

    <?= $form->field($model, 'id_calendarios' )->dropDownList( $calendarios, [ 'prompt' => 'Seleccione...' ] ) ?>

     <?= $form->field($model, 'id_estratos' )->dropDownList( $estratos, [ 'prompt' => 'Seleccione...' ] ) ?>

	<?= $form->field($model, 'id_barrios_veredas' )->dropDownList( $barriosVeredas, [ 'prompt' => 'Seleccione...' ] ) ?>

    <?= $form->field($model, 'sede_principal')->checkbox() ?>

    <?= $form->field($model, 'comuna')->dropDownList( $comunas, [ 'prompt' => 'Seleccione...' ] ) ?>

	<?= $form->field($model, 'estado' )->dropDownList( $estados ) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
	$( "#sedes-id_municipios" ).change( 
		function()
		{
			$.get( "index.php?r=sedes/get-comunas&idMunicipio="+$( this ).val(), 
				function( data )
				{
					console.log(data);
					
					if(data){
						
						var options = "<option value=''>Seleccione...</option>"
						for( var id in data ){
							options += "<option value='"+id+"'>"+data[id]+"</option>";
						}
						
						$( "#sedes-comuna" ).html( options );
					}
				},
			"json");
		}
	);
</script>
