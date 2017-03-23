<?php

use yii\db\Migration;

class m170321_202441_create_table_ingredient extends Migration
{
    public function up()
    {
        $tableOptions = null;
 
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
 
        $this->createTable('ingredient', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),            
            'name' => $this->string(255)->notNull(),
        ], $tableOptions);     
    }
 
    public function down()
    {
        $this->dropTable('ingredient');
    }
}
