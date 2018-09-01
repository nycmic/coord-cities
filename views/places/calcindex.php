<?php

use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchPlace */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $place string */
$this->title = 'Places';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="place-index">

    <h1><?= Html::encode($this->title) ?></h1>
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
						'data' => yii\helpers\ArrayHelper::map(\app\models\Place::find()->asArray()->all(),'address','address'),
						'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
						'hideSearch' => false,
						'options' => ['placeholder' => 'Choose your place...', 'onchange' => ''],
						'pluginOptions' => [
							'allowClear' => true,
						],
					]
				),
			],
			[
				'label' => 'Distance km',
				'enableSorting' => true,
				'value' => function ($model) {
					return Yii::$app->formatter->asInteger($model->prepareDistanceInKm()).'km';
				}
			],

			['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>
</div>
