<?php

namespace App;

class Mailer 
{
    public static function send_order_confirmation($order) 
    {
      $client = new \GuzzleHttp\Client(['headers' => 
                                          ['Content-Type' => 'application/json',
                                          'Authorization' => env('SPARKPOST_KEY')]
                                      ]);

      $api = 'https://api.sparkpost.com/api/v1/transmissions';
      $body = '{"recipients":[{"address":{"email":"' . $order->user->email . '"}}], "content":{"from":{"name":"Merkato","email":"support@mail.slashbin.in"},"subject":"Merkato Order Confirmation","html":"<p>Hello ' . $order->user->name . ',</p><p>This is confirmation of the recent order you placed with us.</p><p>You can track the order status at ' . url('/orders/' . $order->id) . '</p><p>Thanks,<br/> Team Merkato</p>"}}';

      $res = $client->request('POST', $api, ['body' => $body]);
    }
}

