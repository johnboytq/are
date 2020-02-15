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
use yii\grid\GridView;
use fedemotta\datatables\DataTables;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ParticipantesGruposSoporteBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Participantes Grupos Soportes';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="participantes-grupos-soporte-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- cupos disponibles -->
 <?= DataTables::widget([
        'dataProvider' => $provider,
		'clientOptions' => [
		'language'=>[
                'url' => '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json',
            ],
		"lengthMenu"=> [[20,-1], [20,Yii::t('app',"All")]],
		"info"=>false,
		"responsive"=>true,
		 "dom"=> 'lfTrtip',
		 "tableTools"=>[
			 "aButtons"=> [  
				// [
				// "sExtends"=> "copy",
				// "sButtonText"=> Yii::t('app',"Copiar")
				// ],
				// [
				// "sExtends"=> "csv",
				// "sButtonText"=> Yii::t('app',"CSV")
				// ],
				// [
				// "sExtends"=> "xls",
				// "oSelectorOpts"=> ["page"=> 'current']
				// ],
				// [
				// "sExtends"=> "pdf",
				// "oSelectorOpts"=> ["page"=> 'current']
				// ],
				// [
				// "sExtends"=> "print",
				// "sButtonText"=> Yii::t('app',"Imprimir")
				// ],
			],
		 ],
	],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'descripcion',
            'Cupos Disponibles',
			'docente',
			'Cantidad Participantes',
			'Edad Minima',
			'Edad Maxima',
        ],
    ]); ?>
	
	<p>
        <?= Html::a('Agregar', [
									'create',
									'TiposGruposSoporte' => $TiposGruposSoporte,
									'idGruposSoporte' 	 => $idGruposSoporte,
									'idJornadas' 		 => $idJornadas,
									
									 
								], 
								['class' => 'btn btn-success'
		]) ?>


    </p>
	
	 <?= DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'clientOptions' => [
		'language'=>[
                'url' => '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json',
            ],
		"lengthMenu"=> [[20,-1], [20,Yii::t('app',"All")]],
		"info"=>false,
		"responsive"=>true,
		 "dom"=> 'lfTrtip',
		 "tableTools"=>[
			 "aButtons"=> [  
				// [
				// "sExtends"=> "copy",
				// "sButtonText"=> Yii::t('app',"Copiar")
				// ],
				// [
				// "sExtends"=> "csv",
				// "sButtonText"=> Yii::t('app',"CSV")
				// ],
				[
				"sExtends"=> "xls",
				"oSelectorOpts"=> ["page"=> 'current']
				],
				[
				"sExtends"=> "pdf",
				"oSelectorOpts"=> ["page"=> 'current']
				],
				// [
				// "sExtends"=> "print",
				// "sButtonText"=> Yii::t('app',"Imprimir")
				// ],
			],
		 ],
	],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'Participantes',
            'edad',
			'Grado',
			'Sede',
			'Nombre Equipo',
            
            [
			'class' => 'yii\grid\ActionColumn',
			'urlCreator' => function ($action, $model, $key, $index) 
			{
				
				
				$idJornadas 		= $GLOBALS['_GET']['idJornadas'];
				$TiposGruposSoporte =$GLOBALS['_GET']['TiposGruposSoporte'];
				$idGruposSoporte 	= $GLOBALS['_GET']['idGruposSoporte'];
				
				if ($action === 'view') {
					$url ='index.php?r=participantes-grupos-soporte/view&id='.$model['id'].'&idJornadas='.$idJornadas.'&TiposGruposSoporte='.$TiposGruposSoporte.'&idGruposSoporte='.$idGruposSoporte;
					return $url;
				}
				if ($action === 'update') {
					$url ='index.php?r=participantes-grupos-soporte/update&id='.$model['id'].'&idJornadas='.$idJornadas.'&TiposGruposSoporte='.$TiposGruposSoporte.'&idGruposSoporte='.$idGruposSoporte;
					return $url;
				}
				
				if ($action === 'delete') {
					$url ='index.php?r=participantes-grupos-soporte/delete&id='.$model['id'].'&idJornadas='.$idJornadas.'&TiposGruposSoporte='.$TiposGruposSoporte.'&idGruposSoporte='.$idGruposSoporte;
					return $url;
				}

			}
			
			],
        ],
    ]); ?>
</div>
