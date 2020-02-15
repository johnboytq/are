<?php

/**********
Versión: 001
Fecha: 2018-08-21
Desarrollador: Edwin Molina Grisales
Descripción: Formulario EJECUCION FASE I
---------------------------------------
**********/

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
Fecha: Fecha en formato (08-03-2018)
Desarrollador: Viviana Rodas
Descripción: Formulario de personas
---------------------------------------
Modificaciones:
Fecha: Fecha en formato(08-03-2018)
Persona encargada: Viviana Rodas
Cambios realizados: Se modifican los campos del formulario, los campos requeridos y ajustes
a otros campos como textarea y fechas
-----------
Fecha: Fecha en formato(19-04-2018)
Persona encargada: Viviana Rodas
Cambios realizados: Se agrega al formulario el campo perfiles select multiple para guardar en la tabla perfiles por persona.
---------------------------------------
Fecha: Fecha en formato(05-06-2018)
Persona encargada: Oscar David Lopez
Cambios realizados: Se agrega al formulario el campo RH y se divide el grupo_sanguineo en rh y grupo_sanguineo
---------------------------------------
**********/


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use app\models\Perfiles;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Personas */
/* @var $form yii\widgets\ActiveForm */

 // //se crea una instancia del modelo perfiles
		// $perfilesTable 		 	= new Perfiles();
		// //se traen los datos de los perfiles
		// $dataPerfiles		 	= $perfilesTable->find()->where( 'estado = 1' )->all();
		// //se guardan los datos en un array
		// $perfiles	 	 	 	= ArrayHelper::map( $dataPerfiles, 'id', 'descripcion' );
		

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/personas.js',['depends' => [\yii\web\JqueryAsset::className()]]);

?>
<!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>-->
	

<div class="personas-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<?php 
	if ($perfilesSelected != ""){
		$perfilesSelected = implode(",",$perfilesSelected);
		// echo $perfilesSelected;
		echo "<input type='hidden' id='hidSelected' name='hidSelected' value='".$perfilesSelected."'>";
	}
	
			/**
 * Metodo para codificar en utf8.
 * 
 * param Parámetro: Recibe la cadena que se va a codificar
 * return Tipo de retorno: Retorna la cadena codificada
 * author : Viviana Rodas
 * exception : No tiene ninguna excepción
 */

	function codificarEnUtf8($fila) {
        $aux;
        foreach ($fila as $value) {
            $aux[] = utf8_encode($value);
        }
        return $aux;
    }
	
	$Identificacion = utf8_encode('Identificación');
	$telefono = utf8_encode('teléfono');
	$ubicacion = utf8_encode('Ubicación');
	$descripcion = utf8_encode('Descripción');
	$grupo_sanguineo = utf8_encode('Grupo Sanguíneo');
	
	?>

	
