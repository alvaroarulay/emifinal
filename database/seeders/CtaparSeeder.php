<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;

class CtaparSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = new TableReader(public_path('vsiaf/dbfs/cta_par.dbf'),['encoding' => 'cp1252']);
        while ($record = $table->nextRecord()) {
            DB::table('cta_par')->insert([
                'codcont' => $record->get('codcont'),
                'partida' => $record->get('partida'),
                'gestion' => $record->get('gestion'),
                'created_at'=>now(),
                'updated_at'=>now(),
          ]);

        }
    }
}
