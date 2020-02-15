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
use app\models\TiposDiscapacidades;

/* @var $this yii\web\View */
/* @var $model app\models\PersonasDiscapacidades */

$this->title = $model->id_personas;
$this->params['breadcrumbs'][] = ['label' => 'Personas Discapacidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personas-discapacidades-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id_personas' => $model->id_personas, 'id_tipos_discapacidades' => $model->id_tipos_discapacidades], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id_personas' => $model->id_personas, 'id_tipos_discapacidades' => $model->id_tipos_discapacidades], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Esta seguro de eleminar este ítem?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
				'attribute'=>'id_personas',
				'value' => function( $model )
				{
					$personas = Personas::findOne($model->id_personas);
					return $personas ? $personas->nombres : '';
				},
				
			],
            [
				'attribute'=>'id_tipos_discapacidades',
				'value' => function( $model )
				{
					$discapacidades = TiposDiscapacidades::findOne($model->id_tipos_discapacidades);
					return $discapacidades ? $discapacidades->descripcion : '';
				},
				
			],
            'descripcion:ntext',
            'alergico',
        ],
    ]) ?>

</div>
