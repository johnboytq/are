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

use yii\helpers\Url;
use app\models\Estados;
use app\models\Personas;
use app\models\TiposDocumentos;

/* @var $this yii\web\View */
/* @var $model app\models\Documentos */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documentos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro que quieres eliminar este registro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [ 
				'attribute' => 'ruta' ,
				'format' 	=> 'raw' ,
				'value'		=> function( $model ){
					return Html::a( "Ver archivo", Url::to( "@web/".$model->ruta , true), [ "target"=>"_blank" ] );
				},
			],
            [
				'attribute' => 'id_persona',
				'value' 	=> function( $model ){
					$persona = Personas::findOne( $model->id_persona );
					return $persona ? $persona->nombres." ".$persona->apellidos: '' ;
				},
			],
            [
				'attribute' => 'tipo_documento',
				'value' 	=> function( $model ){
					
					$tipoDocumento = TiposDocumentos::findOne( $model->tipo_documento );
					return $tipoDocumento ? $tipoDocumento->descripcion : '' ;
				},
			],
            [ 
				'attribute' => 'estado' ,
				'value' 	=> function( $model ){
					$estado = Estados::findOne( $model->estado );
					return $estado ? $estado->descripcion: '' ;
				} ,
			],
        ],
    ]) ?>

</div>
