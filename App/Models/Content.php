<?php
namespace App\Models;

use Core\Http\Res;
use Core\Model;
use Core\Traits\Model as TraitsModel;

class Content extends Model
{
    use TraitsModel;
    static $table = 'content';
    static $error = [];

    public static function make($data)
    {
        # validate request is not empty
        static::validate($data);

        if(empty(self::$error)):
            # save data 

            $category = self::category($data->category);

            self::dump([
                'name' => self::clean($data->name),
                'creator' => (int) $data->id,
                'medium' => self::clean($data->medium),
                'category' => self::clean($category),
                'duration' => self::clean($data->duration),
                'status' => self::clean($data->status)
            ]);
        else:
            Res::status(400)->json(self::$error);
        endif;
    }

    public static function validate($data)
    {
        foreach ($data as $key => $value) {
            if($key == 'request') continue;

            if(empty($value)):
                self::$error[$key] = $key .' cannot be empty';
            endif;
        }
    }

    public static function category($category)
    {
            switch ($category) {
                case MUSIC:
                    $category = MUSIC;
                    break;
                case MEDITATION:
                    $category = MEDITATION;
                    break;
                case BODY:
                    $category = BODY;
                    break;
                case SLEEP:
                    $category = SLEEP;
                    break;
                default:
                $category = BODY;
                    break;
            }
        return $category;
    }

    public static function getContents()
    {
        $qry = 'content.createdAt, content.medium, content.status, content.id, content.name, u.name as creator';

        return self::find([
            '$.left' => 'users u',
            '$.on' => 'content.creator = u.id',
            '$.order' => 'content.createdAt DESC'
        ], $qry);
    }

    public static function update($data)
    {
        $update = [];
        return self::findAndUpdate(
            [
                'id' => $data->id,
                'and.creator' => $data->cretor
            ],
            $update
        );
    }
}