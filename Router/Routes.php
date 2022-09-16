<?php

/**
 * Add routes
 */

$router->add('login', ['controller' => 'auth', 'action' => 'login']);
// $router->add('register', ['controller' => 'auth', 'action' => 'register']);

// Test GET Route
$router->add('', ['controller' => 'user', 'action' => 'index'])->get();

// User route
$router->add('api/user/login', ['controller' => 'user', 'action' => 'login'])->post();
$router->add('api/user/create', ['controller' => 'user', 'action' => 'create'])->post();
$router->add('api/user/delete/{id:[\d]+}', ['controller' => 'user', 'action' => 'delete'])->get();
$router->add('api/user/updateprofile{id:[\d]+}', ['controller' => 'user', 'action' => 'update'])->post();
$router->add('api/user', ['controller' => 'profile', 'action' => 'my-profile'])->get();
$router->add('api/users', ['controller' => 'user', 'action' => 'users'])->get();
$router->add('api/user/{id:[\d]+}', ['controller' => 'user', 'action' => 'get'])->get();
$router->add('api/user/{id:[\d]+}/', ['controller' => 'user', 'action' => 'get-full-profile'])->get();
$router->add('api/user/check', ['controller' => 'user', 'action' => 'exists'])->post();
$router->add('api/user/count', ['controller' => 'user', 'action' => 'getUserListAnalytic']);
$router->add('api/user/tip', ['controller' => 'user', 'action' => 'tip'])->post();
$router->add('api/suggestions', ['controller' => 'user', 'action' => 'suggestions']);
$router->add('api/profile/{user:[\d\w_-]+}', ['controller' => 'profile', 'action' => 'profile']);
$router->add('api/profile/update/{id:[\d]+}', ['controller' => 'profile', 'action' => 'update'])->post();
$router->add('api/upload', ['controller' => 'profile', 'action' => 'upload'])->post();
$router->add('api/my/profile', ['controller' => 'profile', 'action' => 'my-profile']);

// Followings / Subscriptions
$router->add('api/subscribe/{id:[\d]+}', ['controller' => 'subscriptions', 'action' => 'subscribe']);
$router->add('api/unsubscribe/{id:[\d]+}', ['controller' => 'subscriptions', 'action' => 'unsubscribe']);
$router->add('api/subscription/set', ['controller' => 'subscriptions', 'action' => 'update'])->post();
$router->add('api/my/subscriptions', ['controller' => 'subscriptions', 'action' => 'subscriptions']);
// Notifications
$router->add('api/my/notifications', ['controller' => 'notifications', 'action' => 'my', 'namespace' => 'Others']);
// Referrals
$router->add('api/my/referrals', ['controller' => 'referrals', 'action' => 'my-ref', 'namespace' => 'Others']);
$router->add('api/my/withdrawals', ['controller' => 'withdrawals', 'action' => 'my-withdrawals', 'namespace' => 'Others']);
// Earning
$router->add('api/my/earnings', ['controller' => 'transactions', 'action' => 'my-earnings', 'namespace' => 'Wallet']);
$router->add('api/my/wallet', ['controller' => 'wallet', 'action' => 'my-wallet', 'namespace' => 'Wallet']);
// Conversation
// $router->add('api/conversations/', ['controller' => 'conversations', 'action' => 'conversations', 'namespace' => 'Chats']);
$router->add('api/message', ['controller' => 'message', 'action' => 'chat', 'namespace' => 'Chats'])->post();
$router->add('api/conversations', ['controller' => 'message', 'action' => 'conversations', 'namespace' => 'Chats']);
$router->add('api/conversations/{username:[\d\w_-]+}', ['controller' => 'message', 'action' => 'chats', 'namespace' => 'Chats']);

// Reset Password
$router->add('api/password/{action}', ['controller' => 'password'])->post();
$router->add('api/password/token/{token:[\da-f]+}', ['controller' => 'password', 'action' => 'token']);

// Setting
$router->add('api/settings/{controller}', ['namespace' => 'Settings'])->post();


// Feed Routes
$router->add('api/feed/create', ['controller' => 'feed', 'action' => 'create', 'namespace' => 'Feed'])->post();
$router->add('api/feed/', ['controller' => 'feed', 'action' => 'feeds', 'namespace' => 'Feed'])->get();
$router->add('api/feed/subscribe', ['controller' => 'feed', 'action' => 'add-tosubscription-list', 'namespace' => 'Feed'])->post();
$router->add('api/feed/{feed:[\d]+}/comments', ['controller' => 'comment', 'action' => 'comments', 'namespace' => 'Feed']);
$router->add('api/feed/{feed:[\d]+}/comment', ['controller' => 'comment', 'action' => 'create', 'namespace' => 'Feed'])->post();
$router->add('api/like/{feed:[\d]+}', ['controller' => 'like', 'action' => 'like', 'namespace' => 'Feed'])->get();
$router->add('api/feed/tip', ['controller' => 'feed', 'action' => 'tip', 'namespace' => 'Feed'])->post();
$router->add('api/my/feeds', ['controller' => 'feed', 'action' => 'feed', 'namespace' => 'Feed']);

