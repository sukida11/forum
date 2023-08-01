<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function App\Console\Commands\asd;

class Theme extends Model
{
    use HasFactory;

    protected $guarded = false;
    protected $table = 'themes';


    public function getParentThemes()
    {
        $parentThemes = [];
        $themeId = $this->id;
        while ($themeId)
        {
            $resTheme = Theme::find($themeId);

            if($resTheme->parent_id) {
                $parentTheme = Theme::find($resTheme->parent_id);
                $parentThemes[] = $parentTheme;
                $themeId = $parentTheme->id;
            } else {
                break;
            }

        }

        return array_reverse($parentThemes);

    }

    public function getChildrenThemes($id)
    {
        $result = collect([]);
        $theme = Theme::find($id);

        $children = Theme::where('parent_id', $theme->id)->get();

        if ($children) {

            $result = $result->merge($children);

            $children->each(function ($item) use (&$result) {
                $result = $result->merge($this->getChildrenThemes($item->id));
            });

        }

        return $result;
    }

    public function threads()
    {
        return $this->hasMany(Thread::class, 'theme_id', 'id');
    }
}
