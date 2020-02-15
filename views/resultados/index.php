<style>
    
    table {
		width:90%;
		border-top:1px solid #e5eff8;
		border-right:1px solid #e5eff8;
		margin:1em auto;
		border-collapse:collapse;
    }
	
    td {
		color:#678197;
		border-bottom:1px solid #fff;
		border-left:1px solid #fff;
		padding:.3em 1em;
		text-align:center;
    }
	
	thead > tr > th {
		text-align: center;
		background-color: #ccc;
		border: 1px solid #ddd;
	}
	
	th	{
		text-align: center;
	}

</style>
<?php

use yii\helpers\Html;
use yii\grid\GridView;

use app\models\Instituciones;
use app\models\AsignaturaEspecifica;
use app\models\AsignaturasEvaluadas;
use app\models\Estados;
use yii\helpers\ArrayHelper;

use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ResultadosPruebasSaberCaliBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;


$asignaturasEvaluadas 	= $data[ 'asignaturasEvaluadas' ];
$asignaturasEspecifica 	= $data[ 'asignaturasEspecifica' ];
$dataValores 			= $data[ 'data' ];

$iscAnios				= $dataIndices[ 'anios' ];
$iscIndices				= $dataIndices[ 'indices' ];
$iscValores				= $dataIndices[ 'data' ];

$pmiAreas				= $dataPMI[ 'areas' ];
$pmiSubProcesos			= $dataPMI[ 'subProcesos' ];
$pmiProcesos			= $dataPMI[ 'procesos' ];
$pmiValores				= $dataPMI[ 'data' ];

$pruebasExternas		= $dataPruebasExternas['data'];

$pruebasSEM				= $dataPruebasSEM['data'];

$pruebasDocentes		= $dataPruebasDocentes['data'];

// echo "<pre>";
// var_dump( $pruebasExternas );
// echo "</pre>"; exit();
// var_dump( $pruebasExternas );
?>

<h2 style='text-align:center'>PRUEBAS DEL SABER</h2>

<table>

<thead>

<tr>

<th rowspan=3>Año</th>
<?php 
foreach( $asignaturasEvaluadas as $key => $value ){ 
	echo "<th colspan='".$value."'>".$key."</th>";
} ?>

</tr>

<tr>
<?php 
foreach( $asignaturasEspecifica as $key => $value ){
	foreach( $value as $k => $v ){
		echo "<th colspan=2>$v</th>";
	}
} ?>

<tr>
<?php 
foreach( $asignaturasEspecifica as $key => $value ){
	foreach( $value as $k => $v ){
		echo "<th>IE</th>";
		echo "<th>Cali</th>";
	}
} ?>
</tr>

</thead>


<?php 
foreach( $dataValores as $key => $value ){
	echo "<tr>";
	echo "<td>".$key."</td>";
	foreach( $asignaturasEspecifica as $aeKey => $aeValue ){
		foreach( $aeValue as $ask => $aev ){
			
			$valorIE 	= '';
			$valorCali 	= '';
			if( !empty($value[ $aev ]['ie']) ){
				$valorIE = $value[ $aev ]['ie'];
			}
			
			if( !empty( $value[ $aev ]['cali'] ) ){
				$valorCali = $value[ $aev ]['cali'];
			}
			
			echo "<td>".$valorIE."</td>";
			echo "<td>".$valorCali."</td>";
		}
	}
	echo "</tr>";
} ?>

</tr>

</table>






<h2 style='text-align:center'>INDICE SINTÉTICO DE CALIDAD</h2>

<table>

<thead>

<tr>

<?php 
foreach( $iscAnios as $key => $value ){ 
	echo "<th colspan='".$value."'>".$key."</th>";
} ?>

</tr>

<tr>
<?php 
foreach( $iscAnios as $keyAnio => $valueAnio ){
	foreach( $iscIndices[ $keyAnio ] as $k => $v ){
		echo "<th>".$v."</th>";
	}
} ?>

</thead>

<tr>

