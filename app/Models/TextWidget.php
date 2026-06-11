<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextWidget extends Model
{
    use HasFactory;
    protected $fillable = ['key', 'image', 'content', 'active'];

    public static function getTitle(string $key): string
    {
        $widget = TextWidget::query()->where('key', $key)->first();
        if (!$widget) {
            return '';
        }

        return $widget->title;
    }

    public static function getContent(string $key): ?object
    {
        $widget = cache::get('text_widget:' . $key, function() use ($key){
            $widget = TextWidget::query()->where('key', $key)->first();
        });

        if (!$widget) {
            return null;
        }

        $content = $widget;
    }
}
