<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\AdminModel;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{

    public function notify(Request $request)
    {
        //$firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();
        $firebaseToken = ['f4jt6CMxnaeJSA_hxdH91F:APA91bHmq_qHfZjaARyL-Uo7pVpTai3tBoh5_U8LCy2bLmVUZ2hdVTcMUIhyv9yzB_TTiAzsn3Dc9953AcazGhS0t3TzE4Vf3NwZ8TB-ZePNCNpKp-3NJJIEl_Pjt_wjMvjxuLK5oZOo', 'f4jt6CMxnaeJSA_hxdH91F:APA91bEO6Q2_ZA3ytrYBOuHjQHzxnheOAQrMEM2issS2cLFaPk_eY9tAAvvgr_NpP2AmbpYeg3NutwJmRyphqSLUROPUwtY7Of_DU5JxTyLxox7lFq6htNhJlieRaVkaBDbNrvF4BnQt', 'eoW4SU9g7r6XJ_1BV6bCH8:APA91bG_Tf6XW3N596TkHBJj7P6rXq3cm342ZCDF_Q1Kw6Sisfcjsr541aSOVY6DHJCz9bR09BgbsflxrI0WXhtLmt6rKq-rswSSljXF3U0qhQJOx-MAY1UM2zgKjv2DFBuHH_gt0t_j'];


        $SERVER_API_KEY = 'AAAA_-z-9Mo:APA91bG1MD6ID7OUqBgt_Djq-HZlYjUz7U6B8jmAO5yXFyLWT2ViijZp0Dp43nzbY5raw-rX2uE8fpwrdJEedlXs-s2nHwygG41jc-gJ9b4FCWztasNzFP6m6O4Du_e2O2JVscfn3QQL';

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
                "content_available" => true,
                "priority" => "high",
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        dd($response);
    }

    public static function createNotification($title, $message, $reciever)
    {
        //$firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();
        // $firebaseToken = ['f4jt6CMxnaeJSA_hxdH91F:APA91bHmq_qHfZjaARyL-Uo7pVpTai3tBoh5_U8LCy2bLmVUZ2hdVTcMUIhyv9yzB_TTiAzsn3Dc9953AcazGhS0t3TzE4Vf3NwZ8TB-ZePNCNpKp-3NJJIEl_Pjt_wjMvjxuLK5oZOo', 'f4jt6CMxnaeJSA_hxdH91F:APA91bEO6Q2_ZA3ytrYBOuHjQHzxnheOAQrMEM2issS2cLFaPk_eY9tAAvvgr_NpP2AmbpYeg3NutwJmRyphqSLUROPUwtY7Of_DU5JxTyLxox7lFq6htNhJlieRaVkaBDbNrvF4BnQt', 'eoW4SU9g7r6XJ_1BV6bCH8:APA91bG_Tf6XW3N596TkHBJj7P6rXq3cm342ZCDF_Q1Kw6Sisfcjsr541aSOVY6DHJCz9bR09BgbsflxrI0WXhtLmt6rKq-rswSSljXF3U0qhQJOx-MAY1UM2zgKjv2DFBuHH_gt0t_j'];


        $SERVER_API_KEY = 'AAAA_-z-9Mo:APA91bG1MD6ID7OUqBgt_Djq-HZlYjUz7U6B8jmAO5yXFyLWT2ViijZp0Dp43nzbY5raw-rX2uE8fpwrdJEedlXs-s2nHwygG41jc-gJ9b4FCWztasNzFP6m6O4Du_e2O2JVscfn3QQL';

        $data = [
            "registration_ids" => $reciever,
            "data" => [
                "title" => $title,
                "body" => $message,
                "content_available" => true,
                "priority" => "high",
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        Log::debug("NOTIFICATION RESPONSE ::: ". $response);

        //dd($response);
    }


    public function saveToken(Request $request)
    {
        $admin = AdminModel::find($request->id);
        $admin->device_token = $request->device_token;
        $admin->save();
        return  response(['success' => true, 'message' => "Device token saved."]);
    }
}
