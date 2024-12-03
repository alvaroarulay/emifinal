<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;

class ResponsableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = new TableReader(public_path('vsiaf/dbfs/RESP.DBF'),['encoding' => 'cp1252']);
        while ($record = $table->nextRecord()) {
            DB::table('resp')->insert([
            'entidad' =>$record->get('entidad'),
            'unidad' =>$record->get('unidad'),
            'codofic' =>$record->get('codofic'),
            'codresp' =>$record->get('codresp'),
            'nomresp' =>$record->get('nomresp'),
            'cargo' =>$record->get('cargo'),
            'ci' =>$record->get('ci'),
            'feult' =>$record->get('feult'),
            'usuar' =>$record->get('usuar'),
            'cod_exp' =>$record->get('cod_exp'),
            'api_estado' =>$record->get('api_estado'),
            'created_at'=>now(),
            'updated_at'=>now(),
          ]);
        }
    }
}
