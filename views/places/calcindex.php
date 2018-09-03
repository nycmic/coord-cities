<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchPlace */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $place string */
$this->title = 'Places';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="place-index">

    <h1><?= Html::encode($this->title) ?></h1>
	<?php //Pjax::begin(); ?>
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
						'data' => yii\helpers\ArrayHelper::map(\app\models\Place::find()->asArray()->all(),'id','address'),
						'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
						'hideSearch' => false,
						'options' => ['placeholder' => 'Choose your place...', 'value' => Yii::$app->request->get('SearchPlace')['id']],
						'pluginOptions' => [
							'allowClear' => true,
						],
					]
				),
			],
//			[
//				'attribute'=>'distance',
//				'label' => 'Distance Km',
//				'filter' => false
//			],
			[
				'attribute' => 'distance',
				'value' => 'distance.distance',
				'filter' => false
			],
			[
				'label' => 'Distance km',
				'enableSorting' => true,
				'value' => function ($model) {
//					return Yii::$app->formatter->asInteger($model->distance).'km';
				}
			],

			['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>

    <?php //Pjax::end()?>
</div>
