<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Place */
/* @var $form yii\widgets\ActiveForm */
?>




<div class="place-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'address')->widget('\app\widgets\MapWidget', [
		'options' => ['id' => 'coords-input'],

	]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>