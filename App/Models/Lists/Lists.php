<?php

namespace App\Models\Lists;

use App\Models\User;
use Core\Http\Res;
use Core\Model;
use Core\Traits\Model as TraitsModel;

class Lists extends Model
{
    use TraitsModel;
    static $table = 'lists'; # declare table name

    public static function getList(int $id, $name)
    {
        $col = 'lists, name, id';
        return Lists::findOne([
            preg_match('/\d+/', $name) ? 'id' : 'slug' => (string) $name,
            'and.user_id' => (int) $id
        ], $col);
    }

    /**
     * Get the lists of user filters
     * @param int $id user list to get
     * @param int $userToCheck id of user to check if in list
     * @return mixed
     */
    public static function getLists(int $id, $userToCheck = null)
    {
        $lists = self::find([
            'user_id' => $id
        ], 'name, id, is_editable as isEditable, lists as listCount, slug');

        foreach ($lists as $list => $value) {   
            $lists[$list]->name = ucwords(str_replace('_', ' ', $value->name));
            $lists[$list]->isEditable = $value->isEditable ? true : false;
            $inList = explode(',', $value->listCount);
            $lists[$list]->listCount = count($inList) - 1;
            $lists[$list]->slug = $value->slug ? $value->slug : $value->id;
            $lists[$list]->inList = false;
            if($userToCheck):
                $lists[$list]->inList = in_array($userToCheck, $inList); 
            endif;
        }
        return $lists;
    }

    /**
     * Get details of users in a certain list
     * @param int $user id of current user
     * @param mixed $slug slug of the list to get
     * @return array
     */
    public static function getlistDetails($user, $slug)
    {

        $lists = self::getList($user, $slug);

        if ($lists) :
            $container = array(
                'id' => $lists->id,
                'name' => ucwords(str_replace('_', ' ', $lists->name)),
                'users' => []
            );
            $lists = explode(',', $lists->lists);
            foreach ($lists as $list) {
                if ($list == '') continue;
                $container['users'][] = User::getUser($list, $user);
            }
            return $container;
        else :
            return [];
        endif;
    }


    /**
     * check if a user is in a list
     * @param int $id id of current loggedIn user
     * @param string $name the name of list to check from
     * @param string $userToCheck > id of user to check
     */
    public static function inList($userCurrent, $list, $userToCheck)
    {
        # check if user is in this list
        return Lists::findOne([
            'user_id' => $userCurrent,
            'and.name' => $list,
            '$.and' => self::inset($userToCheck, 'lists')
        ]);
    }

    /**
     * check if a user is in a list
     * @param int $id id of current loggedIn user
     * @param string $name the name of list to check from
     * @param string $userToCheck > id of user to check
     */
    public static function isInList($userCurrent, $list, $userToCheck)
    {
        User::getUserMinified($userToCheck);
        # check if user is in this list
        if (!self::findOne([
            'user_id' => $userCurrent,
            'and.slug' => $list,
            'or.user_id' => $userCurrent,
            '$.and' => "id = ". (int) $list,
        ])) {
            Res::status(400)->json(['error' => 'List not found']);
        }

        return Lists::select('*', self::$table)
        ->where('user_id', $userCurrent)
        ->and('slug', $list)->and(self::inset($userToCheck, 'lists'))
        ->or('user_id', $userCurrent)
        ->and('id', $list)->and(self::inset($userToCheck, 'lists'))
        ->obj()->exec();
    }

    public static function addOrRemove($data)
    {
        User::getUserMinified($data->userTo);
        $isInList = self::isInList($data->userCurrent, $data->list, $data->userTo);
        // return $isInList;
        // Res::json($isInList);
        if ($isInList) :
            return self::removeFromList($data->userTo, $isInList);
        else :
            return self::addToList($data);
        endif;
    }

    public static function removeFromList($user, $list)
    {
        $remove = self::findAndUpdate(
            ['id' => $list->id, 'or.slug' => $list->id],
            ['lists' => ''],
            ['name' => self::$replace, 'from' => $user . ',']
        );
        return "Removed";
    }

    public static function addToList($data)
    {
        $add = self::findAndUpdate(
            [
                'user_id' => $data->userCurrent,
                'and.slug' => $data->list,
                'or.user_id' => $data->userCurrent,
                '$.and' => "id = ". (int) $data->list
            ],
            ['lists' => $data->userTo . ','],
            self::$concat
        );
        return "Added";
    }

    public static function updateList($data)
    {
        $update =  self::findAndUpdate([
            'id' => $data->listId,
            'and.user_id' => $data->user,
            'and.is_editable' => '1'
        ], ['name' => self::clean($data->name)]);
        if ($update) :
            return $update;
        else :
            Res::status(400)->json(['error' => "Permission Denied"]);
        endif;
    }
}
