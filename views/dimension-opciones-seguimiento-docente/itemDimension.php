<?php
use yii\helpers\Html;

use yii\bootstrap\ActiveForm;

use app\models\DimensionOpcionesSeguimientoDocente;

$data = DimensionOpcionesSeguimientoDocente::find()
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
		if( $dimension == 8 ){echo "<div><h4>Dimensión del SER</h4><br>
        A continuación encontrará una serie de afirmaciones sobre aspectos relacionados con el SER del Docente-Tutor; califique de 1 a 4 siendo 1 Nunca y 4 Siempre, de acuerdo a la frecuencia en que usted considera que se evidencian estas características.<br> </div>   ";}	

		if( $dimension == 9 ){echo "<div><h4>Dimensión del HACER</h4><br>
        A continuación encontrará una serie de afirmaciones sobre aspectos relacionados con el HACER del Docente-Tutor; califique de 1 a 4 siendo 1 Nunca y 4 Siempre, de acuerdo a la frecuencia en que usted considera que se evidencian estas características.<br> </div>   ";}	

		if( $dimension == 10 ){echo "<div><h4>Dimensión del SABER</h4><br>
        A continuación encontrará una serie de afirmaciones sobre aspectos relacionados con el SABER del Docente-Tutor; califique de 1 a 4 siendo 1 Nunca y 4 Siempre, de acuerdo a la frecuencia en que usted considera que se evidencian estas características.<br> </div>   ";}	

		
foreach( $data as $key => $value ){
	// echo "<div class='row'>";
	echo $form->field( $value , 'descripcion' )->radioList( $parametros )->label(  $value->descripcion );
	// echo "</div>";
}