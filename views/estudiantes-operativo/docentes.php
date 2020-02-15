<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


use app\models\Paralelos;
use app\models\Generos;
use app\models\TiposIdentificaciones;
use app\models\Jornadas;

use yii\db\Query;
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
					

$query = new Query;
					
$data = $query
					->select( 'da.id, da.id_asignaturas_x_niveles_sedes as ida, a.descripcion as asignatura, n.id as idn, n.descripcion as nivel, e.descripcion as escalafon, j.descripcion as jornada' )
					->from( 'distribuciones_academicas da' )
					->innerJoin( 'asignaturas_x_niveles_sedes ans', 'ans.id=da.id_asignaturas_x_niveles_sedes' )
					->innerJoin( 'asignaturas a' , 'a.id=ans.id_asignaturas' )
					->innerJoin( 'perfiles_x_personas pp' , 'pp.id=da.id_perfiles_x_personas_docentes' )
					->innerJoin( 'personas p' , 'p.id=pp.id_personas' )
					->innerJoin( 'sedes_niveles sn' , 'sn.id=ans.id_sedes_niveles' )
					->innerJoin( 'niveles n' , 'n.id=sn.id_niveles' )
					->innerJoin( 'docentes d' , 'd.id_perfiles_x_personas=pp.id' )
					->innerJoin( 'escalafones e' , 'e.id=d.id_escalafones' )
					->innerJoin( 'paralelos pa' , 'pa.id=da.id_paralelo_sede' )
					->innerJoin( 'sedes_jornadas sj' , 'sj.id=pa.id_sedes_jornadas' )
					->innerJoin( 'jornadas j' , 'j.id=sj.id_jornadas' )
					->where( 'p.id='.$persona->id )
					// ->andWhere( 'a.id_sedes='.$sede )
					// ->andWhere( 'sn.id_sedes='.$sede )
					// ->andWhere( 'n.id='.$nivel )
					->andWhere( 'da.estado=1' )
					->andWhere( 'a.estado=1' )
					->andWhere( 'pp.estado=1' )
					->andWhere( 'p.estado=1' )
					->andWhere( 'n.estado=1' )
					->all();
					
foreach( $data as $key => $value ){
	$asignaturas[ $value['ida'] ] 	= $value['asignatura'];
	$niveles[ $value['nivel'] ] 	= 1;
	$jornadas[ $value['jornada'] ]	= 1;
	$escalafon 						= $value['escalafon'];
}
// var_dump( $niveles )					;
// $jornada = Jornadas::find()
				// ->innerJoin( 'sedes_jornadas sj', 'sj.id_jornadas=jornadas.id' )
				// ->innerJoin( 'paralelos p', 'p.id_sedes_jornadas=sj.id' )
				// ->where( 'p.id='.$paralelos->id )
				// ->one();

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

<div style='width:90%;padding:10px 0 10px 0;'>

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
	</div>
	
	
	
</div>