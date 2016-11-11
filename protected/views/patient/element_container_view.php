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
  
    .open-eyes button.event-action, .open-eyes a.event-action {
        margin-left: 0;
        padding-top: 0;
        border-radius: 0;
        letter-spacing: 0;
        text-shadow: none;
        box-shadow: none;
        border: none;
        height: 30px;
        line-height: 30px;
        text-align: center;
        font-weight: 400;
        font-size: 12px;
        font-size: 0.75rem; 
    }
    
    .open-eyes button.event-action:hover, .open-eyes button.event-action:active, .open-eyes a.event-action:hover, .open-eyes a.event-action:active {
    background-color: #207c24;
    text-shadow: none; 
    }
  .open-eyes button.event-action .oe-btn-icon.history, .open-eyes a.event-action .oe-btn-icon.history {
    display: inline-block;
    padding: 0px !important;
    margin: 0px !important;
    height: 20px !important;
    width: 36px;
    background: transparent url("<?php echo Yii::app()->assetManager->createUrl('img/audit-trail.png')?>") left center no-repeat; 

  }
  .open-eyes button.event-action .oe-btn-icon.history.hide, .open-eyes a.event-action .oe-btn-icon.history.hide {
      background-position: right center; 
  }

    
    
</style>


<?php
    $diffVersions = array();
    if( $data['displayHistoryEnabled'] !== false ){
        $event_id = $element -> event -> id;

        $versions = $element -> getPreviousModificationsHeader($event_id);
        $versions[]['version_id'] = -1; // active version +1 !
        $versionCount = count($versions)-1; 
            
        for($i = $versionCount; $i > 0 ; $i--)
        {
            if( $i==$versionCount ){
                $version1 = $element;
            } else {
                $version1 = $element -> getVersion($versions[$i]['version_id']);
            }
            
            $version2 = $element -> getVersion($versions[$i-1]['version_id']);
            $hasDiff = $element -> hasDiffVersions($version1,$version2);
            
            if($hasDiff)
            {
                $diffVersions[$versions[$i-1]['version_id']] = $version2;
            } 
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
			<?php if ( count($diffVersions) > 0 && $data['displayHistoryEnabled'] !== false ) { ?>
             <a 
                class="event-action small button right displayPreviousModifications enabled"
                title="Show previous modifications"
             >
                <div class="oe-btn-icon history text-right"><?php echo count($diffVersions) ?></div>
             </a>
         <?php } ?>
		</header>
	<?php } ?>
	<?php echo $content;?>
	<div class="sub-elements">
		<?php $this->renderChildOpenElements($element, 'view', @$form, @$data)?>
	</div>
</section>
