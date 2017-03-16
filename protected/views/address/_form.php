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

<?php echo CHtml::activeHiddenField($model, "[{$index}]id")?>

<?php echo CHtml::activeHiddenField($model, "[{$index}]address_type_id"); ?>

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
