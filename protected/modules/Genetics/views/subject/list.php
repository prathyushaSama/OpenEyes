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

<div class="admin box">
    <h2>Patients</h2>

    <div class="search-form">
        <?php $this->renderPartial('_list_search',array(
            'model' => $model,
        ));  ?>
    </div><!-- search-form -->

    <?php
    $dataProvider = $model->search();
    $item_count = GeneticsPatient::model()->count();

    //we do not display any results until the user click on the search button - and post his/her query
    if( !Yii::app()->request->getQuery('GeneticsPatient')){
        $criteria = $dataProvider->getCriteria();
        $criteria->addCondition("1 != 1");
        $dataProvider->setCriteria($criteria);
    }

    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'geneticspatient-list-view',
        'dataProvider' => $dataProvider,
        'template' => '{items}{summary}{pager}',
        'summaryCssClass' => 'left table-summary',
        'itemsCssClass' => 'grid',
        'summaryText' => 'Showing {start} to {end} of {count}',
        'pager' => array(
            'header' => '',
            'selectedPageCssClass' => 'current',
            'htmlOptions' => array('class' => 'pagination right'),
        ),
        'emptyText' => 'Total of ' . $item_count . ' items',
        "emptyTagName" => 'span',

        //click on a row - only one row can be selected
        'selectableRows' => 1,

        //here we say what should happen when a row selected
        'selectionChanged'=>'function(id){ location.href = "'.$this->createUrl('view').'/id/"+$.fn.yiiGridView.getSelection(id);}',

        'rowCssClass' => ['clickable'],

        'columns' => array(
            array(
                'name' => 'id',
                'htmlOptions'=>array('width'=>'50px'),
            ),
            array(
                'name' => 'patient.fullName',
                'htmlOptions'=>array('width'=>'110px'),
            ),
         //   'patient.dob',
            array(
                'name' => 'patient.dob',
                'value' => function($data){
                    $date = new DateTime($data->patient->dob);
                    return $data->patient->dob ? $date->format("j M Y") : null;
                },
                'htmlOptions'=>array('width'=>'85px'),
            ),

            array(
                'name' => 'comments',
                'htmlOptions'=>array('width'=>'150px'),
            ),
            array(
                'name' => 'diagnoses',
                'value' => function($data){
                    return implode(', ', $data->diagnoses);
                },
                'htmlOptions'=>array('width'=>'200px'),
            ),


        ),
    ));
    ?>

</div>