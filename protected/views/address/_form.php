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

<div class="js-toggle-body">
	<div class="row">
		<div class="large-6 column">

			<?php //var_dump($model);
				if (isset($model->errors) && $model->errors) { ?>
				<div class="row">
					<div class="large-12 column">
						<div class="alert-box patient with-icon">
							<?php echo CHtml::errorSummary($model); ?>
						</div>
					</div>
				</div>
			<?php }?>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo CHtml::activeLabelEx($model, "[{$index}]address_type_id"); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeDropDownList($model, "[{$index}]address_type_id", CHtml::listData(AddressType::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '')); ?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo CHtml::activeLabelEx($model, "[{$index}]address1"); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeTextField($model, "[{$index}]address1")?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeTextField($model, "[{$index}]address2")?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo CHtml::activeLabelEx($model, "[{$index}]city"); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeTextField($model, "[{$index}]city")?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo CHtml::activeLabelEx($model, "[{$index}]postcode"); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeTextField($model, "[{$index}]postcode")?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo CHtml::activeLabelEx($model, "[{$index}]county"); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeTextField($model, "[{$index}]county")?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo CHtml::activeLabelEx($model, "[$index}]country_id"); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeDropDownList($model, "[{$index}]country_id", CHtml::listData(Country::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '')); ?>
				</div>
			</div>

			<div class="row data-row">
				<div class="large-4 column">
					<div class="data-label"><?php echo CHtml::activeLabelEx($model, "[{$index}]email"); ?></div>
				</div>
				<div class="large-8 column">
					<?php echo CHtml::activeEmailField($model, "[{$index}]email")?>
				</div>
			</div>

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
