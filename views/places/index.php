<?php

use app\models\Place;
use kartik\select2\Select2;
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
		        'filter' => Select2::widget([
				        'model' => $searchModel,
				        'attribute' => 'id',
				        'data' => yii\helpers\ArrayHelper::map(Place::find()->orderBy('address')->asArray()->all(),'id','address'),
				        'theme' => Select2::THEME_BOOTSTRAP,
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
	        ],
	        [
		        'attribute' => 'lng',
	        ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {calculate}',
                'buttons' => [
                    'calculate' => function($url, $model, $key){
                        if ($model->is_calculated)
	                        return Html::a('<span class="btn btn-success">Distances ready</span>', ['distance/index', 'from_id' => $model->id]);
                        else
                            return Html::a('<span class="btn btn-primary">Calculate distances</span>', $url);
                    }
                ],
            ],
        ],
    ]); ?>
	<?php //Pjax::end(); ?>
</div>
