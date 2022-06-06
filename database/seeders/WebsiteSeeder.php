<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\QueryException;

use App\Models\Website;


class WebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $websites = [
            [
                'name' => 'Facebook',
            ],
            [
                'name' => 'Twitter',
            ],
            [
                'name' => 'Instagram',
            ],
            [
                'name' => 'Snapchat',
            ],
        ];

        foreach ($websites as $website) {
            try {
                Website::create($website);
            } catch(QueryException $e) {
                if($e->getCode() === "23000") {
                    continue;
                }
            }
            
        }
    }
}
