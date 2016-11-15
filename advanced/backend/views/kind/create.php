<?php
/**
 * Created by PhpStorm.
 * User: liyu
 * Date: 2016/11/14/0014
 * Time: 下午 5:00
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class = "kind-form">
    <?php $form = ActiveForm::begin(); ?>
    <?=$form->field($model, 'name')->textInput(['maxlength' => true])?>
    <?= $form->field($model, 'pid')->dropDownList($list)?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
