<?php
namespace Controller;

/**
 *
 */
class ZoomInstance
{
    private $token = '';
    public function __construct()
    {

    }

    public function create_meeting($data = [])
    {
        $client = new \GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
        extract($data);
        if (!isset($zoom_jwt)) {
            return false;
        }

        $zoom_host = isset($zoom_host) ? $zoom_host : 'me';
        $meeting_id = isset($meeting_id) ? $meeting_id : '';
        $url = empty($meeting_id) ? "users/${zoom_host}/meetings" : "meetings/${meeting_id}";
        $method = empty($meeting_id) ? "POST" : "PATCH";
        try {
            $response = $client->request($method, "/v2/${url}", [
                "headers" => [
                    "Authorization" => "Bearer " . $zoom_jwt,
                ],
                'json' => [
                    "topic" => $topic,
                    "type" => 2,
                    'agenda' => $agenda,
                    "start_time" => $start_time,
                    "duration" => $duration,
                    "password" => $password,
                    "settings" => [
                        "meeting_authentication" => true,
                    ],
                ],
            ]);
            $data = json_decode($response->getBody());
            return $data;
        } catch (\Exception $e) {
            return $e->getCode();
        }
    }

    public function create_webinar()
    {

    }

}
