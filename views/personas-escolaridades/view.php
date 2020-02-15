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
Fecha: Fecha en formato (12-03-2018)
Desarrollador: Viviana Rodas
Descripción: Vista ver detalle de Escolaridades
---------------------------------------
*/

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\Personas;
use app\models\Escolaridades;

/* @var $this yii\web\View */
/* @var $model app\models\PersonasEscolaridades */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Personas Escolaridades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personas-escolaridades-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
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
				'attribute'=>'id_escolaridades',
				'value' => function( $model )
				{
					$escolaridades = Escolaridades::findOne($model->id_escolaridades);
					return $escolaridades ? $escolaridades->descripcion : '';
				},
				
			],
            'ultimo_nivel_cursado',
            'ano_curso',
            'titulacion:boolean',
            'titulo',
            'institucion',
            'id',
        ],
    ]) ?>

</div>
