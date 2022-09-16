<?php

namespace App\Models\Feed;

use App\Models\Bookmark;
use App\Models\Lists\Blocked;
use App\Models\Lists\Lists;
use App\Models\User;
use App\Models\Wallet\Transactions;
use App\Models\Wallet\Wallet;
use Core\Http\Res;
use Core\Model;
use Core\Traits\Model as TraitsModel;
use Module\Image;

class Feed extends Model
{

    use TraitsModel; # Use trait only if using the find methods

    /**
     * Each model class requires a unique table base on field
     * @return string $table ..... the table name e.g 
     * (users, posts, products etc based on your Model)
     */
    public static $table = "feed"; # declear table only if using traitModel
    public static $error = [];


    /**
     * Save feed data to Db
     * @param object>mixed $data feed data to store
     * @return mixed
     */
    public static function saveFeed($data, $media = null)
    {
        $verified = User::isVerified($data->id);

        // if (!$verified)
        //     Res::status(400)->json(['verification' => 'Please Verify your account']);
        # Save feed data
        $feedSaved = static::dump([
            'user_id' => (int) static::clean($data->id),
            'image' => json_encode($media),
            'video' => $data->video ?? "",
            'text' => static::clean($data->text ?? ""),
            'isPremium' => $data->is_premium ?? 0,
            'premium' => '',
            'hasPoll' => isset($data->poll) ? YES : NO,
            'pollEndDate' => $data->endDate ??  date('y-m-d H:i:s', time())
        ]);

        # if feed is saved.... get the user that posted
        # and get the feed id
        if ($feedSaved) :
            $feedId = $feedSaved->id;
            $userId = $feedSaved->user_id;
        else :
            return false;
        endif;

        # if feed has poll proceed to save pool
        if (isset($data->poll)) :
            foreach ($data->poll as $option) :
                Poll::craft([
                    'feed_id' => $feedId,
                    'poll_option' => $option
                ]);
            endforeach;
        endif;

        # Check if feed contains images..
        # store images if in feed
        if (isset($media['image']) && !empty($media['image'])) :
            if(is_array($media['image']['name'])):
                $upload = Image::multiple($media);
                foreach ($upload as $image) {
                    Media::craft([
                        'user_id' => $userId,
                        'feed_id' => $feedId,
                        'media_type' => IMAGE,
                        'media_data' => $image->fullpath
                    ]);
                }
                // MediaMeta::save(['user_id' => $userId, 'meta_id', 'name' => '', 'value' => $upload]);
            else:
                $upload = Image::upload($media);
                Media::craft([
                    'user_id' => $userId,
                    'feed_id' => $feedId,
                    'media_type' => IMAGE,
                    'media_data' => $upload->fullpath
                ]);
            endif;
            // foreach ($data->image as $image) {
            //     Media::craft([
            //         'user_id' => $userId,
            //         'feed_id' => $feedId,
            //         'media_type' => IMAGE,
            //         'media_data' => $image
            //     ]);
            // }
        endif;

        # Check if feed contains video..
        # store video if in feed
        if (isset($data->video)) :
            Media::craft([
                'user_id' => $userId,
                'feed_id' => $feedId,
                'media_type' => VIDEO,
                'media_data' => $data->video
            ]);
        endif;

        // return true;
        $user = User::getUserMinified($data->id);
        $user->feed = $feedSaved->id;
        Res::json(self::findFeedById($user)[0]);
    }

