<?php

use Illuminate\Database\Seeder;
use App\City;
use App\Client;
class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Client::create([
            'name'=>'Primax',
            'id_City'=>'1',
            'url'=>'1922486463.png'

        ]);
       Client::create([
            'name'=>'Deone',
            'id_City'=>'2',
            'url'=>'1922486463.png'

        ]);

    }
}