// Feed - Comment
$router->add('api/comment/{id:[\d]+}/{action}', ['controller' => 'comment', 'namespace' => 'Feed']);

// Poll Routes
$router->add('api/poll/answer', ['controller' => 'poll', 'action' => 'answer', 'namespace' => 'Feed'])->post();

// Bookmark Routes
$router->add('api/bookmark/{id:[\d]+}', ['controller' => 'bookmark', 'action' => 'bookmark']);
$router->add('api/bookmarks', ['controller' => 'bookmark', 'action' => 'bookmarks']);

// Lists
$router->add('api/lists', ['controller' => 'lists', 'action' => 'lists'])->get();
$router->add('api/lists/{slug:[\w\d_]+}', ['controller' => 'lists', 'action' => 'details'])->get();
$router->add('api/list/new', ['controller' => 'lists', 'action' => 'new'])->post();
// $router->add('api/lists/{action}', ['controller' => 'lists'])->post();
$router->add('api/list/{list:[\d\w]+}/{action}', ['controller' => 'lists'])->post();
// $router->add('api/user/create', ['controller' => 'user', 'action' => 'create'])->post();

// Wallet
$router->add('api/wallet/fund', ['controller' => 'wallet', 'action' => 'fund', 'namespace' => 'Wallet'])->post();

// KYC Verification


// Others/ withdrwals / Kyc etc
$router->add('api/withdraw', ['controller' => 'withdrawals','action' => 'create', 'namespace' => 'Others'])->post();
$router->add('api/user/withdrawals', ['controller' => 'withdrawals','action' => 'history', 'namespace' => 'Others']);
$router->add('api/{controller}', ['action' => 'get', 'namespace' => 'Others']);
$router->add('api/{controller}/{id:[\d]+}', ['action' => 'single', 'namespace' => 'Others']);
$router->add('api/{controller}/count', ['action' => 'count', 'namespace' => 'Others']);
$router->add('api/{controller}/action', ['action' => 'action', 'namespace' => 'Others']);
// $router->add('api/withdrawals', ['controller' => 'withdrawals', 'action' => 'kyc', 'namespace' => 'Others']);

$router->add('api/kyc/upload/{token:[\da-f]+}', ['controller' => 'kyc', 'action' => 'upload', 'namespace' => 'Others'])->post();
$router->add('api/{controller}/{action}', ['namespace' => 'Others']);



// Admin Routes
// $router->add();



// General Route
$router->add('api/admin/users', ['controller' => 'dashboard', 'action' => 'index', 'namespace' => 'Admin']);
$router->add('auth/{action}', ['controller' => 'auth', 'namespace' => 'Admin']);

$router->add('admin', ['controller' => 'dashboard', 'action' => 'index', 'namespace' => 'Admin']);

$router->add('dashboard/{action}', ['controller' => 'dashboard', 'namespace' => 'Admin']);

$router->add('admin/users', ['controller' => 'users', 'action' => 'index', 'namespace' => 'Admin']);
$router->add('admin/user/{id:[\d]+}', ['controller' => 'users', 'action' => 'details', 'namespace' => 'Admin']);

$router->add('admin/kyc', ['controller' => 'kyc', 'action' => 'index', 'namespace' => 'Admin']);
$router->add('admin/kyc/{id:[\d]+}', ['controller' => 'kyc', 'action' => 'details', 'namespace' => 'Admin']);

$router->add('admin/withdrawal', ['controller' => 'withdrawal', 'action' => 'index', 'namespace' => 'Admin']);
$router->add('admin/withdrawal/{id:[\d]+}', ['controller' => 'withdrawal', 'action' => 'details', 'namespace' => 'Admin']);

$router->add('admin/referrals', ['controller' => 'referral', 'action' => 'index', 'namespace' => 'Admin']);
$router->add('admin/referral/{id:[\d]+}', ['controller' => 'referral', 'action' => 'details', 'namespace' => 'Admin']);

$router->add('admin/{controller}/{action}', ['namespace' => 'Admin'])->get();
$router->add('admin/{controller}/{id:[\d]+}/{action}', ['namespace' => 'Admin'])->get(); 