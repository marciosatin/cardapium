<?php

use Phinx\Migration\AbstractMigration;

class CreateMealsItensTable extends AbstractMigration
{

    public function up()
    {
        $this->table('meals_itens')
                ->addColumn('ingredient_id', 'integer')
                ->addColumn('state_id', 'integer')
                ->addColumn('type_id', 'integer')
                ->addColumn('created_at', 'datetime')
                ->addColumn('updated_at', 'datetime')
                ->addForeignKey('ingredient_id', 'ingredients', 'id')
                ->addForeignKey('state_id', 'states', 'id')
                ->save();
    }

    public function down()
    {
        $this->dropTable('meals_itens');
    }

}
