<?php
/**********
Versión: 001
Fecha: 19-06-2018
---------------------------------------
Modificaciones:
Fecha: 05-07-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se deja el Data table en español
---------------------------------------
Fecha: 18-06-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se corrigen queires
---------------------------------------
**********/

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

use yii\data\ArrayDataProvider;
use fedemotta\datatables\DataTables;

use app\models\Periodos;
use app\models\FestivosNolaborales;
use app\models\Personas;
use app\models\Aulas;
use app\models\Instituciones;
use app\models\Sedes;
use app\models\DistribucionesAcademicas;
use app\models\Inasistencias;


$this->registerJsFile(Yii::$app->request->baseUrl.'/js/inasistencias.js',['depends' => [\yii\web\JqueryAsset::className()]]);

/* @var $this yii\web\View */
/* @var $searchModel app\models\InasistenciasBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$institucion 			= Instituciones::findOne( $idInstitucion );
$sede 		 			= Sedes::findOne( $idSedes );
$distribucionAcademica	= DistribucionesAcademicas::find()
								->innerJoin( 'perfiles_x_personas pp', 'pp.id=distribuciones_academicas.id_perfiles_x_personas_docentes' )
								->innerJoin( "asignaturas_x_niveles_sedes ans", "ans.id=distribuciones_academicas.id_asignaturas_x_niveles_sedes" )
								->innerJoin( "aulas_x_paralelos ap", "ap.id_paralelos=distribuciones_academicas.id_paralelo_sede" )
								->innerJoin( "aulas a", "a.id=ap.id_aulas" )
								->where( "a.id=".$idGrupo )
								->andWhere( 'distribuciones_academicas.estado=1' )
								->andWhere( 'ans.id_asignaturas='.$idAsignatura )
								->andWhere( 'pp.id_personas='.$idDocente )->one();
								
// echo "<pre>"; var_dump($distribucionAcademica->id); echo "</pre>";

$columns = [];
array_push( $columns, ['class' => 'yii\grid\SerialColumn'] );
array_push( $columns, 'identificacion' );
array_push( $columns, 'nombres' );

$this->title = 'Inasistencias';
$this->params['breadcrumbs'][] = $this->title;

$periodo 	= Periodos::findOne( $idPeriodo );
$festivos 	= FestivosNolaborales::find()
						->where( [ 'between' , 'fecha', "'".$periodo->fecha_inicio."'", "'".$periodo->fecha_fin."'" ] )
						->andWhere( "id_sedes=".$idSedes )
						->all();

//Convierto todos los festivos en unix
$festivosUnix = [];
foreach( $festivos as $k => $value ){
	$festivosUnix[] = strtotime( $value->fecha." 00:00:00 UTC" );
}

//Creando un array de todos los días validos en el tiempo del periodo
//Primero calculo fecha inicial y final del periodo en tiempo unix
$inicioPeriodo = strtotime( $periodo->fecha_inicio." 00:00:00 UTC" );
$finalPeriodo  = strtotime( $periodo->fecha_fin." 00:00:00 UTC" );

//dias habiles contiene todos los días habiles en que se dan clases en tiempo unix
$diasHabiles = [];
for( $i = $inicioPeriodo; $i <= $finalPeriodo; $i += 24*3600 ){
	
	/*****************************************************
	 * date( w ) es el numero de la semana 0-6
	 * 0 para domingo, 6 para sábado
	 * Si es sábado o domingo no se agrega la fecha
	 *****************************************************/
	$diaSemana = date( "w", $i );
	if( $diaSemana != 0 && $diaSemana != 6 ){
		
		//Si no está en festivos se agrega la fecha
		if( !in_array( $i, $festivosUnix ) ){
			$diasHabiles[ gmdate( "Y-m-d", $i ) ] = "asistio";
			// array_push( $columns, ['attribute' => gmdate( "Y-m-d", $i ) ] );
			$columns[] = [
							'attribute' => gmdate( "Y-m-d", $i ), 
							'format'	=> 'raw',
							'value'		=> function( $model, $key, $index, $column ){
												
												$object = [
													'estudiante' 	 		=> $model['estudiante'],
													'nombres' 		 		=> $model['nombres'],
													'identificacion' 		=> $model['identificacion'],
													'distribucionAcademica' => $model['distribucionAcademica'],
													'fecha' 				=> $column->attribute,
													'fechaActual'			=> date( "Y-m-d" ),
													'estado'				=> 1,
												];
												
												$inasistencia = Inasistencias::find()
																		->where( "id_perfiles_x_personas_estudiantes=".$model['estudiante'] )
																		->andWhere( "id_distribuciones_academicas=".$model['distribucionAcademica'] )
																		->andWhere( "fecha='".$column->attribute."'" )
																		->andWhere( "estado=1" )
																		->count();
																		
												$asistencia = $inasistencia > 0 ? 'faltó' : 'asistió';
												$style 		= $inasistencia > 0 ? 'color:red;' : 'color:green;';
												
												return Html::buttonInput( $asistencia, 
																		 [ 
																			"onclick"=>"marcarFalta( this, ".json_encode( $object ).")", 
																			"title"  => "Cambiar a falta", 
																			"style"  => $style, 
																		]);
											},
						];
		}
	}
}