<?php 
foreach( $iscAnios as $keyAnio => $valueAnio ){
	foreach( $iscIndices[ $keyAnio ] as $keyIndice => $valueIndice ){
		echo "<td>".$iscValores[ $keyAnio ][ $valueIndice ]."</td>";
	}
} 
?>

</tr>

</table>







<h2 style='text-align:center'>PMI</h2>

<table>

<thead>

<tr>
<th rowspan=3>Año</th>
<th rowspan=3>Código DANE</th>
<th rowspan=3>Comuna</th>
<th rowspan=3>Zona</th>

<?php 
foreach( $pmiAreas as $keyPmi => $valuePmi ){ 
	echo "<th colspan='".$valuePmi."'>".$keyPmi."</th>";
} ?>

</tr>

<tr>
<?php 
foreach( $pmiAreas as $keyPmi => $valuePmi ){ 
	foreach( $pmiSubProcesos[ $keyPmi ] as $keySubProceso => $valueSubproceso ){
		echo "<th colspan='".$valueSubproceso."'>".$keySubProceso."</th>";
	}
} ?>


<tr>

<?php 
foreach( $pmiAreas as $keyPmi => $valuePmi ){ 
	foreach( $pmiSubProcesos[ $keyPmi ] as $keySubProceso => $valueSubproceso ){
		foreach( $pmiProcesos[ $keyPmi ][ $keySubProceso ] as $keyProceso => $valueProceso ){
			echo "<th>".$valueProceso."</th>";
		}
	}
} 
?>

</tr>

</thead>

<tr>

<?php 
foreach( $pmiValores as $keyValores => $valueValores ){
	echo "<tr><td>".$keyValores."</td>";
	echo "<td>".$valueValores['codigo_dane']."</td>";
	echo "<td>".$valueValores['comuna']."</td>";
	echo "<td>".$valueValores['zona']."</td>";
	foreach( $pmiAreas as $keyAreas => $valueAreas ){
		foreach( $pmiSubProcesos[ $keyAreas ] as $keySubProceso => $valueSubproceso ){
			foreach( $pmiProcesos[ $keyAreas ][ $keySubProceso ] as $keyProceso => $valueProceso ){
				$valor = '';
				if( !empty($valueValores['valores'][ $keyAreas ][ $keySubProceso ][ $valueProceso ]) )
					$valor = $valueValores['valores'][ $keyAreas ][ $keySubProceso ][ $valueProceso ];
				echo "<td>".$valor."</td>";
			}
		}
	} 
} 
?>

</tr>



</table>





<h2 style='text-align:center'>RESULTADOS DE PRUEBAS EXTERNAS</h2>

<table>

<thead>
	<tr>
		<th>Descripción</th>
		<th>Resultado</th>
	<tr>
<thead>

<tr>

<?php 
foreach( $pruebasExternas as $key => $value ){
	echo "<tr>";
	echo "<td>".$value['descripcion']."</td>";
	echo "<td>".$value['valor']."</td>";
	echo "</tr>";
	
} 
?>
</tr>


</table>

<h2 style='text-align:center'>OTROS RESULTADOS DE EVALUACIONES CON QUE CUENTE LA SEM</h2>

<table>

<thead>
	<tr>
		<th>Descripción</th>
		<th>Resultado</th>
	<tr>
<thead>

<tr>

<?php 
foreach( $pruebasSEM as $key => $value ){
	echo "<tr>";
	echo "<td>".$value['descripcion']."</td>";
	echo "<td>".$value['valor']."</td>";
	echo "</tr>";
	
} 
?>
</tr>


</table>


<h2 style='text-align:center'>RESULTADOS DE LA EVALUACION A DOCENTES (EN LAS CATEGORIAS QUE TENGA LA SEM)</h2>

<table>

<thead>
	<tr>
		<th>Descripción</th>
		<th>Resultado</th>
	<tr>
<thead>

<tr>

<?php 
foreach( $pruebasDocentes as $key => $value ){
	echo "<tr>";
	echo "<td>".$value['descripcion']."</td>";
	echo "<td>".$value['valor']."</td>";
	echo "</tr>";
	
} 
?>
</tr>


</table>