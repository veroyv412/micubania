<?php

namespace App\Http\Controllers;

use Facebook\Facebook;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    protected $app;

    public function __construct()
    {
        $this->app = app();
    }

    public function getHome(Request $request){
        return $this->app['twig']->render('home.twig', []);
    }

    public function getStaff(Request $request){
        return $this->app['twig']->render('staff.twig', []);
    }

    public function getContactus(Request $request){
        return $this->app['twig']->render('contactus.twig', []);
    }

    public function getEvents(Request $request){
        $fb = new \Facebook\Facebook(
            [
                'app_id' => '310902175730143',
                'app_secret' => 'c5e81f0f7d9020775a740023bbb1a4a2',
                'default_graph_version' => 'v2.8'
            ]
        );

        $accessToken = "EAAEaw42ZBid8BAJfWEx3O7gcGhqQRGqPNyZB9BxHMVbsZCNNYZCMqjre9BColAEZA3aePwJG7wRa07VVodgUHwBVwbf4ZBttjiTW6xvMkZBhija0e9g79Ku3BEcMj9pmYdFHRpxVZBqMpidz299LDajx6noUEcgFw28ZD";
        try {
            $events = $fb->get('/micubania/events', $accessToken);
            $events = $events->getDecodedBody()['data'];
            $_events = [];
            foreach( $events as $event  ){
                $_event = new \stdClass();
                $_event->id = $event['id'];
                $_event->title = $event['name'];
                $_event->description = $event['description'];
                $_event->start_time = $event['start_time'];
                $_event->end_time = $event['end_time'];
                $_event->place = $event['place'];
                $eventResponse = $fb->get('/'.$event['id']."?fields=cover,attending_count,description,guest_list_enabled,maybe_count,interested_count,ticket_uri,attending", $accessToken);
                try {
                    $_eventResponse = $eventResponse->getDecodedBody();
                    $_event->attending_count = $_eventResponse['attending_count'];
                    $_event->interested_count = $_eventResponse['interested_count'];
                    $_event->attending = $_eventResponse['interested_count'];
                    $_event->cover = $_eventResponse['cover']['source'];
                } catch(\Facebook\Exceptions\FacebookSDKException $e) {}
                array_push($_events, $_event);
            }
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {}

        return $this->app['twig']->render('events.twig', ['events' => $_events]);
    }
}
