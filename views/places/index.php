<?php

use app\models\Place;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchPlace */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Places';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="place-index">

    <h1><?= Html::encode($this->title) ?></h1>
	<?php //Pjax::begin(); ?>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Place', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
	        [
		        'attribute' => 'address',
		        'filter' => \kartik\select2\Select2::widget([
				        'model' => $searchModel,
				        'attribute' => 'id',
				        'data' => yii\helpers\ArrayHelper::map(Place::find()->orderBy('address')->asArray()->all(),'id','address'),
				        'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
				        'hideSearch' => false,
                        'options' => ['placeholder' => 'Find place...'],
				        'pluginOptions' => [
					        'allowClear' => true,
				        ],
                ]
                ),
	        ],
	        [
		        'attribute' => 'lat',
//		        'filter' => false
	        ],
	        [
		        'attribute' => 'lng',
//		        'filter' => false
	        ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {calculate}',
                'buttons' => [
                    'calculate' => function($url, $model, $key){
                        return Html::a('<span class="btn btn-success">Calculate distances</span>', $url);
                    }
                ],
            ],
        ],
    ]); ?>
	<?php //Pjax::end(); ?>
</div>
