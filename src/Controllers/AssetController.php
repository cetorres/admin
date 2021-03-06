<?php
// Thank you Barryvdh\Debugbar for this concept!

namespace NickDeKruijk\Admin\Controllers;

use App;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class AssetController extends Controller
{
    // Return all javascript files as one
    public function js()
    {
        $content = file_get_contents(__DIR__.'/../js/base.js') . file_get_contents(__DIR__.'/../js/model.js') . file_get_contents(__DIR__.'/../js/media.js');

        $response = new Response(
            $content, 200, [
                'Content-Type' => 'text/javascript',
            ]
        );

        return App::isLocal() ? $response : $this->cacheResponse($response);
    }

    // Return all stylesheet files as one
    public function css()
    {
        $content = file_get_contents(__DIR__.'/../css/base.css');

        $response = new Response(
            $content, 200, [
                'Content-Type' => 'text/css',
            ]
        );

        return App::isLocal() ? $response : $this->cacheResponse($response);
    }

    // Cache the response 1 year (31536000 sec)
    protected function cacheResponse(Response $response)
    {
        $response->setSharedMaxAge(31536000);
        $response->setMaxAge(31536000);
        $response->setExpires(new \DateTime('+1 year'));

        return $response;
    }
}
