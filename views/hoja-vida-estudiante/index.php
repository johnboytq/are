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
Fecha: Fecha modificacion (06-06-2018)
Desarrollador: Edwin Molina Grisales
Descripción: Se validan datos que puedan no existir en la base de datos para el estudiante que se busca
---------------------------------------
*/


use yii\helpers\Html;
use yii\grid\GridView;

use app\models\TiposIdentificaciones;
use app\models\Personas;
use app\models\Instituciones;
use app\models\Generos;
use app\models\Jornadas;
use app\models\Sedes;



/* @var $this yii\web\View */
/* @var $searchModel app\models\HojaVidaEstudianteBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hoja de vida de estudiantes';
$this->params['breadcrumbs'][] = $this->title;

// var_dump( $searchModel );

$models = $dataProvider->getModels();

?>
<style>
.span{
	padding: 10px;
	display: inline-block;
}
</style>
<div class="hoja-vida-estudiante-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    
	<?php

	foreach( $models as $key => $model ){

		$tipoDocumento 	= TiposIdentificaciones::findOne( $model->id_tipos_identificaciones);
		$institucion 	= Instituciones::findOne( $model->institucion );
		$genero 		= Generos::findOne( $model->id_generos );
		$personaLegal	= Personas::findOne( $model->id );
		$tipoDocumentoPL= $personaLegal ? TiposIdentificaciones::findOne( $personaLegal->id_tipos_identificaciones) : null;
		$sede			= Sedes::findOne( $model->sede );
		$jornada		= Jornadas::findOne( $model->jornada );
		$grupo			= $model->grupo;
		list( $grado )	= explode( "-", $model->grupo );
		
		$cumpleanos = new DateTime($model->fecha_nacimiento);
		$hoy 		= new DateTime();
		$annos 		= $hoy->diff($cumpleanos);
		$edad 		= $annos->y;

		echo "<div>";
		echo "<span class=span>".( $tipoDocumento ? $tipoDocumento->descripcion : '' )." ".( $model->identificacion ? $model->identificacion: '' )."</span>";
		echo "<span class=span>".$model->nombres." ".$model->apellidos."</span>";
		echo "<span class=span><b>"."FECHA DE NACIMIENTO: </b>".$model->fecha_nacimiento."</span>";
		echo "<span class=span>"."<b>EDAD</b>: ".$edad."</span>";
		echo "<span class=span>".( $genero ? $genero->descripcion : '' )."</span>";
		echo "<br>";
		echo "<span class=span>".( $institucion ? $institucion->descripcion : 'SIN INSTITUCION ASIGNADA' ). "</span><span clss=span> <b> SEDE: </b>".( $sede ? $sede->descripcion : 'SIN SEDE ASIGNADA' )." </span>
		<br>
		<span class=span><b>GRADO</b>: ".$grado."</span><span clss=span> <b>GRUPO</b>: </span><span clss=span>".$grupo." <b>JORNADA:</b> </span><span clss=span>".( $jornada ? $jornada->descripcion : 'SIN JORNADA ASIGNADA' )."</span>" ;
		echo "<br>";

		if( $personaLegal && $personaLegal->estado == 1 ){
			echo "<span class=span>".( $tipoDocumentoPL ? $tipoDocumentoPL->descripcion : '' )." ".( $personaLegal ? $personaLegal->identificacion : '' )."</span>";
			echo "<span class=span>".( $personaLegal ? $personaLegal->nombres : '' )." ".( $personaLegal ? $personaLegal->apellidos : '' )."</span>";
			echo "<span>PARENTESCO: MAMÁ</span>";
			echo "<span class=span>"."CORREO: ".( $personaLegal ? $personaLegal->correo : '' )."</span>";
			echo "<span class=span>"."TELEFONO: ".( $personaLegal ? $personaLegal->telefonos : '' )."</span>";
		}
		else{
			echo "<span class=span>SIN REPRESENTANTE LEGAL</span>";
		}
		
		echo "</div>";

		break;
	}
	?>
</div>
