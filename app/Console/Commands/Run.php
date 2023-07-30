<?php

namespace App\Console\Commands;

use App\Models\Theme;
use App\Models\User;
use Illuminate\Console\Command;

class Run extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $parent_themes = [];
        $theme_id = 9;

        while ($theme_id)
        {
            $theme = Theme::find($theme_id);

            if($theme->parent_id) {
                $parent_theme = Theme::find($theme->parent_id);
                $parent_themes[] = $parent_theme;
                $theme_id = $parent_theme->id;
            } else {
                break;
            }

        }

        dd(array_reverse($parent_themes));

    }
}
