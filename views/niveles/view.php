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

use app\models\NivelesAcademicos;

/* @var $this yii\web\View */
/* @var $model app\models\Niveles */



/**********
Versión: 001
Fecha: 05-03-2018
Desarrollador: Oscar David Lopez Villa
Descripción: CRUD de Niveles
---------------------------------------
Modificaciones:
Fecha: 05-03-2018
Persona encargada: Oscar David Lopez Villa
Cambios realizados: Se borra el campo ID para evitar que salga en la vista (DetailView::widget)
Cambios realizados: Se asocia el id_niveles_academicos con la tabla niveles_academicos para ver por descripción no por id (DetailView::widget)
------------
**********/

// $this->title = $model->id;
$this->title = "Ver";
$this->params['breadcrumbs'][] = ['label' => 'Niveles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="niveles-view">

    <!--h1>< ?= Html::encode($this->title) ?></h1 -->

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
            'descripcion',
			[
				'attribute'=>'id_niveles_academicos',
				'value' => function( $model )
				{
					$NivelesAcademicos = NivelesAcademicos::findOne($model->id_niveles_academicos);
					return $NivelesAcademicos ? $NivelesAcademicos->descripcion : '';
				},
				
			], 
        ],
    ]) ?>

</div>
