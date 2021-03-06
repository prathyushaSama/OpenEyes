<?php
/**
 * (C) OpenEyes Foundation, 2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link http://www.openeyes.org.uk
 *
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (C) 2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */
?>
<div id="episode-summary" class="box admin">
	<div id="draggablelist">
         <h2>Custom episode summaries</h2>
         <?= CHtml::beginForm(array('/admin/updateEpisodeSummary'), 'post'); ?>
             <?= CHtml::label('Subspecialty', 'subspecialty_id'); ?>
             <?= CHtml::dropDownList('subspecialty_id', $subspecialty_id, CHtml::listData(Subspecialty::model()->findAll(), 'id', 'name', 'specialty.name'), array('empty' => 'Default')); ?>
             <?= CHtml::hiddenField('item_ids'); ?>
             <div id="draggablelist-items" class="row">
                 <div class="large-6 column">
                     <h2>Enabled items</h2>
                     <?php $this->renderPartial('_episodeSummaries_table', array('id' => 'draggablelist-items-enabled', 'items' => $enabled_items)); ?>
                     <div class="right">
                         <button class="small" type="submit">Save</button>
                         <button id="draggablelist-cancel" class="small warning" type="button">Cancel</button>
                     </div>
                 </div>
                <div class="large-6 column">
                    <h2>Available items</h2>
                     <?php $this->renderPartial('_episodeSummaries_table', array('id' => 'draggablelist-items-available', 'items' => $available_items)); ?>
                 </div>
             </div>
         <?= CHtml::endForm(); ?>
     </div>
</div>
