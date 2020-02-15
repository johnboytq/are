<?php

use yii\helpers\Html;

use app\models\SedesCobertura;

// echo "<pre>";
// var_dump( $categorias );
// echo "</pre>";

// echo "<pre>";
// var_dump( $subCategorias );
// echo "</pre>";

// echo "<pre>";
// var_dump( $temas );
// echo "</pre>";

$this->title = "Cobertura";
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/sedes-cobertura.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("https://unpkg.com/sweetalert/dist/sweetalert.min.js");

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
		color:#678197;
		border: 1px solid #000;
		padding:.3em 1em;
		text-align:left;
    }
	
	thead > tr > th {
		text-align: center;
		background-color: #ccc;
		border: 1px solid #ddd;
	}
	
	tfoot > tr > td {
		font-weight: bold;
		text-align: left;
		background-color: #ddd;
		border: 1px solid #ddd;
	}

</style>


<input type='hidden' id='sede' value='<?= $sede ?>'>

<table id='tbTemas'>

	<thead>
		
		<tr>
			<th rowspan=3>Categoría</th>
			<th rowspan=3>Subcategoría</th>
			<th rowspan=3>Temas</th>
			<th colspan=2>Cantidad</th>
		</tr>
		
		<tr>
			<th colspan=2><?= $sedeData->descripcion ?></th>
		</tr>
		
		<tr>
			<th>Niños</th>
			<th>Niñas</th>
		</tr>
		
	</thead>

<?php

foreach( $categorias as $kCategoria => $vCategoria ){
	
	//Contando el total de filas para la categoría
	$count = 0;
	foreach( $subCategorias[$kCategoria] as $kSubCategoria => $vSubCategoria ){
		$count += count( $temas[ $kSubCategoria ] );
	}
	
	$tdCategoria = "<td rowspan='".$count."'>".$vCategoria."</td>";
		
	foreach( $subCategorias[$kCategoria] as $kSubCategoria => $vSubCategoria ){
		
		$tdSubCategoria = "<td rowspan='".count( $temas[ $kSubCategoria ] )."'>".$vSubCategoria."</td>";
		
		foreach( $temas[ $kSubCategoria ] as $kTema => $vTema ){
			
			// $dataSave2 = $dataSave;
			// $registro  = $dataSave2->andWhere( 'id_tema='.$kTema )->all();
			
			
			$dataSaveTable		= new SedesCobertura();
			$registro			= $dataSaveTable->find()
									->where( 'estado=1' )
									->andWhere( 'id_sede='.$sede )
									->andWhere( 'id_tema='.$kTema )->all();
			
			echo "<tr>";
			echo $tdCategoria ;
			echo $tdSubCategoria ;
			echo "<td>".$vTema."</td>";
			echo "<td><input type='text' name='ninos' value='".( $registro ? $registro[0]->ninos : '0' )."'></td>";
			echo "<td><input type='text' name='ninas' value='".( $registro ? $registro[0]->ninas : '0' )."'></td>";
			echo "<td style='display:none;'><input type='hidden' name='id' value='".( $registro ? $registro[0]->id : '' )."'></td>";
			echo "<td style='display:none;'><input type='hidden' name='tema' value='".$kTema."'></td>";
			echo "</tr>";
			
			$tdCategoria = "";
			$tdSubCategoria = "";
		}
	}
}

?>

</table>

 <div class="form-group">
	 <?= Html::a('Guardar', [''], ['class' => 'btn btn-success']) ?>
</div>