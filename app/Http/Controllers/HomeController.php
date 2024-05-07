<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\SavedTask;
use App\Models\PushNotification;
use Illuminate\Http\Request;
use App\Events\Notifications;
use Illuminate\Support\Facades\Auth;
use App\Repositories\EstimationRepository;
use App\Http\Controllers\Services\RatingService;
use App\Http\Controllers\Services\GetDayPlanService;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;
use App\Http\Controllers\Services\IndexStatServices\IndexStatService;


class HomeController extends Controller
{
    private $indexStatService = null;

    public function __construct(IndexStatService $indexStatService)
    {
        $this->indexStatService = $indexStatService;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $statData = $this->indexStatService->countStatIndex();

    
        return view('home')->with(['statData' => $statData]);
    }





    public function saveSubscription(Request $request)
    {
        $items = new PushNotification();
        $items->subscriptions = json_decode($request->sub);
        $items->save();

        return response()->json(['message' => 'added successfully'], 200);
    }

    public function sendNotification(Request $request)
    {
        $auth = [
            'VAPID' => [
                'subject' => 'https://zip-time.test/', // can be a mailto: or your website address
                'publicKey' => '    BGPbvN2N_ETuxiZZ90jMjXWardKtcrhDeFr93npJg5pInkDpDtJfUXRH0Het53h-zNUgRmS30N9iiCM-uN6Jsxk  ', // (recommended) uncompressed public key P-256 encoded in Base64-URL
                'privateKey' => '0Rdr03_bupDraVkmhF6j7q73nlaPyVT-bDtMWW7NLPA', // (recommended) in fact the secret multiplier of the private key encoded in Base64-URL
            ],
        ];

        $webPush = new WebPush($auth);
        // $payload = '{"title":"' . $request->title . '" , "body":"' . $request->body . '" , "url":"./?id=' . $request->idOfProduct . '"}';

        // Construct the payload with the logo
        $payload = json_encode([
            'title' => $request->title,
            'body' => $request->body,
            'url' => './?id=' . $request->idOfProduct,
        ]);

        // $msg = new PushNotificationMsgs();
        // $msg->title = $request->title;
        // $msg->body = $request->body;
        // $msg->url = $request->idOfProduct;
        // $msg->save();



        $notifications = PushNotification::all();

        foreach ($notifications as $notification) {
            $webPush->sendOneNotification(
                Subscription::create($notification['subscriptions']),
                $payload,
                ['TTL' => 5000]
            );
        }

        return response()->json(['message' => 'send successfully'], 200);
    }

}
