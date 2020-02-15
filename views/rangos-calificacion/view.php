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
Fecha: 13-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de RangosCalificacion
---------------------------------------
Modificaciones:
Fecha: 13-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Cambios en la etiquetas de los botones
No se muestra el id, no el estado
Cambio en la miga de pan
cambio en titulo para que salga el nombre de la institucion
---------------------------------------
**********/
use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\Instituciones;
use app\models\TiposCalificacion;
use yii\helpers\ArrayHelper;

$institucionNombre = new Instituciones();
$institucionNombre = $institucionNombre->find()->where('id='.$model->id_instituciones)->all();
$institucionNombre = ArrayHelper::map($institucionNombre,'id','descripcion');
$institucionNombre = $institucionNombre[$model->id_instituciones];

/* @var $this yii\web\View */
/* @var $model app\models\RangosCalificacion */

$this->title = 'Detalles';
$this->params['breadcrumbs'][] = [
									'label' => 'Rangos Calificaciones', 
									'url' => [
												'index',
												'idInstitucion' => $model->id_instituciones, 
											 ]
								 ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rangos-calificacion-view">

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
            'valor_minimo',
            'valor_maximo',
            'descripcion',	
			[
				'attribute'=>'id_tipo_calificacion',
				'value'=> function ($model)
				{
					$TipoCalificacion = TiposCalificacion::findOne($model->id_tipo_calificacion);
					return $TipoCalificacion ? $TipoCalificacion->descripcion : '';
				},
			],
            [
				'attribute'=>'id_instituciones',
				'value'=> function ($model)
				{
					$institucion = Instituciones::findOne($model->id_instituciones);
					return $institucion ? $institucion->descripcion : '';
				},
			]
			
        ],
    ]) ?>

</div>
