<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchDistance */
/* @var $dataProvider yii\data\ActiveDataProvider */
$fromName = $searchModel->placeFrom->address?$searchModel->placeFrom->address: '';

$this->title = 'Distances from place:'.' '.$fromName;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="distance-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
		<?= Html::a('Create Place', ['places/create'], ['class' => 'btn btn-success']) ?>

        <?= Html::a('Show Places', ['places/index'], ['class' => 'btn btn-success']) ?>
    </p>

    <p>

        <?php //echo  Html::a('Create Distance', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
	        [
	                'label' => 'To place',
		        'attribute' => 'to_id',
		        'filter' => \kartik\select2\Select2::widget([
				        'model' => $searchModel,
				        'attribute' => 'to_id',
				        'data' => yii\helpers\ArrayHelper::map(\app\models\Place::find()->orderBy('address')->asArray()->all(),'id','address'),
				        'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
				        'hideSearch' => false,
				        'options' => ['placeholder' => 'Find place...'],
				        'pluginOptions' => [
					        'allowClear' => true,
				        ],
			        ]
		        ),
		        'value' => 'placeTo.address',
	        ],
	        [
		        'attribute' => 'from_id',
		        'value' => 'placeFrom.address',
                'visible' => false
	        ],
	        [
		        'attribute' => 'to_id',
		        'value' => 'placeTo.address',
                'visible' => false
	        ],
            [
	            'attribute'=>'distance',
	            'label' => 'Distance Km',
                'filter' => false,
                'value' => function ($model) {
                    return Yii::$app->formatter->asInteger($model->distance).' km';
		        }
            ],



            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php //Pjax::end(); ?>
</div>
