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

<?php echo CHtml::activeHiddenField($this->patient, 'id')?>

<section class="box patient-info js-toggle-container">
    <h3 class="box-title">Personal Details:</h3>

    <div id="contact">

        <?php echo CHtml::activeHiddenField($this->patient->contact, 'id')?>

        <div class="row data-row">
            <div class="large-4 column">
                <div class="data-label"><?php echo CHtml::activeLabelEx($this->patient->contact, 'first_name'); ?></div>
            </div>
            <div class="large-8 column">
                <?php echo CHtml::activeTextField($this->patient->contact, 'first_name')?>
            </div>
        </div>

        <div class="row data-row">
            <div class="large-4 column">
                <div class="data-label"><?php echo CHtml::activeLabelEx($this->patient->contact, 'last_name'); ?></div>
            </div>
            <div class="large-8 column">
                <?php echo CHtml::activeTextField($this->patient->contact, 'last_name')?>
            </div>
        </div>
    </div>

    <div class="row data-row">
        <div class="large-4 column">
            <div class="data-label"><?php echo CHtml::activeLabelEx($this->patient, 'dob'); ?></div>
        </div>
        <div class="large-8 column">
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'name' => 'Patient[dob]',
                    'id' => 'patient_dob',
                    'options' => array(
                        'showAnim' => 'fold',
                        'dateFormat' => Helper::NHS_DATE_FORMAT_JS,
                    ),
                    'value' => $this->patient->NHSDate('dob'),
                    'htmlOptions' => array(
                        'class' => 'small fixed-width',
                    ),
                )) ?>
        </div>
    </div>

    <div class="row data-row">
        <div class="large-4 column">
            <div class="data-label"><?php echo CHtml::activeLabelEx($this->patient, 'gender'); ?></div>
        </div>
        <div class="large-3 column left">
            <?php echo CHtml::activeDropDownList($this->patient, 'gender', Patient::getGenderArray(), array('empty' => '')); ?>
        </div>
    </div>

    <div id="contact">
        <div class="row data-row">
            <div class="large-4 column">
                <div class="data-label"><?php echo CHtml::activeLabelEx($this->patient->contact, 'primary_phone'); ?></div>
            </div>
            <div class="large-4 column left">
                <?php echo CHtml::activeTextField($this->patient->contact, 'primary_phone')?>
            </div>
        </div>
    </div>

    <div class="row data-row">
        <div class="large-4 column">
            <div class="data-label"><?php echo CHtml::activeLabelEx($this->patient, 'nhs_num'); ?></div>
        </div>
        <div class="large-4 column left">
            <?php echo CHtml::activeTextField($this->patient, 'nhs_num')?>
        </div>
    </div>
</section>
<section class="box patient-info js-toggle-container">
    <h3 class="box-title">Home Address:</h3>

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
</section>
<section class="box patient-info js-toggle-container">
    <h3 class="box-title">Other Details:</h3>
    <div class="row data-row">
        <div class="large-4 column">
            <div class="data-label"><?php echo CHtml::activeLabelEx($this->patient, 'hos_num'); ?></div>
        </div>
        <div class="large-8 column">
            <?php echo CHtml::activeTextField($this->patient, 'hos_num')?>
        </div>
    </div>
</section>

