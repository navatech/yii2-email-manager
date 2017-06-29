<?php
use navatech\email\components\EmailManager;
use navatech\email\models\EmailTemplate;
use navatech\roxymce\widgets\RoxyMceWidget;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View          $this
 * @var EmailTemplate $model
 * @var ActiveForm    $form
 */
?>

<div class="email-template-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'shortcut')->textInput(['maxlength' => 255]) ?>
	<?= $form->field($model, 'language')->dropDownList(array_combine(EmailManager::getInstance()->languages, EmailManager::getInstance()->languages)) ?>
	<?= $form->field($model, 'from')->textInput(['maxlength' => 255]) ?>
	<?= $form->field($model, 'subject')->textInput(['maxlength' => 255]) ?>

	<?= $form->field($model, 'text', ['enableClientValidation' => false])->widget(RoxyMceWidget::className()) ?>

	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? Yii::t('email', 'Create') : Yii::t('email', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>