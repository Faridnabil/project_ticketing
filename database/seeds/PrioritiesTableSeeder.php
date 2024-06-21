<?php

use App\Priority;
use Illuminate\Database\Seeder;

class PrioritiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define the priorities
        $priorities = [
            [
                'id'    => 1,
                'name' => 'Low / Level 1',
                'max_time' => '-',
            ],
            [
                'id'    => 2,
                'name' => 'Low / Level 2',
                'max_time' => '16 Jam',
            ],
            [
                'id'    => 3,
                'name' => 'Medium / Level 2',
                'max_time' => '8 Jam',
            ],
            [
                'id'    => 4,
                'name' => 'High / Level 2',
                'max_time' => '4 Jam',
            ],
            [
                'id'    => 5,
                'name' => 'Critical / Level 2',
                'max_time' => '2 Jam',
            ],
        ];

        // Insert the priorities into the database
        foreach ($priorities as $priority) {
            Priority::create($priority);
        }
    }
}
