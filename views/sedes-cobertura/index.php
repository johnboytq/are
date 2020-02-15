<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SedesCoberturaBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sedes Coberturas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sedes-cobertura-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sedes Cobertura', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_sede',
            'id_tema',
            'ninos',
            'ninas',
            //'observaciones',
            //'estado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
