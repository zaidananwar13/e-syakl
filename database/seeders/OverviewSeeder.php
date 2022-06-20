<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OverviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('overview')->insert([
            'title' => "A new different way to started learning Arabic",
            'desc' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce placerat libero quis leo tincidunt, ut commodo ante eleifend."
        ]);
        
        DB::table('overview')->insert([
            'title' => "Why learn with Arabic-Go ?",
            'desc' => "It's time to choose wisely learning resources. Not only guaranteed material. Arabic-Go also has professional mentors who will help you quickly learn Arabic."
        ]);
        
        DB::table('overview')->insert([
            'title' => "Choose featured class",
            'desc' => "It's time to choose wisely learning resources. Not only guaranteed material. Arabic-Go also has professional mentors who will help you quickly learn Arabic."
        ]);
        
        DB::table('overview')->insert([
            'title' => "Learning is easier with the giving harakat featured",
            'desc' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce placerat libero quis leo tincidunt, ut commodo ante eleifend."
        ]);
        
        DB::table('overview')->insert([
            'title' => "What they’re says about Arabic-Go",
            'desc' => "Members who post their reviews are their own opinion and are not created in consultation with anyone at Arabic-Go. comment you see is their personal opinion and we don't cooperate with them at all."
        ]);
    }
}
