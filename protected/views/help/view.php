
<?php

$helplinks = array(
	0 => array('name' => 'Welcome to OpenEyes', 'view' => 'welcome_to_openeyes', 'level' => 1),
	1 => array('name' => 'What Will Change?', 'view' => 'what_will_change', 'level' => 2),
	2 => array('name' => 'What OpenEyes Cannot Yet Do', 'view' => 'cannot_do', 'level' => 2),
	3 => array('name' => 'Which Patients Will Go Onto OpenEyes?', 'view' => 'which_patients', 'level' => 2),
	4 => array('name' => 'How Are Patients Added to OpenEyes?', 'view' => 'adding_patients', 'level' => 2),
	5 => array('name' => 'How Are Patient Details Maintained in OpenEyes?', 'view' => 'patient_details', 'level' => 2),
	6 => array('name' => 'Getting Started', 'view' => 'getting_started', 'level' => 1),
	7 => array('name' => 'Creating a New Patient', 'view' => 'patient_create', 'level' => 2),
	8 => array('name' => 'Editing Patient Details', 'view' => 'edit_patient', 'level' => 2),
);
?>
<br/>
<div class="container content">
    <div class="large-3 column">
        <div class="box generic">
        <h1>Help Topics</h1>
            <ul>
            <?php foreach($helplinks as $id => $arr): ?>
                <?php if(array_key_exists($id - 1, $helplinks) && $helplinks[$id - 1]['level'] < $arr['level']): ?>
                    <ul>
                <?php endif; ?>
                <?php if($id == $topic_id): ?>
                    <li><?php echo $arr['name']; ?></li>
                <?php else: ?>
                    <li><?php echo CHtml::link($arr['name'], array('/help/view/' . $id)); ?></li>
                <?php endif; ?>

                <?php if(!array_key_exists($id + 1, $helplinks) && $arr['level'] == 2
                		|| $arr['level'] == 2 && array_key_exists($id + 1, $helplinks) && $helplinks[$id + 1]['level'] < $arr['level']):?>
                    </ul>
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