    /**
     * Get Feed dummy test 1
     * 
     */
    public static function getFeed($user, $extra = null, $onlyMe = false)
    {
        $currentPage = $extra->page ?? 1;
        $currentPage = (int) $currentPage;
        $limit = $extra->limit ?? LIMIT;
        $order = $extra->order ?? DESC;

        if ($currentPage < 1) $currentPage = 1;
        $startAt = ($currentPage - 1) * $limit;

        $cols = 'feed.id as id, feed.likes, feed.image, feed.user_id as user_id, feed.text, feed.video, feed.premium, feed.isPremium, feed.hasPoll, feed.tipsAmount, feed.canComment, feed.price, feed.pollEndDate, feed.createdAt';
        $feed = self::select($cols, self::$table)
            ->left('friends f')
            ->on('feed.user_id = f.user_id');

        if ($onlyMe) :
            if ($onlyMe == $user->id) : $feed->where("feed.user_id = $user->id");
            else :
                $feed->where(self::inset($onlyMe, 'f.followers'));
            endif;
        else :
            $feed->where(self::inset($user->id, 'f.followers'))
                ->or("feed.user_id = $user->id");
        endif;

        $feed = $feed->order('feed.id DESC')
            ->limit("$startAt, $limit")
            ->exec();

        // $feed = self::find([
        //     '$.left' => 'friends f',
        //     '$.on' => 'feed.user_id = f.user_id',
        //     '$.where' => self::inset($user->id, 'f.followers'),
        //     '$.or' => "feed.user_id = $user->id",
        //     '$.order' => 'feed.id DESC',
        //     '$.limit' => "$startAt, $limit"
        // ], $cols, false);

        // $feed = self::find([
        //     '$.order' => 'id DESC'
        // ]);
        return self::formatFeed($feed, $user);
    }

    public static function findFeed($param)
    {
        $cols = 'feed.id as id, feed.likes, feed.image, feed.user_id as user_id, feed.text, feed.video, feed.premium, feed.isPremium, feed.hasPoll, feed.tipsAmount, feed.canComment, feed.price, feed.pollEndDate, feed.createdAt';
        $feed = self::find([
            '$.left' => 'friends f',
            '$.on' => 'feed.user_id = f.user_id',
            '$.where' => "feed.id = $param->feed",
            '$.order' => 'feed.id DESC'
        ], $cols);

        return self::formatFeed($feed, $param);
    }
    public static function findFeedById($param)
    {
        $cols = 'feed.id as id, feed.likes, feed.image, feed.user_id as user_id, feed.text, feed.video, feed.premium, feed.isPremium, feed.hasPoll, feed.tipsAmount, feed.canComment, feed.price, feed.pollEndDate, feed.createdAt';
        $feed = self::find([
            '$.left' => 'friends f',
            '$.on' => 'feed.user_id = f.user_id',
            '$.where' => "feed.id = $param->feed",
            '$.order' => 'feed.id DESC'
        ], $cols);

        // return $feed;
        return self::formatFeed($feed, $param);
    }

