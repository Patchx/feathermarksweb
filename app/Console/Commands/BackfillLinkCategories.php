<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackfillLinkCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backfill:link-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = \App\User::all();

        foreach ($users as $user) {
            $personal_cat_id = \App\Category::where('user_id', $user->custom_id)
                                            ->where('name', 'personal')
                                            ->first()
                                            ->custom_id;

            $work_cat_id = \App\Category::where('user_id', $user->custom_id)
                                            ->where('name', 'work')
                                            ->first()
                                            ->custom_id;

            \App\Link::where('user_id', $user->custom_id)
                    ->where('category', 'personal')
                    ->update([
                        'category_id' => $personal_cat_id
                    ]);

            \App\Link::where('user_id', $user->custom_id)
                    ->where('category', 'work')
                    ->update([
                        'category_id' => $work_cat_id
                    ]);
        }
    }
}
