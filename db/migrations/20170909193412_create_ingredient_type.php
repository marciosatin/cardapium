<?php

use Phinx\Migration\AbstractMigration;

class CreateIngredientType extends AbstractMigration
{

    public function up()
    {
        $this->table('ingredient_types')
                ->addColumn('name', 'string')
                ->addColumn('created_at', 'datetime')
                ->addColumn('updated_at', 'datetime')
                ->save();
    }

    public function down()
    {
        $this->dropTable('ingredient_types');
    }

}
