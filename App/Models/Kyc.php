<?php

namespace App\Models;

use App\Token;
use Core\Http\Res;
use Core\Model;
use Core\Traits\Model as TraitsModel;

class Kyc extends Model
{
    use TraitsModel;
    static $table = 'kyc';

    public static function kyc($extra = null)
    {
        $currentPage = $extra->page ?? 1;
        $currentPage = (int) $currentPage;
        $limit = $extra->limit ?? LIMIT;
        $order = $extra->order ?? DESC;


        if ($currentPage < 1) $currentPage = 1;
        $startAt = ($currentPage - 1) * $limit;

        $qry = 'kyc.id, kyc.user_id, kyc.type, kyc.status, kyc.fullname, kyc.front, kyc.back, kyc.viewed_by, kyc.createdAt, kyc.updatedAt, u.username, u.avatar';

        $kyc = self::find([
            '$.left' => 'users u',
            '$.on' => 'kyc.user_id = u.id',
            '$.order' => "id $order",
            '$.limit' => "$startAt, $limit"
        ], $qry);

        foreach ($kyc as $key => $value) {
            $kyc[$key]->isApproved = $value->status == APPROVED ? true : false;
            $kyc[$key]->isPending = $value->status == PENDING ? true : false;
            $kyc[$key]->isDeclined = $value->status == DECLINED ? true : false;
            $kyc[$key]->isDeclined = $value->status == DECLINED ? true : false;
            $kyc[$key]->status = ucfirst($value->status);
            $kyc[$key]->type = ucfirst($value->type);


            $viewedBy = User::getUserById($value->viewed_by);

            $kyc[$key]->viewedBy = $viewedBy->display_name ?? 'No active name';
            $kyc[$key]->viewedById = $viewedBy->id ?? 'No active User';
            $kyc[$key]->viewedByAvatar = $viewedBy->avatar ?? null;
        }

        return $kyc;
    }
    public static function kycById($id)
    {
        $qry = 'kyc.id, kyc.user_id, kyc.type, kyc.status, kyc.back, kyc.front, kyc.selfie, kyc.createdAt, kyc.updatedAt, kyc.viewed_by, kyc.fullname, kyc.address, kyc.DOB, kyc.country';

        $kyc = self::findOne([
            'id' => $id,
        ], $qry);



        $user = User::getUserById($kyc->user_id);
        $viewedBy = User::getUserById($kyc->viewed_by);

        $kyc->viewedBy = $viewedBy->username ?? 'No active name';
        $kyc->viewedById = $viewedBy->id ?? 'No active User';
        $kyc->viewedByAvatar = $viewedBy->avatar ?? null;

        $names = explode(' ', $kyc->fullname);
        $kyc->firstName = $names[0];
        $kyc->lastName = $names[1];

        $kyc->email = $user->email;
        $kyc->username = $user->username;
        $kyc->isEmailVerified = $user->is_active ? true : false;
        $kyc->location = $user->location ? $user->location : "Not yet added";
        $kyc->phone = $user->phone_number ? $user->phone_number : "Not yet added";
        $kyc->amazonUrl = $user->amazon_url ? $user->amazon_url : "Not yet added";

        $kyc->isApproved = $kyc->status == APPROVED ? true : false;
        $kyc->isDeclined = $kyc->status == DECLINED ? true : false;
        $kyc->isPending = $kyc->status == PENDING ? true : false;

        $kyc->approve = APPROVED;
        $kyc->decline = DECLINED;

        $kyc->canApprove = $kyc->status == PENDING ? true : false;
        $kyc->canDecline = $kyc->status == PENDING ? true : false;
        if ($kyc->type == PASSPORT) $kyc->type = ucfirst(PASSPORT);
        if ($kyc->type == NATIONAL) $kyc->type = "National ID Card";
        if ($kyc->type == DRIVING) $kyc->type = "Drivers License";


        return $kyc;
    }

    public static function kycByUser($userId)
    {
        return self::findOne([
            'user_id' => $userId
        ]);
    }

    public static function kycCount($limit = null)
    {
        $totalKyc = static::find([], 'count(*) as totalKyc');
        return [
            'total' => $totalKyc[0]->totalKyc,
            'limit' => $limit->limit ?? LIMIT
        ];
    }

    public static function kycAction($kycId, $type, $viewedBy)
    {
        $kyc = self::kycById($kycId);
        $currentTime = date('y-m-d: H:i:s');
        if ($kyc->canApprove && $kyc->canDecline) :
            if ($type == APPROVED) {
                self::findAndUpdate(['id' => $kycId], ['status' => APPROVED, 'viewed_by' => $viewedBy, 'updatedAt' => $currentTime]);
                User::updateUser($kyc->user_id, ['is_verified' => 1]);
                Res::json(['message' => 'kyc Approved']);
            }
            if ($type == DECLINED) {
                self::findAndUpdate(['id' => $kycId], ['status' => DECLINED, 'viewed_by' => $viewedBy,  'updatedAt' => $currentTime]);
                Res::json(['message' => 'kyc Declined']);
            }
        endif;
    }

    public static function startKyc($id)
    {
        $token = new Token();
        $token_hash = $token->getHashed();
        $token_value = $token->getValue();

        User::updateUser($id, ['password_reset_hash' => $token_hash]);
        return $token_value;
        
    }
}