<!-- tabs de boostrarp para orden del formulario-->
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link" id="datosGenerales-tab" data-toggle="tab" href="#datosGenerales" role="tab" aria-controls="datosGenerales" aria-selected="true" onclick="">Datos generales</a>
 </li>
  <li class="nav-item">
    <a class="nav-link" id="ubicacion-tab" data-toggle="tab" href="#ubicacion" role="tab" aria-controls="ubicacion" aria-selected="false" onclick=""><?php echo $ubicacion ?></a>
  </li>
   <li class="nav-item">
    <a class="nav-link" id="perfiles-tab" data-toggle="tab" href="#perfiles" role="tab" aria-controls="perfiles" aria-selected="false" onclick="">Perfiles</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="hobbies-tab" data-toggle="tab" href="#hobbies" role="tab" aria-controls="hobbies" aria-selected="false" onclick="">Hobbies</a>
  </li>
  
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade" id="datosGenerales" role="tabpanel" aria-labelledby="datosGenerales-tab">
		<br>
		<?= $form->field($model, 'identificacion')->textInput(['maxlength' => true,'placeholder'=> 'Digite la '.$Identificacion.'', 'id' =>'txtIdent']) ?>
		
		<?= $form->field($model, 'id_tipos_identificaciones')->dropDownList($identificaciones, ['prompt'=>'Seleccione...']) ?>

		<?= $form->field($model, 'nombres')->textInput(['maxlength' => true,'placeholder'=> 'Digite el nombre', 'id' =>'txtNombre']) ?>

		<?= $form->field($model, 'apellidos')->textInput(['maxlength' => true,'placeholder'=> 'Digite el apellido', 'id' =>'txtApel']) ?>

		<!--<?= $form->field($model, 'fecha_nacimiento')->textInput(['placeholder'=> 'Digite la fecha de nacimiento', 'id' =>'txtFechaNac']) ?>-->
		
		
		<?= $form->field($model, 'grupo_sanguineo')->DropDownList($arrayGrupoSanguineo,['prompt'=>'Seleccione...'])->label($grupo_sanguineo) ?>
		<?= $form->field($model, 'RH')->DropDownList($arrayRH,['prompt'=>'Seleccione...'])->label("RH") ?>
		<?= $form->field($model, 'fecha_nacimiento')->widget(
    DatePicker::className(), [
        
         // modify template for custom rendering
        'template' => '{addon}{input}',
		    'language' => 'es',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
]);?> 	 		
		
		<?= $form->field($model, 'id_estados_civiles')->dropDownList($estadosCiviles, ['prompt'=>'Seleccione...']) ?>

		<?= $form->field($model, 'correo')->input('email',['placeholder'=> 'Digite el correo', 'id' =>'txtCorreo']) ?>

		<?= $form->field($model, 'id_generos')->dropDownList($generos, ['prompt'=>'Seleccione...']) ?>
		
		<?= $form->field($model, 'telefonos')->textInput(['maxlength' => true,'placeholder'=> 'Digite el '.$telefono.'', 'id' =>'txtTele']) ?>
		
		<?= $form->field($model, 'envio_correo')->checkbox() ?>
		
		<?= $form->field($model, 'estado')->dropDownList($estados, ['prompt'=>'Seleccione...']) ?>
		
		<fieldset>
			<legend align="left">Datos de acceso</legend>
			<?= $form->field($model, 'usuario')->textInput(['maxlength' => true,'placeholder'=> 'Digite el nombre de usuario', 'id' =>'txtUsu']) ?>

			<?php  if ($clave == true) {?>
			<?= $form->field($model, 'psw')->passwordInput(['maxlength' => true,'placeholder'=> 'Digite clave', 'id' =>'txtClave']) ?>
			<?php  } ?>
		</fieldset>
	
  
  </div>
  <div class="tab-pane fade" id="ubicacion" role="tabpanel" aria-labelledby="ubicacion-tab">
		<br>
		<?= $form->field($model, 'id_municipios')->dropDownList($municipios, ['prompt'=>'Seleccione...']) ?>
		
		<?= $form->field($model, 'comuna')->dropDownList([], ['prompt'=>'Seleccione...']) ?>
		
		<?= $form->field($model, 'id_barrios_veredas')->dropDownList([], ['prompt'=>'Seleccione...']) ?>
		
		<?= $form->field($model, 'latitud')->textInput(['placeholder'=> 'Digite la latitud', 'id' =>'txtLat']) ?>

		<?= $form->field($model, 'longitud')->textInput(['placeholder'=> 'Digite la longitud', 'id' =>'txtLon']) ?>
		
		<?= $form->field($model, 'domicilio')->textInput(['maxlength' => true,'placeholder'=> 'Digite el domicilio', 'id' =>'txtDom']) ?>
  </div>
  <div class="tab-pane fade" id="perfiles" role="tabpanel" aria-labelledby="perfiles-tab">
	<br>
	<?= $form->field($perfilesTable, 'id')->dropDownList($perfiles, ['multiple'=>'multiple','size'=>'10'])->label($descripcion) ?>
  </div>
  
  <div class="tab-pane fade" id="hobbies" role="tabpanel" aria-labelledby="hobbies-tab">
	<br>
	<?= $form->field($model, 'hobbies')->textarea(array('rows'=>10,'cols'=>10),['placeholder'=> 'Digite los hobbies', 'id' =>'txtHobb'] ) ?>
  </div>
  
   
</div>
	
	
	
	
	
	
	<!-- Campos de fecha que no se envian desde el formulario se envian con datos de fecha del sistema -->
	<?php $date =  date ( 'Y-m-d H:m:s' )?>
	
   <!-- <?= $form->field($model, 'fecha_ultimo_ingreso')->textInput() ?>

    <?= $form->field($model, 'fecha_registro')->textInput() ?>-->
	
	<?= $form->field($model, 'fecha_ultimo_ingreso')->hiddenInput(['value'=> $date])->label(false)?>
	
	<?= $form->field($model, 'fecha_registro')->hiddenInput(['value'=> $date])->label(false)?>

       

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
