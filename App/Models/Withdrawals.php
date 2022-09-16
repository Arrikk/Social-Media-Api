<?php

namespace App\Models;

use App\Models\Wallet\Bank;
use App\Models\Wallet\Wallet;
use Core\Http\Res;
use Core\Model;
use Core\Traits\Model as TraitsModel;

class Withdrawals extends Model
{
    use TraitsModel;
    static $table = 'withdrawals';

    public static function make($data)
    {
        $wallet = Wallet::getWallet($data->user);
        $verified = User::isVerified($data->user);
        if(!$verified) Res::status(401)->json(['error' => 'Account Verification Required']);
        if((int) $wallet->balance < (int) $data->amount) Res::status(400)->json(['error' => "Insufficient Balance"]);
        Wallet::fundWallet(null, DEDUCTION, $data->amount, $data->user);
        return self::dump([
            'user_id' => $data->user,
            'amount' => $data->amount,
            'balance_before' => $wallet->balance
        ]);
    }
    public static function withdrawals($extra = null)
    {
        $currentPage = $extra->page ?? 1;
        $currentPage = (int) $currentPage;
        $limit = $extra->limit ?? LIMIT;
        $order = $extra->order ?? DESC;


        if ($currentPage < 1) $currentPage = 1;
        $startAt = ($currentPage - 1) * $limit;

        $qry = 'withdrawals.id, withdrawals.amount, withdrawals.user_id, withdrawals.status, withdrawals.createdAt, withdrawals.updatedAt, u.username, u.email, u.display_name as name';

        return self::find([
            '$.left' => 'users u',
            '$.on' => 'withdrawals.user_id = u.id',
            '$.order' => "withdrawals.id $order",
            '$.limit' => "$startAt, $limit"
        ], $qry);
    }

    public static function withdrawalDetails($withdrawalId)
    {
        $qry = 'id, user_id, amount, status';

        $request =  self::findOne([
            'id' => $withdrawalId
        ], $qry);

        if (!$request) Res::status(404)->json(['error' => 'Withdrawal request not found']);

        # get total withdrawals
        $total = self::userTotalWithdrawal($request->user_id);
        # user wallet balance
        $balance = Wallet::getWallet($request->user_id);

        # get Bank details
        $bank = Bank::bankDetails($request->user_id);
        # get user details
        $user = User::getUserById($request->user_id);
        $kyc = Kyc::kycByUser($request->user_id);



        $request = (object) array_merge((array) $request, (array) $total); # merge details
        $request = (object) array_merge((array) $request, (array) $bank); # merge details
        $request->balance =  (int) $balance->balance; #user balance
        $request->phone = $user->phone_number; #user Phone
        $request->email = $user->email; #user Email
        $request->avatar = $user->avatar; #user Email
        $request->fullname = $kyc ? $kyc->fullname : ''; #user FullName
        $request->canAccept = $request->status == PENDING ? true : false;
        $request->bankaccname = $request->accountName ?? "Not yet Added";
        $request->canDecline = $request->status == PENDING ? true : false;
        $request->isDeclined = $request->status == DECLINED ? true : false;
        $request->isApproved = $request->status == APPROVED ? true : false;
        $request->isPending = $request->status == PENDING ? true : false;
        $request->decline = DECLINED;
        $request->approve = APPROVED;


        return $request;
    }

    public static function userTotalWithdrawal($id)
    {
        return self::findOne([
            'user_id' => $id,
            'and.status' => APPROVED
        ], 'count(*) as totalCount, sum(amount) as totalAmount');
    }

    public static function withdrawalsCount($limit = null)
    {
        $totalwithdrawals = static::find([], 'count(*) as totalwithdrawals');
        return [
            'total' => $totalwithdrawals[0]->totalwithdrawals,
            'limit' => $limit->limit ?? LIMIT
        ];
    }

    public static function withdrawalAction($withdawalId, $type)
    {
        $withdrawal = self::withdrawalDetails($withdawalId);
        $currentTime = date('y-m-d: H:i:s');
        if ($withdrawal->canAccept && $withdrawal->canDecline) :
            if ($type == APPROVED) {

                if ((int) $withdrawal->amount > (int) $withdrawal->balance)
                    Res::status(401)->json(['error' => 'Insufficient Balance']);

                self::findAndUpdate(['id' => $withdawalId], ['status' => APPROVED, 'updatedAt' => $currentTime]);
                Wallet::fundWallet(null, DEDUCTION, $withdrawal->amount, $withdrawal->user_id);
                Res::json(['message' => 'Withdrawal Approved']);
            }
            if ($type == DECLINED) {
                self::findAndUpdate(['id' => $withdawalId], ['status' => DECLINED, 'updatedAt' => $currentTime]);
                Res::json(['message' => 'Withdrawal Declined']);
            }
        endif;
    }

    public static function _myWithdrawals($user, $extra = null)
    {
        $currentPage = $extra->page ?? 1;
        $currentPage = (int) $currentPage;
        $limit = $extra->limit ?? LIMIT;


        if ($currentPage < 1) $currentPage = 1;
        $startAt = ($currentPage - 1) * $limit;

        $withdrawals = self::find([
            'user_id' => $user,
            '$.limit' => "$startAt, $limit"
        ]);

        foreach ($withdrawals as $key => $withdrawal) :
            $withdrawals[$key] = (object) [
                'amount' => (float) $withdrawal->amount,
                'invoice' => "#inv0".$withdrawal->id,
                'status' => $withdrawal->status,
                'isPending' => $withdrawal->status == PENDING,
                'isDeclined' => $withdrawal->status == DECLINED,
                'isApproved' => $withdrawal->status == APPROVED,
                'date' => $withdrawal->createdAt
            ];
        endforeach;

        return $withdrawals;
    }

    public static function withdrawalHistory($userId)
    {
        $history = self::find(['user_id' => $userId]);
        foreach ($history as $key => $value):
            $history[$key] = self::withdrawalDetails($value->id);
        endforeach;
        return $history;
    }

    // public static function _myWithdrawals($userId)
    // {
    //     $history = self::find(['user_id' => $userId]);
    //     foreach ($history as $key => $value):
    //         $history[$key] = [
    //             'invoice' => "#inv0".$value->id,
    //             'amount' => $value->amount,
    //             'requestOn' => $value->createdAt,
    //             'isDeclined' => $value->status == DECLINED ? true : false,
    //             'isApproved' => $value->status == APPROVED ? true : false,
    //             'isPending' => $value->status == PENDING ? true : false,
    //         ];
    //     endforeach;
    //     return $history;
    // }
}
