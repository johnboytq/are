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
Fecha: 02-04-2018
REPORTES VARIOS
---------------------------------------
Fecha: 24-06-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: - Se corrige query para hallar las aulas en los reportes de OCUPACION CAMAS
---------------------------------------
Fecha: 12-04-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: - Se agrega opción Listado de estudiantes por grupo
---------------------------------------
Fecha: 11-04-2018
Persona encargada: Oscar David Lopez Villa
Se crea reporte tasa de cobertura bruta

---------------------------------------
Modificaciones:
Fecha: 02-04-2018
Persona encargada: Edwin Molina Grisales
Se crea reporte de PORCENTAJE OCUPACION DE AULAS
---------------------------------------
Fecha: 02-04-2018
Persona encargada: Edwin Molina Grisales
Se crea reporte de CANTIDAD DE ESTUDIATNES POR GRUPO con su resumido por cantidad y corresponde a la opción 2 del switch
---------------------------------------
**********/

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

use app\models\Sedes;
use app\models\Instituciones;
use fedemotta\datatables\DataTables;
use yii\widgets\ActiveForm;
use yii\console\widgets\Table;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AsginaturasBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

/**********
Versión: 001
Fecha: 10-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de asignaturas
---------------------------------------
Modificaciones:
Fecha: 10-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - se cambia el atributo id_sede para que muestre la descripcion de la sede segun el id_sede
 de la tabla asigaciones
---------------------------------------
Modificaciones:
Fecha: 29-06-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Reestructuracion al reporte de taza bruta
 de la tabla asigaciones
---------------------------------------
Modificaciones:
Fecha: 04-07-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Reestructuracion al reporte de taza bruta 
---------------------------------------
**********/


$this->registerJsFile(Yii::$app->request->baseUrl.'/js/reportes.js',['depends' => [\yii\web\JqueryAsset::className()]]);

$nombreSede = new Sedes();
$nombreSede = $nombreSede->find()->where('id='.$idSedes)->all();
$nombreSede = ArrayHelper::map($nombreSede,'id','descripcion');
$nombreSede = $nombreSede[$idSedes];

$nombreInstitucion = new Instituciones();
$nombreInstitucion = $nombreInstitucion->find()->where('id='.$idInstitucion)->all();
$nombreInstitucion = ArrayHelper::map($nombreInstitucion,'id','descripcion');
$nombreInstitucion = $nombreInstitucion[$idInstitucion];

$this->title = $nombreInstitucion;
$this->params['breadcrumbs'][] = 
	[
		'label' => 'Reportes', 
		'url' => [
					'index',
					
				 ]
	];						 
		
