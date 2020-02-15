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

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\Personas;
use app\models\Periodos;
use app\models\Niveles;
use app\models\Asignaturas;
use app\models\Estados;
use app\models\IndicadorDesempeno;

/* @var $this yii\web\View */
/* @var $model app\models\PlanDeAula */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Plan De Aulas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-de-aula-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro que desea eliminar este registro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
				'attribute' => 'id_periodo',
				'value' 	=> function($model){
									$periodo = Periodos::find()->where( 'id='.$model->id_periodo )->one();
									return $periodo ? $periodo->descripcion : '';
							   },
			],
			[
				'attribute' => 'id_nivel',
				'value' 	=> function($model){
									$nivel = Niveles::find()->where( 'id='.$model->id_nivel )->one();
									return $nivel ? $nivel->descripcion : '';
							   },
			],
			[
				'attribute' => 'id_asignatura',
				'value' 	=> function($model){
									$nivel = Asignaturas::find()->where( 'id='.$model->id_asignatura )->one();
									return $nivel ? $nivel->descripcion : '';
							   },
			],
            'actividad',
            'observaciones',
            [
				'attribute' => 'estado',
				'value' 	=> function($model){
									$nivel = Estados::find()->where( 'id='.$model->estado )->one();
									return $nivel ? $nivel->descripcion : '';
							   },
			],
			[
				'attribute' => 'id_indicador_desempeno',
				'value' 	=> function($model){
									$indicadorDesempeno = IndicadorDesempeno::find()->where( 'id='.$model->id_indicador_desempeno )->one();
									return $indicadorDesempeno ? $indicadorDesempeno->descripcion : '';
							   },
			],
			'cognitivo_conocer:boolean', 
			'cognitivo_hacer:boolean', 
			'cognitivo_ser:boolean', 
			'personal:boolean', 
			'social:boolean', 
        ],
    ]) ?>

</div>
