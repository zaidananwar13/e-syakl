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
            'title' => "A new different way to start learning Arabic",
            'desc' => "The first free learning platform that focused in Arabic. With our various excellent features, start your learning arabic journey with us!"
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
            'desc' => "Confused in reading arabic without harakat? No worries, we'll do it for you! Introducing, our giving harakat feature."
        ]);
        
        DB::table('overview')->insert([
            'title' => "What they’re says about Arabic-Go",
            'desc' => "Members who post their reviews are their own opinion and are not created in consultation with anyone at Arabic-Go. comment you see is their personal opinion and we don't cooperate with them at all."
        ]);
    }
}
