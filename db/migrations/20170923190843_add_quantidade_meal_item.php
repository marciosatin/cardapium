<?php

use Phinx\Migration\AbstractMigration;

class AddQuantidadeMealItem extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('meals_itens');
        $table->addColumn('quantity', 'integer')
              ->save();
    }

    public function down()
    {
        $table = $this->table('meals_itens');
        $table->removeColumn('quantity')
              ->save();
    }
}
