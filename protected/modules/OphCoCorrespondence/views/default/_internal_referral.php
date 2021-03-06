
<section class="element required internal-referral-section" style="border: 1px solid #fafafa;">

    <header class="element-header" style="background-color: #fafafa">

        <!-- Element title -->
        <h3 class="element-title">Internal Referral</h3>

    </header>

    <div class="element-fields">
        <div class="row">
            <div class="large-2 column">
                <label>To Service:* </label>
            </div>
            <div class="large-3 column">
                    <?php echo CHtml::activeDropDownList($element, "to_subspecialty_id",
                                    CHtml::listData(Subspecialty::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '- None -')) ?>
            </div>

            <div class="large-1 column">&nbsp;</div>

            <div class="large-2 column">
                <label>For Consultant: </label>
            </div>
            <div class="large-3 column end">
                    <?php echo CHtml::activeDropDownList($element, "to_firm_id", Firm::model()->getListWithSpecialties(), array('empty' => '- None -')) ?>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="large-2 column">
                <label>To Location:* </label>
            </div>

            <div class="large-3 column">
                <?php
                    $site_id = Yii::app()->session['selected_site_id'];

                    if(!$element->to_location_id){
                        $to_location = OphCoCorrespondence_InternalReferral_ToLocation::model()->findByAttributes(array('site_id' => $site_id));
                        $element->to_location_id = $to_location ? $to_location->id : null;
                    }

                    echo CHtml::activeDropDownList($element, "to_location_id",
                        $element->getToLocations(true), array('empty' => '- None -')) ?>
            </div>

            <div class="large-1 column">&nbsp;</div>

            <div class="large-2 column "> <label>Condition:* </label> </div>

            <div class="large-3 column end">
                <?php


                    $this->widget('application.widgets.RadioButtonList', array(
                        'element' => $element,
                        'name' => CHtml::modelName($element)."[is_same_condition]",
                        'label_above' => true,
                        'field_value' => false,
                        'field' => 'is_same_condition',
                        'data' => array(
                                1 => 'Same Condition',
                                0 => 'Different Condition',
                        ),
                        'selected_item' => $element->is_same_condition ? $element->is_same_condition : 0,

                    ));

                ?>

            </div>

        </div>
 <div class="row">
            <div class="large-2 column">&nbsp;</div>

            <div class="large-3 column end">
                <label class="inline">
                    <label>
                        <?php echo CHTML::activeCheckBox($element, 'is_urgent'); ?>
                        <?php echo $element->getAttributeLabel('is_urgent'); ?>
                    </label>
                </label>
            </div>

            <div class="large-1 column end">&nbsp;</div>

        </div>
    </div>

</section>