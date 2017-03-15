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

<div id="contact">
	<?php
	$this->renderPartial('../contact/_form', array(
		'model' => $this->patient->contact
	));
	?>
</div>

<div id=addresses>
	<?php
	$addressIndex = 0;
	foreach($this->patient->contact->addresses as $id => $address):
		$this->renderPartial('../address/_form', array(
			'model' => $address,
			'index' => $id,
			'display' => 'block',
		));
	++$addressIndex;
	endforeach;
	?>
</div>

<div class="row data-row">
	<div class="large-4 column">
		<div class="data-label"><?php echo CHtml::activeLabelEx($this->patient, 'dob'); ?></div>
	</div>
	<div class="large-8 column">
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
	</div>
</div>

<div class="row data-row">
	<div class="large-4 column">
		<div class="data-label"><?php echo CHtml::activeLabelEx($this->patient, 'date_of_death'); ?></div>
	</div>
	<div class="large-8 column">
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
	</div>
</div>

<div class="row data-row">
	<div class="large-4 column">
		<div class="data-label"><?php echo CHtml::activeLabelEx($this->patient, 'gender'); ?></div>
	</div>
	<div class="large-8 column">
		<?php echo CHtml::activeDropDownList($this->patient, 'gender', Patient::getGenderArray(), array('empty' => '')); ?>
	</div>
</div>

<div class="row data-row">
	<div class="large-4 column">
		<div class="data-label"><?php echo CHtml::activeLabelEx($this->patient, 'ethnic_group_id'); ?></div>
	</div>
	<div class="large-8 column">
		<?php echo CHtml::activeDropDownList($this->patient, 'ethnic_group_id', CHtml::listData(EthnicGroup::model()->findAll(array('order' => 'display_order')), 'id', 'name'), array('empty' => '')); ?>
	</div>
</div>

<div class="row data-row">
	<div class="large-4 column">
		<div class="data-label"><?php echo CHtml::activeLabelEx($this->patient, 'hos_num'); ?></div>
	</div>
	<div class="large-8 column">
		<?php echo CHtml::activeTextField($this->patient, 'hos_num')?>
	</div>
</div>

<div class="row data-row">
	<div class="large-4 column">
		<div class="data-label"><?php echo CHtml::activeLabelEx($this->patient, 'nhs_num'); ?></div>
	</div>
	<div class="large-8 column">
		<?php echo CHtml::activeTextField($this->patient, 'nhs_num')?>
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
