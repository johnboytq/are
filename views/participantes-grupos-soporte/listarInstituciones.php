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
Fecha: 06-03-2018
Desarrollador: Oscar David lopez 
Descripción: CRUD de participantes-grupos-soporte
---------------------------------------

**********/


use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\TiposGruposSoporte;
use app\models\GruposSoporte;
use app\models\Jornadas;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Participantes grupos soporte';
$this->params['breadcrumbs'][] = $this->title;



$institucionesTable	 		= new TiposGruposSoporte();
$queryTiposGruposSoporte  	= $institucionesTable->find()->orderby('descripcion')->where('estado=1');
$dataTiposGruposSoporte	 	= $queryTiposGruposSoporte->all();
$tiposGruposSoporte		 		= ArrayHelper::map( $dataTiposGruposSoporte, 'id', 'descripcion' );

$idSedes = $_SESSION['sede'][0];

$connection = Yii::$app->getDb();

$command = $connection->createCommand("
SELECT sj.id, j.descripcion
	FROM jornadas as j, sedes_jornadas as sj
	WHERE sj.id_jornadas =j.id
	AND sj.id_sedes = $idSedes
	AND j.estado = 1
");
$result = $command->queryAll();
$jornadas = array();
		foreach ($result as $r)
		{
			$jornadas[$r['id']]= $r['descripcion'];
		}

$optionsTiposGruposSoporte = array( 
							'prompt' 	=> 'Seleccione...', 
							'id'	 	=> 'TiposGruposSoporte', 
							'name'	 	=> 'TiposGruposSoporte',
							'value'	 	=> $TiposGruposSoporte == 0 ? '' : $TiposGruposSoporte,
							'onChange'	=> '$( "#idGruposSoporte" ).val(\'\'); this.form.submit(); ',
						);




$GruposSoporte = [];


if( $TiposGruposSoporte > 0 and $idJornadas > 0){
	
	//Obterniendo los datos necesarios para GruposSoporte						
	$GruposSoporteTable	 		= new GruposSoporte();
	$queryGruposSoporte	 		= $GruposSoporteTable->find()->orderby('descripcion')->where('estado=1');
	$queryGruposSoporte->andWhere( 'id_tipo_grupos='.$TiposGruposSoporte );
	$queryGruposSoporte->andWhere( 'id_jornada_sede='.$idJornadas );
	$dataGruposSoporte	 		= $queryGruposSoporte->all();
	$GruposSoporte		 		= ArrayHelper::map( $dataGruposSoporte, 'id', 'descripcion' );
}

//opciones para el select GruposSoporte
$optionsGruposSoporte = array( 
					'prompt' 	=> 'Seleccione...', 
					'id'	 	=> 'idGruposSoporte', 
					'name'	 	=> 'idGruposSoporte',
					'value'	 	=> $idGruposSoporte == 0 ? '' : $idGruposSoporte,
					'onChange'	=> '$( "#idGruposSoporte" ).val(); this.form.submit(); ',
				);
				
$optionsjornadas = array( 
					'prompt' 	=> 'Seleccione...', 
					'id'	 	=> 'idJornadas', 
					'name'	 	=> 'idJornadas',
					'value'	 	=> $idJornadas == 0 ? '' : $idJornadas,
					'onChange'	=> '$( "#idJornadas" ).val(); this.form.submit(); ',
				);

?>
<div class="GruposSoporte-index">

    <h1><?= Html::encode($this->title) ?></h1>
	
	<?php $form = ActiveForm::begin([
		'action' => 'index.php?r=participantes-grupos-soporte/index', 
		'method' => 'get',
	]); ?>
	
	<?= $form->field($institucionesTable, 'id')->dropDownList( $jornadas, $optionsjornadas )->label('Jornadas') ?>
	
	<?= $form->field($institucionesTable, 'id')->dropDownList( $tiposGruposSoporte, $optionsTiposGruposSoporte )->label('Tipos Grupos Soporte') ?>
	
	<?= $form->field($institucionesTable, 'id')->dropDownList( $GruposSoporte, $optionsGruposSoporte )->label('Grupos Soporte') ?>
	
	
	<?php $form = ActiveForm::end(); ?>
	
</div>