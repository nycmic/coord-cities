<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Distance */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="distance-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'from_id')->textInput() ?>

    <?= $form->field($model, 'to_id')->textInput() ?>

    <?= $form->field($model, 'distance')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
