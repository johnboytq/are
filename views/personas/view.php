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
Fecha: (06-03-2018)
Desarrollador: Viviana Rodas
Descripción: Vista de personas
---------------------------------------
Modificaciones:
Fecha: Fecha en formato(08-03-2018)
Persona encargada: Viviana Rodas
Cambios realizados: No se muestra el campo psw en ver detalle



*/

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\Generos;
use app\models\Estados;
use app\models\EstadosCiviles;
use app\models\BarriosVeredas;
use app\models\Municipios;
use app\models\TiposIdentificaciones;

/* @var $this yii\web\View */
/* @var $model app\models\Personas */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Personas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Esta seguro que desea eliminar este elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'usuario',
            // 'psw',
            'identificacion',
            'nombres',
            'apellidos',
            'telefonos',
            'fecha_nacimiento',
            'fecha_registro',
            'correo',
            'domicilio',
            'fecha_ultimo_ingreso',
            'envio_correo:boolean',
			[
				'attribute'=>'id_municipios',
				'value' => function( $model )
				{
					$municipios = Municipios::findOne($model->id_municipios);
					return $municipios ? $municipios->descripcion : '';
				},
				
			],
			[
				'attribute'=>'id_tipos_identificaciones',
				'value' => function( $model )
				{
					$identificaciones = TiposIdentificaciones::findOne($model->id_tipos_identificaciones);
					return $identificaciones ? $identificaciones->descripcion : '';
				},
				
			],
            'latitud',
            'longitud',
			[
				'attribute'=>'id_estados_civiles',
				'value' => function( $model )
				{
					$descripcionEstadosC = EstadosCiviles::findOne($model->id_estados_civiles);
					return $descripcionEstadosC ? $descripcionEstadosC->descripcion : '';
				},
				
			],
			//este es el llamado al modelo generos para poder listar la descricion del genero
            [
				'attribute'=>'id_generos',
				'value' => function( $model )
				{
					$descripcionGeneros = Generos::findOne($model->id_generos);
					return $descripcionGeneros ? $descripcionGeneros->descripcion : '';
				},
				
			],
            'hobbies',
            [
				'attribute' => 'id_barrios_veredas',
				'value' => function( $model )
				{
					$barriosVeredas = BarriosVeredas::findOne( $model->id_barrios_veredas );
					return $barriosVeredas ? $barriosVeredas->descripcion : '';
				},
			],
			[
				'attribute' => 'estado',
				'value' => function( $model )
				{
					$estados = Estados::findOne( $model->estado );
					return $estados ? $estados->descripcion : '';
				},
			],
			'grupo_sanguineo',
			'RH',
				
			
			
        ],
    ]) ?>

</div>
