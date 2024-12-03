<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = new TableReader(public_path('vsiaf/dbfs/cla_depts.dbf'),['encoding' => 'cp1252']);
        while ($record = $table->nextRecord()) {
            DB::table('cla_depts')->insert([
                'codigo' => $record->get('codigo'),
                'desc' => $record->get('desc'), 
                'sigla' => $record->get('sigla'),
                'created_at'=>now(),
                'updated_at'=>now(),
          ]);
        }
    }
}