?>
<div class="asignaturas-index">

    <h1><?= Html::encode($nombreSede) ?></h1>
   

     <?php
	 
		switch ($idReporte) 
		{
			case 1:
				?>
					<h2><?= Html::encode( " Cantidad de Estudiantes IEO/Sede" ) ?></h2><br>
					<div style='text-align:center;font-weight:bold;padding:20px;font-size:12pt;'>Cantidad de Estudiantes: <?= $dataProvider->getTotalCount() ?></div>
				<?php
					echo  DataTables::widget([
					'dataProvider' => $dataProvider,
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
							[
							"sExtends"=> "csv",
							"sButtonText"=> Yii::t('app',"CSV")
							],
							[
							"sExtends"=> "xls",
							"oSelectorOpts"=> ["page"=> 'current']
							],
							[
							"sExtends"=> "pdf",
							"oSelectorOpts"=> ["page"=> 'current']
							],
						],
					],
				],
					'columns' => 
					[
						['class' => 'yii\grid\SerialColumn'], 
						
						[
							'attribute' => 'identificacion',
							'label'		=> 'Documento',
						],
						[
							'attribute' => 'nombres',
							'label'		=> 'Nombre',
						],
						[
							'attribute' => 'domicilio',
							'label'		=> 'Dirección',
						],
						[
							'attribute' => 'descripcion',
							'label'		=> 'Descripción',
						],

					],
				]); 
					
				break;
			
			case 2:
				
					?>
						<h2><?= Html::encode( "Cantidad de estudiantes por grado" ) ?></h2><br>
					
						<div style='text-align:center;font-weight:bold;padding:20px;font-size:12pt;'>Cantidad de Estudiantes: <?= $dataProvider->getTotalCount() ?></div>
					
					<?php
				
					echo  DataTables::widget([
						'dataProvider' => $dataProviderCantidad,
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
									[
									"sExtends"=> "csv",
									"sButtonText"=> Yii::t('app',"CSV")
									],
									[
									"sExtends"=> "xls",
									"oSelectorOpts"=> ["page"=> 'current']
									],
									[
									"sExtends"=> "pdf",
									"oSelectorOpts"=> ["page"=> 'current']
									],
								],
							],
						],
						'columns' => 
						[
							['class' => 'yii\grid\SerialColumn'],
							
							[
								'attribute' => 'grados',
								'label'		=> 'Grados',
							],
							[
								'attribute' => 'cantidad',
								'label'		=> 'Cantidad',
							],
							
						],
					]);
					
					
					echo  DataTables::widget([
						'dataProvider' => $dataProvider,
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
									[
									"sExtends"=> "csv",
									"sButtonText"=> Yii::t('app',"CSV")
									],
									[
									"sExtends"=> "xls",
									"oSelectorOpts"=> ["page"=> 'current']
									],
									[
									"sExtends"=> "pdf",
									"oSelectorOpts"=> ["page"=> 'current']
									],
								],
							],
						],
						'columns' => 
						[
							['class' => 'yii\grid\SerialColumn'], 
							[
								'attribute' => 'identificacion',
								'label'		=> 'Documento',
							],
							[
								'attribute' => 'nombres',
								'label'		=> 'Nombre',
							],
							[
								'attribute' => 'domicilio',
								'label'		=> 'Dirección',
							],
							[
								'attribute' => 'nivel',
								'label'		=> 'Grado',
							],
							[
								'attribute' => 'descripcion',
								'label'		=> 'Jornada',
							],

						],
					]); 
				break;
			case 3:
				?>
						<h2><?= Html::encode( "Cantidad de Estudiantes por Grupo" ) ?></h2><br>
						
						<div style='text-align:center;font-weight:bold;padding:20px;font-size:12pt;'>Cantidad de Estudiantes: <?= $dataProvider->getTotalCount() ?></div>
					<?php
				
					echo  DataTables::widget([
						'dataProvider' => $dataProviderCantidad,
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
									[
									"sExtends"=> "csv",
									"sButtonText"=> Yii::t('app',"CSV")
									],
									[
									"sExtends"=> "xls",
									"oSelectorOpts"=> ["page"=> 'current']
									],
									[
									"sExtends"=> "pdf",
									"oSelectorOpts"=> ["page"=> 'current']
									],
								],
							],
						],
						'columns' => 
						[
							// ['class' => 'yii\grid\SerialColumn'], 
							[
								'attribute' => 'nivel',
								'label'		=> 'Grado',
							],
							[
								'attribute' => 'grupo',
								'label'		=> 'Grupo',
							],
							[
								'attribute' => 'cantidad',
								'label'		=> 'Cantidad de estudiantes',
							],
						],
					]);
					
					
					echo  DataTables::widget([
						'dataProvider' => $dataProvider,
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
									[
									"sExtends"=> "csv",
									"sButtonText"=> Yii::t('app',"CSV")
									],
									[
									"sExtends"=> "xls",
									"oSelectorOpts"=> ["page"=> 'current']
									],
									[
									"sExtends"=> "pdf",
									"oSelectorOpts"=> ["page"=> 'current']
									],
								],
							],
						],
						'columns' => 
						[
							['class' => 'yii\grid\SerialColumn'], 
							[
								'attribute' => 'identificacion',
								'label'		=> 'Documento',
							],
							[
								'attribute' => 'nombres',
								'label'		=> 'Nombre',
							],
							[
								'attribute' => 'domicilio',
								'label'		=> 'Dirección',
							],
							[
								'attribute' => 'nivel',
								'label'		=> 'Grado',
							],
							[
								'attribute' => 'grupo',
								'label'		=> 'Grupo',
							],
							[
								'attribute' => 'descripcion',
								'label'		=> 'Jornada',
							],

						],
					]); 
				break;
			
			case 4:
				?>
					
					<h2><?= Html::encode( "Porcentaje ocupación de aulas" ) ?></h2><br>
					
					<?php
					echo  DataTables::widget([
						'dataProvider' => $dataProvider,
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
									[
									"sExtends"=> "csv",
									"sButtonText"=> Yii::t('app',"CSV")
									],
									[
									"sExtends"=> "xls",
									"oSelectorOpts"=> ["page"=> 'current']
									],
									[
									"sExtends"=> "pdf",
									"oSelectorOpts"=> ["page"=> 'current']
									],
								],
							],
						],
						'columns' => 
						[
							// ['class' => 'yii\grid\SerialColumn'], 
							[
								'attribute' => 'aula',
								'label'		=> 'Aula',
								// 'value'		=> '1111',
							],
							[
								'label'		=> 'Ocupacion',
								'value'		=> function($data){ 
													return ( round( $data['cantidad_ocupada']/$data['capacidad'], 2 )*100 )."%"; 
											   },
							],
						],
					]);
				break;
				case 5:
				?>
					
					<h2><?= Html::encode( "Tasa de cobertura bruta" ) ?></h2><br>
					
					
					<?php // se extraen la posicion del array en varias partes
					extract($arrayPEN);	?>
					
					
					<table style="width:50%" border=1>
				  <tr>
					<th>NIVEL (n)</th>
					<th>EDAD OFICIAL(e)</th> 
					<th>ESTUDIANTES MATRICULADOS O EN EL NIVEL</th>
					<th>POBLACION CON EDAD TEORICA O EN EL NIVEL</th>
					<th>TCB n = INDICADOR %</th>
					
				  </tr>
				  <tr>
					<th>TRANSICIÓN</th>
					<td>5 A 6 AÑOS</td>
					<td id="transcision"><?=$transcision?></td>
					<td><input type="text" id="tcbtranscision" size="5" ></td>
					<td id="tdtcbtranscision"></td>
				  </tr>
				  <tr>
					<th>PRIMARIA</th>
					<td>7 A 11 AÑOS</td>
					<td id="primaria"><?=$primaria?></td>
					<td><input type="text" id="tcbprimaria" size="5" ></td>
					<td id="tdtcbprimaria"></td>
				  </tr>
				  <tr>
					<th>SECUNDARÍA</th>
					<td>12 A 15 AÑOS</td>
					<td id="secundaria"><?=$secundaria?></td>
					<td><input type="text" id="tcbsecundaria" size="5" ></td>
					<td id="tdtcbsecundaria"></td>
				  </tr>
				   <tr>
					<th>MEDIA</th>
					<td>16 A 17 AÑOS</td>
					<td id="media"><?=$media?></td>
					<td><input type="text" id="tcbmedia" size="5" ></td>
					<td id="tdtcbmedia"></td>
				  </tr>
				</table>
					
				<?php	
				break;
				case 6:
				?>
					 
					<h2><?= Html::encode( "Tasa de cobertura Neta" ) ?></h2><br>
					<?php // se extraen la posicion del array en varias partes
					extract($arrayPEN);	?>
					
					
					<table style="width:50%" border=1>
				  <tr>
					<th>NIVEL (n)</th>
					<th>EDAD OFICIAL(e)</th> 
					<th>ESTUDIANTES MATRICULADOS O EN EL NIVEL</th>
					<th>POBLACION CON EDAD TEORICA O EN EL NIVEL</th>
					<th>TCN n = INDICADOR %</th>
					
				  </tr>
				  <tr>
					<th>TRANSICIÓN</th>
					<td>5 A 6 AÑOS</td>
					<td id="transcision"><?=$transcision?></td>
					<td><input type="text" id="tcbtranscision" size="5" ></td>
					<td id="tdtcbtranscision"></td>
				  </tr>
				  <tr>
					<th>PRIMARIA</th>
					<td>7 A 11 AÑOS</td>
					<td id="primaria"><?=$primaria?></td>
					<td><input type="text" id="tcbprimaria" size="5" ></td>
					<td id="tdtcbprimaria"></td>
				  </tr>
				  <tr>
					<th>SECUNDARÍA</th>
					<td>12 A 15 AÑOS</td>
					<td id="secundaria"><?=$secundaria?></td>
					<td><input type="text" id="tcbsecundaria" size="5" ></td>
					<td id="tdtcbsecundaria"></td>
				  </tr>
				   <tr>
					<th>MEDIA</th>
					<td>16 A 17 AÑOS</td>
					<td id="media"><?=$media?></td>
					<td><input type="text" id="tcbmedia" size="5" ></td>
					<td id="tdtcbmedia"></td>
				  </tr>
				</table>
				
				<?php	
				break;
				
				case 7:
				?>
					 
					<h2><?= Html::encode( "Listado de estudiantes por Grupo - Desempeño (Puesto Ocupado)" ) ?></h2><br>
					
					<?php
					
					if( empty( $dataProvider ) ) ?>
						<h2><?= Html::encode( "NO SE ENCUENTRAN DATOS PARA MOSTRAR" ) ?></h2><br>
					<?php
					
					foreach( $dataProvider as $dP )
					{
						//Si el grupo no tiene registro no se muestra
						if( $dP->getTotalCount() > 0 )
						{
						
							echo  DataTables::widget([
								'dataProvider' => $dP,
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
											[
											"sExtends"=> "csv",
											"sButtonText"=> Yii::t('app',"CSV")
											],
											[
											"sExtends"=> "xls",
											"oSelectorOpts"=> ["page"=> 'current']
											],
											[
											"sExtends"=> "pdf",
											"oSelectorOpts"=> ["page"=> 'current']
											],
										],
									],
								],
								'columns' => 
								[
									['class' => 'yii\grid\SerialColumn'],
									[
										'attribute' => 'identificacion',
										'label'		=> 'Documento',
									],
									[
										'attribute' => 'nombre',
										'label'		=> 'Nombre',
									],
									[
										'attribute' => 'domicilio',
										'label'		=> 'Dirección',
									],
									[
										'attribute' => 'grupo',
										'label'		=> 'Grado',
										'value'		=> function( $model ){
											$exp = explode( "-", $model[ 'grupo' ] );
											$grado = $exp[0];
											$grupo = !empty( $exp[1] ) ? $exp[1] : '';
											return $grado;
										},
									],
									[
										'attribute' => 'grupo',
										'label'		=> 'Grupo',
										'value'		=> function( $model ){
											$exp 	= explode( "-", $model[ 'grupo' ] );
											$grado	= $exp[0];
											$grupo 	= !empty( $exp[1] ) ? $exp[1] : '';
											return $grupo;
										},
									],
									// [
										// 'attribute' => 'puesto',
										// 'label'		=> 'Puesto',
									// ],
									['class' => 'yii\grid\SerialColumn', 'header' => 'Puesto' ],
								],
							]);
							
							echo "<br>";
							echo "<br>";
						}
					}
					
				break;
				
				case 8:
				
					?>
						<h2><?= Html::encode( "Cantidad de estudiantes por grado" ) ?></h2><br>
					<?php
				
					echo  DataTables::widget([
						'dataProvider' => $dataProviderCantidad,
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
									[
									"sExtends"=> "csv",
									"sButtonText"=> Yii::t('app',"CSV")
									],
									[
									"sExtends"=> "xls",
									"oSelectorOpts"=> ["page"=> 'current']
									],
									[
									"sExtends"=> "pdf",
									"oSelectorOpts"=> ["page"=> 'current']
									],
								],
							],
						],
						'columns' => 
						[
							// ['class' => 'yii\grid\SerialColumn'],
							
							[
								'attribute' => 'genero',
								'label'		=> '',
							],
							[
								'attribute' => 'cantidad',
								'label'		=> '',
							],
							
							
						],
					]);
					
					
					echo  DataTables::widget([
						'dataProvider' => $dataProvider,
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
									[
									"sExtends"=> "csv",
									"sButtonText"=> Yii::t('app',"CSV")
									],
									[
									"sExtends"=> "xls",
									"oSelectorOpts"=> ["page"=> 'current']
									],
									[
									"sExtends"=> "pdf",
									"oSelectorOpts"=> ["page"=> 'current']
									],
								],
							],
						],
						'columns' => 
						[
							['class' => 'yii\grid\SerialColumn'], 
							[
								'attribute' => 'identificacion',
								'label'		=> 'Documento',
							],
							[
								'attribute' => 'nombres',
								'label'		=> 'Nombre',
							],
							[
								'attribute' => 'domicilio',
								'label'		=> 'Dirección',
							],
							'genero',
							[
								'attribute' => 'descripcion',
								'label'		=> 'Jornada',
							],

						],
					]); 
				break; //fin case 8
				
				case 9:
				?>
					 
					<h2><?= Html::encode( "Listado de estudiantes por Grado - Desempeño (Puesto Ocupado)" ) ?></h2><br>
					
					<?php
					
					if( empty( $dataProvider ) ) ?>
						<h2><?= Html::encode( "NO SE ENCUENTRAN DATOS PARA MOSTRAR" ) ?></h2><br>
					
					
					<?php
					
					foreach( $dataProvider as $dP )
					{
						//Si el grupo no tiene registro no se muestra
						if( $dP->getTotalCount() > 0 )
						{
						
							echo  DataTables::widget([
								'dataProvider' => $dP,
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
											[
											"sExtends"=> "csv",
											"sButtonText"=> Yii::t('app',"CSV")
											],
											[
											"sExtends"=> "xls",
											"oSelectorOpts"=> ["page"=> 'current']
											],
											[
											"sExtends"=> "pdf",
											"oSelectorOpts"=> ["page"=> 'current']
											],
										],
									],
								],
								'columns' => 
								[
									['class' => 'yii\grid\SerialColumn'],
									[
										'attribute' => 'identificacion',
										'label'		=> 'Documento',
									],
									[
										'attribute' => 'nombre',
										'label'		=> 'Nombre',
									],
									[
										'attribute' => 'domicilio',
										'label'		=> 'Dirección',
									],
									[
										'attribute' => 'grupo',
										'label'		=> 'Grado',
										// 'value'		=> function( $model ){
											// return $model[ 'grupo' ];
										// },
									],
									// [
										// 'attribute' => 'puesto',
										// 'label'		=> 'Puesto',
									// ],
									['class' => 'yii\grid\SerialColumn', 'header' => 'Puesto' ],
								],
							]);
							
							echo "<br>";
							echo "<br>";
						}
					}
					
				break;
		}
		
		?>
	
</div>
