<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


$httpClient = new CurlHTTPClient($_ENV['LINE_CHANNEL_ACCESS_TOKEN']);
$bot = new LINEBot($httpClient, ['channelSecret' => $_ENV['LINE_CHANNEL_SECRET']]);

Route::post('/webhook', function (Request $request) use ($bot) {
	$request->collect('events')->each(function ($event) use ($bot) {
	if($event['message']['text']=="オンラインショップ"){
	        $bot->replyText($event['replyToken'], "オンラインショップは近日リリース予定。ポイント使ってお買い物をしよう");
        }elseif($event['message']['text']=="クローゼットーキョー"){
                $bot->replyText($event['replyToken'], "現在のポイントは240Pです。");
	}else{
		$bot->replyText($event['replyToken'], $event['message']['text']);
	}
	});
	return 'ok!';
});



