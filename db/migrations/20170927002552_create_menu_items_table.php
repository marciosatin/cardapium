<?php

use Phinx\Migration\AbstractMigration;

class CreateMenuItemsTable extends AbstractMigration
{

    public function up()
    {
        $this->table('menu_items')
                ->addColumn('dt_week', 'date')
                ->addColumn('meal_split_id', 'integer')
                ->addColumn('meal_id', 'integer')
                ->addColumn('created_at', 'datetime')
                ->addColumn('updated_at', 'datetime')
                ->addForeignKey('meal_id', 'meals', 'id')
                ->save();
    }

    public function down()
    {
        $this->dropTable('menu_items');
    }

}
