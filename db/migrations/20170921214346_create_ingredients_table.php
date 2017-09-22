<?php

use Phinx\Migration\AbstractMigration;

class CreateIngredientsTable extends AbstractMigration
{

    public function up()
    {
        $this->table('ingredients')
                ->addColumn('name', 'string')
                ->addColumn('ingredient_type_id', 'integer')
                ->addColumn('created_at', 'datetime')
                ->addColumn('updated_at', 'datetime')
                ->addForeignKey('ingredient_type_id', 'ingredient_types', 'id')
                ->save();
    }

    public function down()
    {
        $this->dropTable('ingredients');
    }

}
