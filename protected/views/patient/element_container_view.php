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

<style>
  .highlighted_red{
    color: red;  
  }
  .open-eyes button.event-action:hover, .open-eyes button.event-action:active, .open-eyes a.event-action:hover, .open-eyes a.event-action:active {
    background-color: #207c24;
    text-shadow: none; }
  .open-eyes button.event-action .oe-btn-icon.audit, .open-eyes a.event-action .oe-btn-icon.audit {
    display: inline-block;
    padding: 0;
    margin: 0;
    height: 18px;
    width: 36px;
    background: transparent url("<?php echo Yii::app()->assetManager->createUrl('img/audit-trail.png')?>") left center no-repeat; 
  }
  .open-eyes button.event-action .oe-btn-icon.audit.hide, .open-eyes a.event-action .oe-btn-icon.audit.hide {
      background-position: right center; 
  }
    
    
    
</style>


<?php
    $versions = array();
    if( $data['displayHistoryEnabled'] !== false ){
        $eventId = $element -> event -> id;
        $versions = $element -> getPreviousModificationsHeader($eventId);
        $modifiers = '';
    
        if(is_array($versions) && !empty($versions)){
            foreach($versions as $key => $oneVersion){
                $modifiers .= 
                    $oneVersion['first_name'].' '.
                    $oneVersion['last_name'].' '. 
                    Helper::convertMySQL2NHS($oneVersion['last_modified_date']).
                    ' at '.date('H:i', strtotime($oneVersion['last_modified_date'])).
                    '<br>';
            }
        } else {
            $modifiers = 'nobody';
        }
             
    }
?>

<section
	class="<?php if (@$child) {?>sub-<?php }?>element <?php echo CHtml::modelName($element->elementType->class_name)?>"
	data-element-type-id="<?php echo $element->elementType->id?>"
	data-element-type-class="<?php echo $element->elementType->class_name?>"
	data-element-type-name="<?php echo $element->elementType->name?>"
	data-event-id="<?php echo $element -> event -> id?>"
	data-element-display-order="<?php echo $element->elementType->display_order?>">
	<?php if (!preg_match('/\[\-(.*)\-\]/', $element->elementType->name)) { ?>
		<header class="<?php if (@$child) { ?>sub-<?php } ?>element-header">
			<h3 class="<?php if (@$child) { ?>sub-<?php } ?>element-title"><?php echo $element->elementType->name ?></h3>
			<?php if ( count($versions) > 0 && $data['displayHistoryEnabled'] !== false ) { ?>
             <a 
                class="event-action small button right displayPreviousModifications enabled"
                title="Show previous modifications"
             >
                <span class="oe-btn-icon audit"></span>
             </a>
			    
			    
			    <!--button 
			        type="button"
			        id="show-previous-modifications"
			        class="button tiny right secondary active displayPreviousModifications enabled"
			        title="Show previous modifications"
			    >History (<?php echo count($versions) ?>)</button-->
            
         <?php } ?>
		</header>
	<?php } ?>
	<?php echo $content;?>
	<div class="sub-elements">
		<?php $this->renderChildOpenElements($element, 'view', @$form, @$data)?>
	</div>
</section>
