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
/* @var $searchModel app\models\SancionesEstudiantesBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sanciones Estudiantes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sanciones-estudiantes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Agregar', ['create'], ['class' => 'btn btn-success']) ?>
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
			[
				'attribute'=>'id_perfiles_persona',
				'value' => function( $model )
				{
					$id = $model->id_perfiles_persona;
					$connection = Yii::$app->getDb();
					
					// $command = $connection->createCommand("
					// select concat(p.nombres,' ',p.apellidos) as nombre
					// from personas as p, perfiles_x_personas as pp, perfiles_x_personas_institucion as ppi
					// where pp.id_personas  = p.id
					// and pp.id = ppi.id_perfiles_x_persona
					// and ppi.id_perfiles_x_persona = 63771
					// ");
					
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

            'descripcion',
            'fecha',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
