<?php

use yii\db\Migration;

class m170321_202427_create_table_dish extends Migration
{
    public function up()
    {
        $tableOptions = null;
 
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
 
        $this->createTable('dish', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),            
            'name' => $this->string(255)->notNull(),
            'recipe'=>$this->text()
        ], $tableOptions);     
    }
 
    public function down()
    {
        $this->dropTable('dish');
    }
}
