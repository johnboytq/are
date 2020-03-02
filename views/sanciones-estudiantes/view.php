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

/* @var $this yii\web\View */
/* @var $model app\models\SancionesEstudiantes */

$this->title = "Detalle";
$this->params['breadcrumbs'][] = ['label' => 'Sanciones Estudiantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sanciones-estudiantes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar este elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
				'attribute'=>'id_perfiles_persona',
				'value' => function( $model )
				{
					$id = $model->id_perfiles_persona;
					$connection = Yii::$app->getDb();
					//saber el id de la sede para redicionar al index correctamente
					$command = $connection->createCommand("
					SELECT 
						concat(p.nombres,' ',p.apellidos) as nombre
					FROM 
						personas as p, perfiles_x_personas as pp
					WHERE 
						pp.id_personas  = p.id
					AND 
						pp.id = $id
					");
					$result = $command->queryAll();
					return $result[0]['nombre'];
				},
			
			],
			'fecha',
            'descripcion',			
        ],
    ]) ?>

</div>
