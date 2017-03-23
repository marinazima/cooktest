<?php

use yii\db\Migration;

class m170321_204208_create_table_dish_ingredient extends Migration
{
    public function up()
    {
        $tableOptions = null;
 
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
 
        $this->createTable('dish_ingredient', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),    
            'dish_id' => $this->integer()->notNull(), 
            'ingredient_id' => $this->integer()->notNull(),
            'isactive' => $this->smallInteger()->notNull()->defaultValue(1),
        ], $tableOptions);     
    }
 
    public function down()
    {
        $this->dropTable('dish_ingredient');
    }
}
