<?php

/**********
Versión: 001
Fecha: 12-07-2018
Desarrollador: Edwin Molina Grisales
Descripción: CRUD PMI
---------------------------------------
**********/

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use nex\chosen\Chosen;

use app\models\SubProcesoEvaluacion;
use app\models\AreaGestion;

$this->registerJsFile(
    '@web/js/pmi.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$valueArea = '';
$valueProcesoEvaluacion = '';

if( !empty( $model->id ) ){
	$valueArea = AreaGestion::find()
								->innerJoin( 'sub_proceso_evaluacion spe', 'spe.id_area_gestion=area_gestion.id' )
								->innerJoin( 'proceso_especifico pe', 'pe.id_sub_proceso=spe.id' )
								->where( 'pe.estado=1' )
								->andWhere( 'spe.estado=1' )
								->one();;
	$valueProcesoEvaluacion = subProcesoEvaluacion::find()
								->innerJoin( 'proceso_especifico pe', 'pe.id_sub_proceso=sub_proceso_evaluacion.id' )
								->where( 'pe.estado=1' )
								->one();
}
	

/* @var $this yii\web\View */
/* @var $model app\models\Pmi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pmi-form">

    <?php $form = ActiveForm::begin(); ?>
    
	<?= $form->field($model, 'id_institucion')->dropDownList( [ $institucion->id => $institucion->descripcion ] ) ?>

    <?= $form->field($model, 'codigo_dane')->textInput(['maxlength' => true, 'value' => $institucion->codigo_dane ] ) ?>

    <?= $form->field($model, 'anio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comuna')->widget(
		Chosen::className(), [
			'items' => $comunas,
			'disableSearch' => 5, // Search input will be disabled while there are fewer than 5 items
			'placeholder' => 'Seleccione...',
			'clientOptions' => [
				'search_contains' => true,
				'single_backstroke_delete' => false,
			],
	]);?>

    <?= $form->field($model, 'zona')->dropDownList( $zonas, [ 'prompt' => 'Seleccione...' ] ) ?>
	
	<div class="form-group">
	
	<label class="control-label" for="pmi-estado">Area de gestión</label>
	
	<?= Html::dropDownList( 'area-gestion', $valueArea, $areasGestion, [ 
																	'id' => 'area-gestion', 
																	'class' => 'form-control', 
																	'prompt' => 'Seleccione...', 
																] ) ?>
	
	</div>
	
	<div class="form-group ">
	
	<label class="control-label" for="pmi-estado">Sub proceso de evaluación</label>
	
	<?= Html::dropDownList( 'sub-proceso-evaluacion', $valueProcesoEvaluacion, $subProcesoEvaluacion, [ 
																					'id' => 'sub-proceso-evaluacion', 
																					'class' => 'form-control', 
																					'prompt' => 'Seleccione...', 
																					'options' => $subProcesoEvaluacionData,
																					] ) ?>
	
	</div>
	
	<?= $form->field($model, 'id_proceso_especifico')->dropDownList( $procesos , [ 'options' => $procesosData, 'prompt' => 'Seleccione...' ]) ?>
	
    <?= $form->field($model, 'valor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estado')->dropDownList( $estados ) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
