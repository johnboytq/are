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
Descripción: CRUD de Rangos-Calificaciones
---------------------------------------
Modificaciones:
Fecha: 05-03-2018
Persona encargada: Oscar David Lopez Villa
Cambios realizados: Se borra ID que aparecía sobre el select de instituciones
---------------------------------------
Fecha: 02-03-2018
Persona encargada: Oscar David Lopez Villa
Cambios realizados: Lista las instituciones activas y despues de seleccionar la institucion redirecciona la 
lista de sedes de dicha institucion
---------------------------------------
**********/

use yii\helpers\Html;
use yii\widgets\ActiveForm;


use app\models\Instituciones;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'INSTITUCIONES';
$this->params['breadcrumbs'][] = $this->title;



$institucionesTable	 = new Instituciones();
$dataInstituciones	 = $institucionesTable->find()->orderby('descripcion')->where('estado=1')->all();
$instituciones		 = ArrayHelper::map( $dataInstituciones, 'id', 'descripcion' );

?>
<div class="sedes-index">

    <h1><?= Html::encode($this->title) ?></h1>
	
	<?php $form = ActiveForm::begin([
		'action' => 'index.php?r=rangos-calificacion/index', 
		'method' => 'get',
	]); ?>
	
	<?= $form->field($institucionesTable, 'id')->dropDownList( $instituciones, [ 'prompt' => 'Seleccione...', 'id'=>'idInstitucion', 'name'=>'idInstitucion', 'onchange' => 'this.form.submit();' ] )->label('') ?> <!-- Cambio la palabra ID por '' para que no se vea --!>
	
	
	<?php $form = ActiveForm::end(); ?>
	
</div>