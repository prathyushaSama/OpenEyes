<?php

class m170609_010155_add_primary_investigator_role extends CDbMigration
{
    const PRIMARY_INVESTIGATOR_ROLE = "Primary Investigator";

    public function safeUp()
    {
        $this->insert('authitem', array('name' => self::PRIMARY_INVESTIGATOR_ROLE, 'type' => 2));
    }

    public function safeDown()
    {
        $this->delete('authitem', 'name = "' . self::PRIMARY_INVESTIGATOR_ROLE . '"');
    }
}