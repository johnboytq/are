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
Fecha: 03-03-2018
Desarrollador: Edwin Molina Grisales
Descripción: CRUD de Instituciones
---------------------------------------
Modificaciones:
Fecha: 03-03-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se cambia el boton Inactivar por Eliminar
---------------------------------------
**********/

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\Estados;
use app\models\Sectores;
use app\models\TiposInstituciones;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Instituciones */

$this->title = $model->id." - ".$model->descripcion ;
$this->params['breadcrumbs'][] = ['label' => 'Instituciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instituciones-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro que quiere eliminar la institución '.$model->descripcion.'?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'descripcion',
			[
				'attribute' => 'id_tipos_instituciones',
				'value' => function( $model ){
					$tiposInstituciones = TiposInstituciones::findOne($model->id_tipos_instituciones);
					return $tiposInstituciones ? $tiposInstituciones->descripcion : '';
				},
				'filter' => ArrayHelper::map(TiposInstituciones::find()->all(), 'id', 'descripcion' ),
			],
			[
				'attribute' => 'id_sectores',
				'value' => function( $model ){
					$sectores = Sectores::findOne($model->id_sectores);
					return $sectores ? $sectores->descripcion : '';
				},
				'filter' => ArrayHelper::map(Sectores::find()->all(), 'id', 'descripcion' ),
			],
            'nit',
            [
				'attribute' => 'estado',
				'value' => function( $model ){
					$estados = Estados::findOne($model->estado);
					return $estados ? $estados->descripcion : '';
				},
				'filter' => ArrayHelper::map(Estados::find()->all(), 'id', 'descripcion' ),
			],
            'caracter',
            'especialidad',
            'rector',
            'contacto_rector',
            'correo_electronico_institucional',
            'pagina_web',
            'codigo_dane',
        ],
    ]) ?>

</div>
