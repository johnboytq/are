<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\AsignaturasEvaluadas;

$valueAsignaturasEvaluadas = '';
if( !empty( $model->id ) ){
	$valueAsignaturasEvaluadas = AsignaturasEvaluadas::find()
								->innerJoin( 'asignatura_especifica ae', 'ae.id_asignatura_evaluada=asignaturas_evaluadas.id' )
								->where( 'ae.estado=1' )
								->andWhere( 'asignaturas_evaluadas.estado=1' )
								->one();
}
/* @var $this yii\web\View */
/* @var $model app\models\ResultadosPruebasSaberCali */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile(
    '@web/js/resultados-pruebas-saber-cali.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>

<div class="resultados-pruebas-saber-cali-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_institucion')->dropDownList( [ $institucion->id => $institucion->descripcion ] ) ?>
	
    <?= $form->field($model, 'anio')->textInput(['maxlength' => true]) ?>
	
	<div class="form-group">
	
	<label class="control-label" for="pmi-estado">Asignatura evaluada</label>
	
	<?= Html::dropDownList( 'asignaturasEvaluadas', $valueAsignaturasEvaluadas, $asignaturasEvaluadas, [ 
																	'id' => 'asignaturas-evaluadas', 
																	'class' => 'form-control', 
																	'prompt' => 'Seleccione...', 
																] ) ?>
	
	</div>

    <?= $form->field($model, 'id_asignatura_especifica')->dropDownList( $asignaturas, [ 'prompt' => 'Seleccione...', 'options' => $asignaturasData ] ) ?>

    <?= $form->field($model, 'valor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estado')->dropDownList( $estados ) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
