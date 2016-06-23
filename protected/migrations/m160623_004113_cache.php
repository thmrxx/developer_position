<?php

class m160623_004113_cache extends CDbMigration
{

	public function up()
	{
		/**
		 * CREATE TABLE `cache` (
		`c_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Cache ID',
		`c_key` INT(11) NOT NULL COMMENT 'Cache key',
		`c_value` TEXT NOT NULL COMMENT 'Cache value',
		`c_datetime` INT(11) NOT NULL COMMENT 'Cache datetime',
		`c_expire` INT(11) NOT NULL COMMENT 'Cache expire',
		PRIMARY KEY (`c_id`),
		UNIQUE INDEX `c_key` (`c_key`)
		)
		COMMENT='Cache table'
		COLLATE='utf8_general_ci'
		ENGINE=InnoDB;
		 */

		$this->createTable('cache', array(
			'c_id' => "pk COMMENT 'Cache ID'",
			'c_key' => "int NOT NULL COMMENT 'Cache key'",
			'c_value' => "text NOT NULL COMMENT 'Cache value'",
			'c_datetime' => "int NOT NULL COMMENT 'Cache datetime'",
			'c_expire' => "int NOT NULL COMMENT 'Cache expire'",
		), "COMMENT='Cache table'
			COLLATE='utf8_general_ci'
			ENGINE=InnoDB");

		$this->createIndex('c_key', 'cache', 'c_key', true);
	}

	public function down()
	{
		$this->dropTable('cache');
		return false;
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