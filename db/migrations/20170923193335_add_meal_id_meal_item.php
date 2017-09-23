<?php

use Phinx\Migration\AbstractMigration;

class AddMealIdMealItem extends AbstractMigration
{

    public function up()
    {
        $refTable = $this->table('meals_itens');
        $refTable->addColumn('meal_id', 'integer')
                ->addForeignKey('meal_id', 'meals', 'id')
                ->save();
    }

    public function down()
    {
        $table = $this->table('meals_itens');
        $table->dropForeignKey('meal_id')
                ->removeColumn('meal_id')
                ->save();
    }

}
