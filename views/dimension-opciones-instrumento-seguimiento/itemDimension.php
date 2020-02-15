<?php
use yii\helpers\Html;

use yii\bootstrap\ActiveForm;

use app\models\DimensionOpcionesInstrumentoSeguimiento;

$data = DimensionOpcionesInstrumentoSeguimiento::find()
			->where( 'id_tipo_dimension='.$dimension )
			->andWhere( 'estado=1' )
			->all();
			
$form = ActiveForm::begin([
		// 'layout' => 'horizontal',
		// 'fieldConfig' => [
			// 'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
			// 'horizontalCssClasses' => [
				// 'label' 	=> 'col-sm-2',
				// 'offset' 	=> 'col-sm-offset-2',
				// 'wrapper' 	=> 'col-sm-8',
				// 'error' 	=> '',
				// 'hint' 		=> '',
				// 'input' 	=> 'col-sm-2',
			// ],
		// ],
	]);
	
	if( $dimension == 8 ){
		?>
			<h3>Dimensión del ser</h3>
			<p>A continuación encontrará una serie de afirmaciones sobre aspectos relacionados con el SER del Docente-Tutor; califique de 1 a 4  siendo 1 Nunca y 4 Siempre,  de acuerdo a la frecuencia en que usted haya observado estas características.</p>
		<?php
	}	

	if( $dimension == 9 ){
		?>
			<h3>Dimensión del HACER</h3>
			<p>A continuación encontrará una serie de afirmaciones sobre aspectos relacionados con el HACER del Docente-Tutor; califique de 1 a 4 siendo 1 Nunca y 4 Siempre, de acuerdo a la frecuencia en que usted haya observado estas características.</p>
		<?php
	}	

	if( $dimension == 10 ){
		?>
			<h3>Dimensión del Saber</h3>
			<p>A continuación encontrará una serie de afirmaciones sobre aspectos relacionados con el SABER del Docente-Tutor; califique de 1 a 4 siendo 1 Nunca y 4 Siempre, de acuerdo a la frecuencia en que usted haya observado estas características.</p>
		<?php
	}	

		
foreach( $data as $key => $value ){
	// echo "<div class='row'>";
	echo $form->field( $value , 'descripcion' )->radioList( $parametros )->label(  $value->descripcion );
	// echo "</div>";
}