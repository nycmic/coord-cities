<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchDistance */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Distances from place:'.' '.$searchModel->placeFrom->address;
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
	            'attribute'=>'distance',
	            'label' => 'Distance Km',
                'filter' => false,
                'value' => function ($model) {
                    return Yii::$app->formatter->asInteger($model->distance).' km';
		        }
            ],



//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php //Pjax::end(); ?>
</div>
