<?php
/**
 * OpenEyes.
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link http://www.openeyes.org.uk
 *
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */
?>

<?php
//$clinical = $clinical = $this->checkAccess('OprnViewClinical');

//$warnings = $this->patient->getWarnings($clinical);
//$warnings = array_merge($this->patient->errors, $contact->errors, $address->errors);
//var_dump($this->patient->errors);
$warnings = null;
?>

<div class="box patient-info">
	<div class="row">
		<div class="large-6 column">

			<?php /*if ($this->checkAccess('OprnEditPatientInfo')) {*/ ?>

			<?php if ($this->patient->errors || $this->patient->contact->errors) { ?>
				<div class="row">
					<div class="large-12 column">
						<div class="alert-box patient with-icon">
							<?php /*foreach ($warnings as $warn) {?>
								<strong><?php echo $warn[0]; ?></strong>
							<?php } */?>
							<?php echo CHtml::errorSummary($this->patient); ?>
							<?php echo CHtml::errorSummary($this->patient->contact, ''); ?>
							<?php /* echo CHtml::errorSummary($address, ''); */ ?>
						</div>
					</div>
				</div>
			<?php }?>
			<?php /*echo CHtml::errorSummary($this->patient);*/ ?>
			<?php
	                $form = $this->beginWidget('FormLayout', array(
	                    'id' => 'create-patient',
	                    'enableAjaxValidation' => false,
	                    //'htmlOptions' => array('class' => 'form add-data'),
	                    //'action' => array('patient/addAllergy'),
	                    /*'layoutColumns' => array(
	                        'label' => 3,
	                        'field' => 9,
	                    ),*/
	                ))?>

<div id="contact">
	<?php
	$this->renderPartial('../contact/_form', array(
		'model' => $this->patient->contact
	));
	?>
</div>


 <?php
    echo CHtml::link('Add Address', '#', array('id' => 'loadAddressByAjax'));
   ?>

<div id=addresses>
	<?php
	$addressIndex = 0;
	foreach($this->patient->contact->addresses as $id => $address):
		$this->renderPartial('../address/_form', array(
			'model' => $address,//$this->patient->contact->address
			'index' => $id,
			'display' => 'block',
		));
	++$addressIndex;
	endforeach;
	?>
</div>

<?php /*?>
<div id="address">
			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo $form->labelEx($address, 'address1'); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeTextField($address, 'address1')?>
					<?php /*echo CHtml::error($address, 'address1');* / ?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeTextField($address, 'address2')?>
					<?php /*echo CHtml::error($address, 'address2');* / ?>
				</div>
			</div>


			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo $form->labelEx($address, 'city'); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeTextField($address, 'city')?>
					<?php /*echo CHtml::error($address, 'city');* / ?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo $form->labelEx($address, 'postcode'); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeTextField($address, 'postcode')?>
					<?php /*echo CHtml::error($address, 'postcode');* / ?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo $form->labelEx($address, 'county'); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeTextField($address, 'county')?>
					<?php /*echo CHtml::error($address, 'county');* / ?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo $form->labelEx($address, 'country'); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeDropDownList($address, 'country_id', CHtml::listData(Country::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '')); ?>
					<?php /*echo CHtml::error($address, 'country_id');* / ?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo $form->labelEx($address, 'email'); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeEmailField($address, 'email')?>
					<?php /*echo CHtml::error($address, 'email');* / ?>
				</div>
			</div>
</div> */ ?>
			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo $form->labelEx($this->patient, 'dob'); ?></div>
				</div>
				<div class="large-8 column">
					<?php /*echo CHtml::activeDateField($this->patient, 'dob')*/?>
					<?php
						$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						    'model' => $this->patient,
						    'attribute' => 'dob',
						    'htmlOptions' => array(
						        'size' => '10',         // textField size
						        'maxlength' => '10',    // textField maxlength
						    ),
						));
						?>
					<?php /*echo CHtml::error($this->patient, 'dob');*/ ?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo $form->labelEx($this->patient, 'date_of_death'); ?></div>
				</div>
				<div class="large-8 column">
					<?php /*echo CHtml::activeDateField($this->patient, 'date_of_death')*/?>
					<?php
						$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						    'model' => $this->patient,
						    'attribute' => 'date_of_death',
						    'htmlOptions' => array(
						        'size' => '10',         // textField size
						        'maxlength' => '10',    // textField maxlength
						    ),
						));
						?>
					<?php /*echo CHtml::error($this->patient, 'date_iof_death');*/ ?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo $form->labelEx($this->patient, 'gender'); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeDropDownList($this->patient, 'gender', Patient::getGenderArray(), array('empty' => '')); ?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo $form->labelEx($this->patient, 'ethnic_group_id'); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeDropDownList($this->patient, 'ethnic_group_id', CHtml::listData(EthnicGroup::model()->findAll(array('order' => 'display_order')), 'id', 'name'), array('empty' => '')); ?>
					<?php /*echo CHtml::error($this->patient, 'ethnic_group_id');*/ ?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo $form->labelEx($this->patient, 'hos_num'); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeTextField($this->patient, 'hos_num')?>
					<?php /* echo CHtml::error($this->patient, 'hos_num'); */ ?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo $form->labelEx($this->patient, 'nhs_num'); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeTextField($this->patient, 'nhs_num')?>
					<?php /* echo CHtml::error($this->patient, 'nhs_num'); */ ?>
				</div>
			</div>

			<div style="clear:both;"></div>
			<div class="row buttons">
				<?php echo CHtml::submitButton($this->patient->isNewRecord ? 'Create' : 'Save'); ?>
			</div>

			<?php $this->endWidget()?>

		</div>
	</div>
</div>


<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('loadAddress', '
var _index = ' . $addressIndex . ';
$("#loadAddressByAjax").click(function(e){
    e.preventDefault();
    var _url = "' . Yii::app()->controller->createUrl("loadAddressByAjax", array("load_for" => $this->action->id)) . '&index="+_index;
    $.ajax({
        url: _url,
        success:function(response){
            $("#addresses").append(response);
            $("#addresses .crow").last().animate({
                opacity : 1,
                left: "+50",
                height: "toggle"
            });
        }
    });
    _index++;
});
', CClientScript::POS_END);
?>