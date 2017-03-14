<div class="js-toggle-body">
<div class="row">
<div class="large-6 column">

<?php //var_dump($model);
if (isset($model->errors) && $model->errors) { ?>
				<div class="row">
					<div class="large-12 column">
						<div class="alert-box patient with-icon">
							<?php /*foreach ($warnings as $warn) {?>
								<strong><?php echo $warn[0]; ?></strong>
							<?php } */?>
							<?php echo CHtml::errorSummary($model); ?>
							<?php /* echo CHtml::errorSummary($address, ''); */ ?>
						</div>
					</div>
				</div>
			<?php }?>
			<?php
	               /* $form = $this->beginWidget('FormLayout', array(
	                    'id' => 'contact-form',
	                    'enableAjaxValidation' => false,
	                ))*/?>


			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo CHtml::activeLabelEx($model, "[{$index}]address_type_id"); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeDropDownList($model, "[{$index}]address_type_id", CHtml::listData(AddressType::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '')); ?>
					<?php /*echo CHtml::error($contact, 'first_name');*/ ?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo CHtml::activeLabelEx($model, "[{$index}]address1"); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeTextField($model, "[{$index}]address1")?>
					<?php /*echo CHtml::error($contact, 'first_name');*/ ?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeTextField($model, "[{$index}]address2")?>
					<?php /*echo CHtml::error($contact, 'last_name');*/ ?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo CHtml::activeLabelEx($model, "[{$index}]city"); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeTextField($model, "[{$index}]city")?>
					<?php /*echo CHtml::error($contact, 'first_name');*/ ?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo CHtml::activeLabelEx($model, "[{$index}]postcode"); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeTextField($model, "[{$index}]postcode")?>
					<?php /*echo CHtml::error($contact, 'first_name');*/ ?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo CHtml::activeLabelEx($model, "[{$index}]county"); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeTextField($model, "[{$index}]county")?>
					<?php /*echo CHtml::error($contact, 'first_name');*/ ?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo CHtml::activeLabelEx($model, "[$index}]country_id"); ?></div>
				</div>
				<div class="large-8 column">
					<?php /*echo CHtml::activeTextField($model, 'country')*/?>
					<?php echo CHtml::activeDropDownList($model, "[{$index}]country_id", CHtml::listData(Country::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '')); ?>
					<?php /*echo CHtml::error($contact, 'first_name');*/ ?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo CHtml::activeLabelEx($model, "[{$index}]email"); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeEmailField($model, "[{$index}]email")?>
					<?php /*echo CHtml::error($address, 'email');*/ ?>
				</div>
			</div>

			<?php /* $this->endWidget() */?>

			<div class="row" style="width:100px;float: left;">
	        	<br/>
		        <?php echo CHtml::link('Delete', '#', array('onclick' => 'deleteAddress(this, ' . $index . '); return false;')); ?>
		    </div>

		</div>
	</div>
</div>

<?php
Yii::app()->clientScript->registerScript('deleteAddress', "
function deleteAddress(elm, index)
{
    element=$(elm).parent().parent();
    /* animate div */
    $(element).animate(
    {
        opacity: 0.25,
        left: '+=50',
        height: 'toggle'
    }, 500,
    function() {
        /* remove div */
        $(element).remove();
    });
}", CClientScript::POS_END);