// foreach( $diasHabiles as $k => $v )
	// echo "<br>".gmdate( "Y-m-d", $v );
$aulas = Aulas::findOne( $idGrupo );
$estudiantes = Personas::find()
					->select( "pp.id, ( nombres || apellidos ) as nombres, personas.identificacion" )
					->innerJoin( "perfiles_x_personas pp", "pp.id_personas=personas.id" )
					->innerJoin( "estudiantes e", "e.id_perfiles_x_personas=pp.id" )
					->innerJoin( "paralelos p", "p.id=e.id_paralelos" )
					->where( "p.estado=1" )
					->andWhere( "pp.estado=1" )
					->andWhere( "personas.estado=1" )
					->andWhere( "e.estado=1" )
					->andWhere( "p.descripcion='".$aulas->descripcion."'" )
					->all();
		
$data = [];		
foreach( $estudiantes as $key => $value ){
	// echo "<br>".$value->nombres." ".$value->identificacion;
	
	 $a = [
		'estudiante' 	 => $value->id,
		'nombres' 		 => $value->nombres,
		'identificacion' => $value->identificacion,
	];
	
	$data[] = $a + $diasHabiles+['distribucionAcademica' => $distribucionAcademica->id ];
}

$dataProvider = new ArrayDataProvider([
    'allModels' => $data,
    'pagination' => [
        'pageSize' => 10,
    ],
    'sort' => [
        'attributes' => ['id', 'name'],
    ],
]);







// array_push( $columns, ['class' => 'yii\grid\ActionColumn'] );

?>
<style>
    
    table {
		width:90%;
		border-top:1px solid #e5eff8;
		border-right:1px solid #e5eff8;
		margin:1em auto;
		border-collapse:collapse;
    }
    td {
		color:black;
		border-bottom:1px solid #e5eff8;
		border-left:1px solid #e5eff8;
		padding:.3em 1em;
		text-align:center;
    }
	
	thead > tr > th {
		text-align: center;
		background-color: #ccc;
		border: 1px solid #ddd;
	}

</style>


<div style='text-align:center;background-color:#ddd;'>
	
		<table style='width:80%;'>
		
			<tr>
				<td>
					 <b><h2>CODIGO DANE:</b>
					<?php echo $institucion->codigo_dane ?> </h2>
				</td>
				
				<td>
					 <h2><?php echo  $institucion->descripcion ?></h2>
				</td>
				
			</tr>
			
			<tr>
				<td colspan=2>
					 <h3><?php echo $sede->descripcion ?></h3>
				</td>
			</tr>
			
		</table>
		
	</div>



<div class="inasistencias-index" style='overflow:auto;'>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


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
        'columns' => $columns,
    ]); ?>
</div>
