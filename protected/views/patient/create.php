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

<section class="box patient-info js-toggle-container">
	<div class="js-toggle-body">
		<div class="row">
			<div class="large-6 column">

				<?php if ($this->patient->errors || $this->patient->contact->errors) { ?>
					<div class="row">
						<div class="large-12 column">
							<div class="alert-box patient with-icon">
								<?php echo CHtml::errorSummary($this->patient); ?>
								<?php echo CHtml::errorSummary($this->patient->contact, ''); ?>
								<?php foreach($this->patient->contact->addresses as $index => $address): ?>
									<?php echo CHtml::errorSummary($address, ''); ?>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				<?php } ?>
				<?php
					$form = $this->beginWidget('FormLayout', array(
						'id' => 'create-patient',
						'enableAjaxValidation' => false,
				))?>

				<?php
				$this->renderPartial('../patient/_form', array(
					'model' => $this->patient
				));
				?>

				<div style="clear:both;"></div>
				<div class="row buttons">
					<?php echo CHtml::submitButton($this->patient->isNewRecord ? 'Create' : 'Save'); ?>
					<?php if(!$this->patient->isNewRecord): ?>
						&nbsp;
						<?php echo CHtml::link('Cancel', array('/patient/view/' . $this->patient->id)); ?>
					<?php endif; ?>
				</div>

				<?php $this->endWidget()?>
			</div>
		</div>
	</div>
</section>
