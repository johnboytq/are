<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


use app\models\Paralelos;
use app\models\Generos;
use app\models\TiposIdentificaciones;
use app\models\Jornadas;
// var_dump( $persona ); exit();


$paralelos = Paralelos::find()
					->innerJoin( 'estudiantes e', 'e.id_paralelos=paralelos.id' )
					->innerJoin( 'perfiles_x_personas pp', 'pp.id=e.id_perfiles_x_personas' )
					->innerJoin( 'personas p', 'p.id=pp.id_personas' )
					->innerJoin( 'sedes_niveles sn', 'sn.id=paralelos.id_sedes_niveles' )
					->where( 'p.id='.$persona->id )
					->andWhere( 'pp.estado=1' )
					->andWhere( 'e.estado=1' )
					->andWhere( 'paralelos.estado=1' )
					->andWhere( 'p.estado=1' )
					->one();
					
$jornada = Jornadas::find()
				->innerJoin( 'sedes_jornadas sj', 'sj.id_jornadas=jornadas.id' )
				->innerJoin( 'paralelos p', 'p.id_sedes_jornadas=sj.id' )
				->where( 'p.id='.$paralelos->id )
				->one();

$edad = "Sin fecha de nacimiento";
if( $persona->fecha_nacimiento && $persona->fecha_nacimiento!= NULL && !empty( $persona->fecha_nacimiento ) ){
	$cumpleanos = new DateTime( $persona->fecha_nacimiento );
	$hoy 		= new DateTime();
	$edad 		= $hoy->diff($cumpleanos)->y;
	$edad 	   .= " años";
}

$genero = "Género no registrado";
if( $persona->id_generos && $persona->id_generos!= NULL && !empty( $persona->id_generos ) ){
	
	$g = Generos::findOne( $persona->id_generos);
	$genero = $g->descripcion;
}

$tipoId = "Tipo de identifiación no registrado";
if( $persona->id_tipos_identificaciones && $persona->id_tipos_identificaciones!= NULL && !empty( $persona->id_tipos_identificaciones ) ){
	
	$ti = TiposIdentificaciones::findOne( $persona->id_tipos_identificaciones );
	$tipoId = $ti->descripcion;
}
?>

<style>
	.rowinf{
		border: 1px solid white;
	}
</style>

<div style='width:90%;'>

	<div class='row rowinf' style='text-align:center;background-color:#ccc;'>
		
		<span class='col-sm-8'>
			<h4><?= $persona->nombres." ".$persona->apellidos ?></h4>
		</span>
		
		<span class='col-sm-2'>
			<h4><?= $genero ?></h4>
		</span>
		
		
		<span class='col-sm-2'>
			<h4><?= $edad ?></h4>
		</span>
		
	</div>
	
	<div class='row rowinf' style='text-align:center;background-color:#eee;' >
		<span class='col-sm-6'>
			<h4><?= $tipoId." ".$persona->identificacion ?></h4>
		</span>
		<div class='col-sm-3' style='text-align:center'>
			<h4>Curso <?= $paralelos->descripcion ?></h4>
		</div>
		<div class='col-sm-3' style='text-align:center'>
			<h4>Jornada <?= $jornada ? $jornada->descripcion : ' no registrada' ?><h4>
		</div>
	</div>
	
</div>