    public static function formatFeed($feed, $user)
    {

        foreach ($feed as $key => $value) {

            $owner = $user->id == $value->user_id;
            // $blockedList = Blocked::getBlocked($value->user_id);
            if (!$owner) {
                if (Lists::inList($value->user_id, BLOCKED, $user->id)) {
                    $feed[$key] = [];
                    continue;
                };
            }

            $feed[$key]->canReadText = true;
            # feed text
            $feed[$key]->textRaw = $value->text;
            $feed[$key]->text = htmlspecialchars_decode(nl2br($value->text));
            # Author Profile
            $author = User::getUser($value->user_id, $user->id);
            $feed[$key]->author = $author;

            # Check if subscription is expired
            if (isset($author->needsRenewal) && $author->needsRenewal) continue;

            // if(!$author->subscriptionSetting->isExpired):
            # Get tips amount
            $tipsAmount = Tips::tipsAmount($value->id);

            # Get total comments of a feed
            $comments = Comment::getCommentCount($value->id);
            $feed[$key]->comments = $comments->totalComment;

            # Image
            $image = $feed[$key]->image;
            // $feed[$key]->image = json_decode($image);
            $feed[$key]->image = 'image';

            # check if current user has already voted
            $alreadyVoted = PollAnswer::retrieve([
                'feed_id' => $value->id,
                'and.user_id' => $user->id
            ]);

            $feed[$key]->owner = $owner;

            $locked = ($value->isPremium) ? true : false;
            # is user owns feed, feed is not locked for user
            // $locked = $owner && $locked ? false : true;
            // $locked = $user->id == $value->user_id

            # if this feed is premium
            # set cannot acces to true
            # set cannot access to false if this user has not subscribed
            $canNotAccess = $locked;
            if (!$owner && $locked) :
                $canNotAccess = !strstr($value->premium, $user->id . ',');
            else :
                $canNotAccess = false;
            endif;
            $feed[$key]->premium = null;
            $feed[$key]->canView = !$canNotAccess;
            $feed[$key]->cannotViewPost = strstr($value->premium, $user->id . ',');

            # if user current already vote set canVote to false
            $feed[$key]->canVote = $alreadyVoted  ? false : true;
            # Get poll option if poll is in feed >
            # let only premium have access
            $feed[$key]->poll_options = $canNotAccess ? 'Access Denied' : Poll::retrieve(['feed_id' => $value->id]);
            # set feed to be locked to normal user
            // $feed[$key]->locked =a;
            # set Premium price if feed is premium or locked
            $feed[$key]->priceRaw = $value->isPremium ? (int) $value->isPremium : 0;
            $feed[$key]->price = '$' . $feed[$key]->priceRaw;
            # set Tip amount if feed has a tip
            $feed[$key]->tipAmountActual = (int) $tipsAmount;
            # set Tip amount if feed has a tip
            $feed[$key]->tipAmount = "$" . (int)$tipsAmount;
            # set has poll if feed has poll
            $feed[$key]->hasPoll = $value->hasPoll ? true : false;
            # set if feed is premium
            $feed[$key]->isPremium = $value->isPremium ? true : false;
            # set poll expired if poll is expired

            $feed[$key]->canComment =  !$canNotAccess;
            $feed[$key]->canLike = !$canNotAccess;
            $feed[$key]->canViewMedia = !$canNotAccess;
            // if($image || $value->)
            $feed[$key]->hasMedia = (!empty($image) && strlen($image) > 5 || !empty($value->video)) ? true : false;

            if (!$canNotAccess) :
                if (strtotime($value->createdAt) == strtotime($value->pollEndDate)) :
                    $feed[$key]->isExpired = false;
                elseif (time() > strtotime($value->pollEndDate)) :
                    $feed[$key]->isExpired = true;
                endif;

                # if user has bookmarked post
                $bookmarked = Bookmark::isBookmarked(null, [
                    'feed' => $value->id,
                    'user' => $user->id
                ]);
                $feed[$key]->isBookmarked = $bookmarked ? true : false;

                # feed Media = 
                $feed[$key]->media = Media::getMediaById($value->id);
            endif;

            # get likes count
            $likes = explode(',', $feed[$key]->likes);
            $feed[$key]->isliked = in_array($user->id, $likes);
            $feed[$key]->likes = count($likes) - 1;
            // endif;

        }
        return $feed;
    }

    public static function feedById($feedId, $user = '')
    {

        return self::findOne([
            'id' => $feedId,
            '$.order' => 'id DESC'
        ]);
    }

    public static function addToPremiumList($data)
    {
        # get the feed
        $feed = self::feedById($data->feed);
        if (!$feed)
            Res::status(400)->json(['error' =>  "Feed Not Found"]);

        # get Feed amount
        $amount = (float) $feed->isPremium;
        # compare this user wallet balance and feed amount
        Wallet::isAvailableBalance($data->user, $amount);

        # update user wallet with the difference
        $data->id = $data->user;
        $data->amount = (float) $amount;

        $beneficiary  = $feed->user_id;

        # Debit current user
        Wallet::fundWallet($data, DEDUCTION);

        # Credit Beneficiary
        Wallet::fundWallet(null, ADDITION, $beneficiary, $amount);

        # Record Transacstion for Current User
        Transactions::record([
            'user' => $data->id,
            'description' => 'You unlocked a post',
            'amount' => $amount,
            'type' => FEED,
            'status' => DEBIT
        ]);

        # Record Transacstion for beneficiaryr
        Transactions::record([
            'user' => $beneficiary,
            'description' => 'Your post was subscribed to',
            'amount' => $amount,
            'type' => FEED,
            'status' => CREDIT
        ]);

        # add user to feed premium list
        return self::findAndUpdate(['id' => $data->feed], [
            'premium' => $data->user . ','
        ], self::$concat);

        // else :
        //     Res::status(400)->json([
        //         'error' => 'Insufficient Balance',
        //         'balance' => (float) $wallet->balance,
        //         'amount' => (float) $amount
        //     ]);
        // endif;
    }
}
