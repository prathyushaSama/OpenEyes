<?php

class m161108_105452_remove_fk_from_version_tables extends CDbMigration
{
	public function up()
	{
            /*
             * SELECT * FROM information_schema.table_constraints 
                WHERE constraint_type='FOREIGN KEY' AND table_schema=DATABASE() AND table_name='ophcocvi_clericinfo_patient_factor_answer_version'
             * */

            //@TODO: check all CVI version tables to drop all FK
            //@TODO: check FK before drop
            $this->dropForeignKey('acv_et_ophcocvi_clericinfo_patient_factor_answer_cui_fk', 'ophcocvi_clericinfo_patient_factor_answer_version');
            $this->dropForeignKey('acv_et_ophcocvi_clericinfo_patient_factor_answer_ele_fk', 'ophcocvi_clericinfo_patient_factor_answer_version');
            $this->dropForeignKey('acv_et_ophcocvi_clericinfo_patient_factor_answer_lmui_fk', 'ophcocvi_clericinfo_patient_factor_answer_version');
            $this->dropForeignKey('et_ophcocvi_clericinfo_patient_factor_answer_aid_fk', 'ophcocvi_clericinfo_patient_factor_answer_version');
	}

	public function down()
	{
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}