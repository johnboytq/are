<?php

use yii\helpers\Html;
use yii\grid\GridView;

use app\models\Aulas;
use app\models\Paralelos;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AulasXParalelosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Aulas por grupo';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aulas-xparalelos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Agregar', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
			[
				'attribute'=>'id_paralelos',
				'value' => function( $model )
				{
					$grupo = Paralelos::findOne($model->id_paralelos);
					return $grupo ? $grupo->descripcion : '';
				}, 
			],	
			[
				'attribute'=>'id_aulas',
				'value' => function( $model )
				{
					$aula = Aulas::findOne($model->id_aulas);
					return $aula ? $aula->descripcion : '';
				}, 
			],	
            // 'fecha_ingreso',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
