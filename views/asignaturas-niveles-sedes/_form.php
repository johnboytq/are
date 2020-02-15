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
Fecha: 27-03-2018
---------------------------------------
Modificaciones:
Fecha: 01-05-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se agrega filtro por AREAS DE ENSEÑANZA al CRUD
---------------------------------------
**********/

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Sedes;
use	yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\AsignaturasNivelesSedes */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/asignaturasNivelesSedes.js',['depends' => [\yii\web\JqueryAsset::className()]]);

?>


<div class="asignaturas-niveles-sedes-form">

    <?php $form = ActiveForm::begin(); ?>
    
	<?php 
		$idSedes = $_SESSION['sede'][0];
		$model1 = new Sedes();
		$model1->id=$idSedes;
		$sedes = Sedes::find()->orderby('descripcion')->AndWhere("id=$idSedes")->all();
		$sedes = ArrayHelper::map($sedes,'id','descripcion');		
		echo $form->field($model1, 'descripcion')->dropDownList( $sedes, ['onchange'=>'llenarListas()','options' => [$model1['id'] => ['selected' => 'selected']]] )->label('Sedes');
		
    ?>
		        

	<?= $form->field($model, 'id_sedes_niveles')->dropDownList([])->label('Niveles') ?>
	
	<div class="form-group field-asignaturasnivelessedes-id_sedes_niveles">
		<label class="control-label">Areas de enseñanza</label>
		<?= HTML::dropDownList( "areas", "", [],["class"=>"form-control",'onchange'=>'llenarListaAsignatura()' ] ) ?>
	</div>
	
    <?= $form->field($model, 'id_asignaturas')->dropDownList([]) ?>

    <?= $form->field($model, 'intensidad')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
