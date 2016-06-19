<?php

class m160619_065203_create_search_result extends CDbMigration
{
    public function up()
    {
        /**
         * CREATE TABLE `search_result` (
         * `sr_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ID request',
         * `sr_url` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Request URL',
         * `sr_type` VARCHAR(10) NOT NULL DEFAULT '0' COMMENT 'Type search',
         * `sr_data` TEXT NULL COMMENT 'Result data',
         * `sr_count` INT(11) NULL DEFAULT NULL COMMENT 'Count of results',
         * PRIMARY KEY (`sr_id`),
         * INDEX `sr_url` (`sr_url`)
         * )
         * COMMENT='Search results'
         * COLLATE='utf8_general_ci'
         * ENGINE=InnoDB
         */
        $this->createTable('search_result', array(
            'sr_id' => "pk COMMENT 'ID request'",
            'sr_url' => "string NOT NULL COMMENT 'Request URL'",
            'sr_type' => "VARCHAR(10) NOT NULL DEFAULT '0' COMMENT 'Type search'",
            'sr_data' => "text NULL COMMENT 'Result data'",
            'sr_count' => "integer NULL DEFAULT NULL COMMENT 'Count of results'",
        ), "COMMENT='Search results'
			COLLATE='utf8_general_ci'
			ENGINE=InnoDB");
    }

    public function down()
    {
        $this->dropTable('search_result');
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