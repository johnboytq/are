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
use app\models\Escalafones;
use app\models\Estados;

/* @var $this yii\web\View */
/* @var $model app\models\Docentes */

$this->title = $model->id_perfiles_x_personas;
$this->params['breadcrumbs'][] = ['label' => 'Docentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docentes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id_perfiles_x_personas], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id_perfiles_x_personas], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
			[
				'attribute' => 'id_perfiles_x_personas',
				'value' => function( $model ){
								
								// $personas = Personas::findOne($model->id_perfiles_x_personas);
								$personas = Personas::find()
															->innerJoin( 'perfiles_x_personas pf', 'personas.id=pf.id_personas' )
															->innerJoin( 'docentes d', 'pf.id=d.id_perfiles_x_personas' )
															->where( 'pf.id='.$model->id_perfiles_x_personas )->one();
								// echo "--------<br><br><pre>"; var_dump($personas); echo "</pre>";
								return $personas ? $personas->nombres." ".$personas->apellidos: '';
							},
			],
			[
				'attribute' => 'id_escalafones',
				'value' => function( $model ){
					$escalafones = Escalafones::findOne($model->id_escalafones);
					return $escalafones? $escalafones->descripcion : '';
				},
			],
			'Antiguedad',
			[
				'attribute' => 'estado',
				'value' => function( $model ){
					$estado = Estados::findOne($model->estado);
					return $estado? $estado->descripcion : '';
				},
			],
        ],
    ]) ?>

</div>
