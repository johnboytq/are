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
Fecha: 06-03-2018
Desarrollador: Edwin Molina Grisales
Descripción: CRUD de sedes-jornadas
---------------------------------------
Modificaciones:
Fecha: 06-03-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: - Se lista las instituciones y las sedes y luego de seleccionar ambas se llama a la vista index por el controlador
---------------------------------------
**********/


use yii\helpers\Html;
use yii\widgets\ActiveForm;


use app\models\Instituciones;
use app\models\Sedes;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Docente por Institucion';
$this->params['breadcrumbs'][] = $this->title;


//Obterniendo los datos necsarios para las instituciones
$institucionesTable	 = new Instituciones();
$queryInstituciones  = $institucionesTable->find()->orderby('descripcion')->where('estado=1');
$dataInstituciones	 = $queryInstituciones->all();
$instituciones		 = ArrayHelper::map( $dataInstituciones, 'id', 'descripcion' );

//Opciones para el select instituciones
$optionsInstituciones = array( 
							'prompt' 	=> 'Seleccione...', 
							'id'	 	=> 'idInstitucion', 
							'name'	 	=> 'idInstitucion',
							'value'	 	=> $idInstitucion == 0 ? '' : $idInstitucion,
							'onchange'	=> 'this.form.submit();'
						);

?>
<div class="sedes-index">

    <h1><?= Html::encode($this->title) ?></h1>
	
	<?php $form = ActiveForm::begin([
		'action' => 'index.php?r=docente-institucion/index', 
		'method' => 'get',
	]); ?>
	
	<?= $form->field($institucionesTable, 'id')->dropDownList( $instituciones, $optionsInstituciones )->label('Instituciones') ?>
	
	
	<?php $form = ActiveForm::end(); ?>
	
</div>