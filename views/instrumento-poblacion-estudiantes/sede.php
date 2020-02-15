<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$sede->descripcion;
$sede->codigo_dane;
$institucion->descripcion;

?>
<style>
	.rowinf{
		border: 1px solid white;
	}
</style>


<div style='width:90%;'>
	<div class='row rowinf' >
		<span class='col-sm-12' style='text-align:center;background-color:#ccc;'>
			<h4><?= $institucion->descripcion; ?></h4>
		</span>
	</div>

	<div class='row rowinf' style='text-align:center;background-color:#eee;'>
		
		<span class='col-sm-6'>
			<h4><?= $sede->descripcion; ?></h4>
		</span>
		
		<span class='col-sm-6'>
			<h4>CÓDIGO DANE <?= $sede->codigo_dane; ?></h4>
		</span>
	</div>
</div>