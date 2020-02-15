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
$this->registerJsFile("https://unpkg.com/sweetalert/dist/sweetalert.min.js");

if (@$_GET['save']==1 and $_GET['descripcion'] != "" and $_GET['tipoGrupo'] != "")
{	
$mensaje= "El grupo ".$_GET['tipoGrupo']." ".$_GET['descripcion']." ha sido creado con exito";
	$this->registerJs( <<< EOT_JS_CODE

  swal({
		text: "$mensaje",
		icon: "success",
		button: "Salir",
	});

EOT_JS_CODE
);	
}
/**********
Versión: 001
Fecha: (16-04-2018)
Desarrollador: Viviana Rodas
Descripción: Vista de grupos soporte
---------------------------------------
Modificaciones:
Fecha: 12-06-2018
Persona encargada: Viviana Rodas
Se agrega swal con mensaje de gurdado exitoso, con los parametros que llegan del controlador.
**********/



use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\TiposGruposSoporte;
use app\models\Sedes;
use app\models\Estados;


/* @var $this yii\web\View */
/* @var $model app\models\GruposSoporte */

$this->title = $model->id;
$this->params['breadcrumbs'][] = [
									'label' => 'Grupos Soportes', 
									'url' => [
												'index',
												'idInstitucion' => $idInstitucion, 
												'idSedes' 		=> $idSedes,
											 ]
								 ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grupos-soporte-view">

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
            [
				'attribute'=>'id_tipo_grupos',
				'value' => function( $model )
				{
					$tiposGrupos = TiposGruposSoporte::findOne($model->id_tipo_grupos);
					return $tiposGrupos ? $tiposGrupos->descripcion : '';
				},
				
			],
            'descripcion',
            [
				'attribute'=>'id_sede',
				'value' => function( $model )
				{
					$sedes = Sedes::findOne($model->id_sede);
					return $sedes ? $sedes->descripcion : '';
				},
				
			],
			[
				'attribute'=>'id_jornada_sede',
				'value' => function( $model )
				{
					/**
					* Llenar nombre las jornadas sedes
					*/
					//variable con la conexion a la base de datos 
					$connection = Yii::$app->getDb();
					$command = $connection->createCommand("SELECT sj.id, j.descripcion
															FROM jornadas as j, sedes_jornadas as sj
															WHERE sj.id =$model->id_jornada_sede
															AND j.id = sj.id_jornadas
															");
					$result = $command->queryAll();
								
					return $result[0]['descripcion'];
				},
				
			], 
            'edad_minima',
            'edad_maxima',
            'cantidad_participantes',
            [
				'attribute'=>'id_docentes',
				'value' => function( $model )
				{
					/**
					* Llenar nombre los docentes
					*/
					//variable con la conexion a la base de datos 
					$connection = Yii::$app->getDb();
					$command = $connection->createCommand("select d.id_perfiles_x_personas as id, concat(p.nombres,' ',p.apellidos) as nombres
												from personas as p, perfiles_x_personas as pp, docentes as d, perfiles as pe
												where p.id= pp.id_personas
												and p.estado=1
												and pp.id_perfiles=pe.id
												and pe.id=10
												and pe.estado=1
												and pp.id= d.id_perfiles_x_personas
												and d.id_perfiles_x_personas = $model->id_docentes
															");
					$result = $command->queryAll();
								
					return $result[0]['nombres'];
				},
				
			], 
            'observaciones',
            [
				'attribute' => 'estado',
				'value' => function( $model )
				{
					$estados = Estados::findOne( $model->estado );
					return $estados ? $estados->descripcion : '';
				},
			],
        ],
    ]) ?>

</div>
