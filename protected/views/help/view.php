
<?php

$helplinks = array(
	0 => array('name' => 'Welcome to OpenEyes', 'view' => 'welcome_to_openeyes'),
	1 => array('name' => 'What Will Change?', 'view' => 'what_will_change'),
	3 => array('name' => 'What OpenEyes Cannot Yet Do', 'view' => 'cannot_do'),
	4 => array('name' => 'Which Patients Will Go Onto OpenEyes?', 'view' => 'which_patients'),
	5 => array('name' => 'How Are Patients Added to OpenEyes?', 'view' => 'adding_patients'),
	6 => array('name' => 'How Are Patient Details Maintained in OpenEyes?', 'view' => 'patient_details'),
	7 => array('name' => 'Getting Started', 'view' => 'getting_started'),
	8 => array('name' => 'Creating a New Patient', 'view' => 'patient_create'),
	9 => array('name' => 'Editing Patient Details', 'view' => 'edit_patient'),
);
?>
<br/>
<div class="container content">
    <div class="large-3 column">
        <div class="box generic">
        <h1>Help Topics</h1>
            <ul>
            <?php foreach($helplinks as $id => $arr): ?>
                <?php if($id == $topic_id): ?>
                    <li><?php echo $arr['name']; ?></li>
                <?php else: ?>
                    <li><?php echo CHtml::link($arr['name'], array('/help/view/' . $id)); ?></li>
                <?php endif; ?>
            <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="large-9 column">
        <div class="box generic">
            <?php
				$this->renderPartial ($helplinks[$topic_id]['view'], array(
					'display' => 'block'
				) );
				?>
        </div>
    </div>
</div>