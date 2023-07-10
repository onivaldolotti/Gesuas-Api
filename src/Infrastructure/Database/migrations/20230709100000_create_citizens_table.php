<?php

use Phinx\Migration\AbstractMigration;

class CreateCitizensTable extends AbstractMigration
{
    public function up()
    {
        // Define your table creation logic here
        $this->table('citizens')
            ->addColumn('name', 'string')
            ->addColumn('nis', 'integer')
            ->addIndex(['nis'], ['unique' => true])
            ->addTimestamps()
            ->create();
    }

    public function down()
    {
        // Define your table removal logic here
        $this->table('citizens')->drop()->save();
    }
}
