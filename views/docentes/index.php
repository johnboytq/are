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
Modificaciones:
Fecha: 05-04-2018
Persona encargada: Viviana Rodas
Cambios realizados: Se agregan los datatabes
---------------------------------------
*/

use yii\helpers\Html;
use yii\grid\GridView;

use app\models\Personas;
use app\models\Escalafones;
use yii\helpers\ArrayHelper;
use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DocentesBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Docentes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docentes-index">

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
				'attribute' => 'id_perfiles_x_personas',
				'label'		=> 'Docentes',
				'value' => function( $model ){
								
								// $personas = Personas::findOne($model->id_perfiles_x_personas);
								$personas = Personas::find()
															->innerJoin( 'perfiles_x_personas pf', 'personas.id=pf.id_personas' )
															->innerJoin( 'docentes d', 'pf.id=d.id_perfiles_x_personas' )
															->where( 'pf.id='.$model->id_perfiles_x_personas )->one();
								// echo "--------<br><br><pre>"; var_dump($personas); echo "</pre>";
								return $personas ? $personas->nombres." ".$personas->apellidos: '';
							},
				'filter' => ArrayHelper::map(Personas::find()
															->select( "pf.id, ( personas.nombres || ' ' || personas.apellidos) nombres" )
															->innerJoin( 'perfiles_x_personas pf', 'personas.id=pf.id_personas' )
															->innerJoin( 'docentes d', 'pf.id=d.id_perfiles_x_personas' )
															->all(), 'id', 'nombres' ),
			],
			[
				'attribute' => 'id_escalafones',
				'value' => function( $model ){
					$escalafones = Escalafones::findOne($model->id_escalafones);
					return $escalafones? $escalafones->descripcion : '';
				},
				'filter' => ArrayHelper::map(Escalafones::find()->all(), 'id', 'descripcion' ),
			],
			'Antiguedad',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
