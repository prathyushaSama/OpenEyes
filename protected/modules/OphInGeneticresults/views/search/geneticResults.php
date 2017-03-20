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
<div class="box admin">
  <h2>Genetic test/result</h2>

  <div class="large-12 column">
      <?php
      $form = $this->beginWidget('BaseEventTypeCActiveForm', array(
          'id' => 'searchform',
          'enableAjaxValidation' => false,
          'focus' => '#search',
          'action' => Yii::app()->createUrl('/OphInGeneticresults/search/geneticResults'),
      )) ?>
    <div class="large-12 column">
      <div class="panel">
        <div class="row">
          <div class="large-12 column">
            <table class="grid">
              <thead>
              <tr>
                <th>Gene</th>
                <th>Method</th>
                <th>Homozygosity</th>
                <th>Effect</th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <td>
                    <?php echo CHtml::dropDownList('gene-id', @$_GET['gene-id'], CHtml::listData(PedigreeGene::model()->findAll(array('order' => 'name asc')), 'id', 'name'),
                        array('empty' => '- All -')) ?>
                </td>
                <td>
                    <?php echo CHtml::dropDownList('method-id', @$_GET['method-id'],
                        CHtml::listData(OphInGeneticresults_Test_Method::model()->findAll(array('order' => 'name asc')), 'id', 'name'), array('empty' => '- All -')) ?>
                </td>
                <td>
                    <?php echo CHtml::dropDownList('homo', @$_GET['homo'], array(1 => 'Yes', 0 => 'No'), array('empty' => '- All -')) ?>
                </td>
                <td>
                    <?php echo CHtml::dropDownList('effect-id', @$_GET['effect-id'],
                        CHtml::listData(OphInGeneticresults_Test_Effect::model()->findAll(array('order' => 'name asc')), 'id', 'name'), array('empty' => '- All -')) ?>
                </td>
              </tr>
              </tbody>
            </table>
            <table class="grid">
              <thead>
              <tr>
                <th>Result date from</th>
                <th>Result date to</th>
                <th>Text search</th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <td>
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'name' => 'date-from',
                        'id' => 'date-from',
                        'options' => array(
                            'showAnim' => 'fold',
                            'dateFormat' => Helper::NHS_DATE_FORMAT_JS,
                        ),
                        'value' => @$_GET['date-from'],
                    )) ?>
                </td>
                <td>
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'name' => 'date-to',
                        'id' => 'date-to',
                        'options' => array(
                            'showAnim' => 'fold',
                            'dateFormat' => Helper::NHS_DATE_FORMAT_JS,
                        ),
                        'value' => @$_GET['date-to'],
                    )) ?>
                </td>
                <td>
                    <?php echo CHtml::textField('query', @$_GET['query']) ?>
                </td>
                <td>
                  <button id="search_tests" class="secondary" type="submit">
                    Search
                  </button>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
      <?php $this->endWidget() ?>
  </div>

  <h2>Genetic test events</h2>

  <form id="admin_sequences">
    <input type="hidden" id="select_all" value="0"/>

      <?php if (count($genetic_tests) < 1) { ?>
        <div class="alert-box no_results">
          <span class="column_no_results">
                  <?php if (@$_GET['query']) { ?>
                    No genetic results were found with the selected criteria.
                  <?php } else { ?>
                    Enter criteria to search for genetic results.
                  <?php } ?>
          </span>
        </div>
      <?php } ?>

      <?php if (!empty($genetic_tests)) { ?>
        <table class="grid">
          <thead>
          <tr>
            <th><?php echo CHtml::link('Result date', $this->getUri(array('sortby' => 'date'))) ?></th>
            <th><?php echo CHtml::link('Hospital no', $this->getUri(array('sortby' => 'hos_num'))) ?></th>
            <th><?php echo CHtml::link('Patient name', $this->getUri(array('sortby' => 'patient_name'))) ?></th>
            <th><?php echo CHtml::link('Gene', $this->getUri(array('sortby' => 'gene'))) ?></th>
            <th><?php echo CHtml::link('Method', $this->getUri(array('sortby' => 'method'))) ?></th>
            <th><?php echo CHtml::link('Homozygosity', $this->getUri(array('sortby' => 'homo'))) ?></th>
            <th><?php echo CHtml::link('Base change', $this->getUri(array('sortby' => 'base_change'))) ?></th>
            <th><?php echo CHtml::link('Amino acid change', $this->getUri(array('sortby' => 'amino_acid_change'))) ?></th>
            <th><?php echo CHtml::link('Result', $this->getUri(array('sortby' => 'result'))) ?></th>
          </tr>
          </thead>
          <tbody>
          <?php
          foreach ($genetic_tests as $i => $test) {
              ?>
            <tr class="clickable" data-uri="<?php echo Yii::app()->createUrl('/OphInGeneticresults/default/view/' . $test->event_id) ?>">
              <td><?php echo $test->NHSDate('result_date') ?></td>
              <td><?php echo $test->event->episode->patient->hos_num ?></td>
              <td><?php echo strtoupper($test->event->episode->patient->last_name) ?>, <?php echo $test->event->episode->patient->first_name ?></td>
              <td><?php echo $test->gene->name ?></td>
              <td><?php echo $test->method->name ?></td>
              <td><?php echo $test->homo ? 'Yes' : 'No' ?></td>
              <td><?php echo $test->base_change ?></td>
              <td><?php echo $test->amino_acid_change ?></td>
              <td><?php echo $test->result ?></td>
            </tr>
          <?php } ?>
          </tbody>
          <tfoot class="pagination-container">
          <tr>
              <td colspan="3">
                  <?php $to = ($pagination->getItemCount() < $pagination->limit) ? $pagination->getItemCount() : ($pagination->limit * ($pagination->getCurrentPage()+1)); ?>
                  Showing <?php echo $pagination->offset + 1; ?> to <?php echo $to; ?> of <?php echo $pagination->getItemCount(); ?>
              </td>
            <td colspan="6">
                <?php
                    $this->widget('CLinkPager', array(
                        'currentPage' => $pagination->getCurrentPage(),
                        'itemCount' => $pagination->getItemCount(),
                        'pageSize' => $pagination->getPageSize(),
                        'maxButtonCount' => 10,
                        'header'=> '',
                        'htmlOptions'=>array('class'=>'pagination right'),
                        'selectedPageCssClass' => 'current'
                    ));
                   ?>
            </td>
          </tr>
          </tfoot>
        </table>
      <?php } ?>
  </form>
</div>