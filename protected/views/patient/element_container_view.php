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

<!--style>
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
</style-->

<style>
    .highlighted_red{
      color: red;  
    }
    .event-content .oe-prev-mods-icon {
      display: inline-block;
      margin: 8px 5px 0 0;
      font-size: 11px;
      font-size: 0.6875rem;
      font-weight: 500;
      text-align: right;
      width: 35px;
      height: 16px;
      line-height: 16px;
      color: #666;
      background: transparent url("<?php echo Yii::app()->assetManager->createUrl('img/audit-trail-element.png')?>") left top no-repeat; 
    }
    
    .event-content .oe-prev-mods-icon:hover {
      
      background: transparent url("<?php echo Yii::app()->assetManager->createUrl('img/audit-trail-element.png')?>") left bottom no-repeat; 
      font-size: 11px;
      font-size: 0.6875rem;
      color: #0a62d3; 
    }
    
    .open-eyes button.event-action .oe-btn-icon.audit, .open-eyes a.event-action .oe-btn-icon.audit {
      display: inline-block;
      padding: 0;
      margin: 0;
      height: 38px;
      width: 36px;
      font-size: 11px;
      font-size: 0.6875rem;
      text-indent: 500px;
      background: transparent url("url("<?php echo Yii::app()->assetManager->createUrl('img/audit-trail-element.png')?>")") left center no-repeat; 
    }
    
    .open-eyes button.event-action .oe-btn-icon.audit.hide, .open-eyes a.event-action .oe-btn-icon.audit.hide {
      background-position: right center; 
    }
</style>


<?php
    /* SPECIAL VIEWS
    1. Visual acuity
    2. Past ophthalmic history
    3. Ophthalmic medications
    4. Allergies
    */
    
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
			        class="oe-prev-mods-icon displayPreviousModifications enabled right"
			        title="Show previous modifications"
			    ><?php echo count($diffVersions) ?>
			    </a>   
         <?php } ?>
		</header>
	<?php } ?>
	<?php echo $content;?>
	<div class="sub-elements">
		<?php $this->renderChildOpenElements($element, 'view', @$form, @$data)?>
	</div>
</section>
