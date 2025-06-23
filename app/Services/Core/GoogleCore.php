<?php

namespace App\Services\Core;

class GoogleCore
{

    private array $headers;
    private array $contentTypes;
    private int $timeout = 0;
    private string $proxy = "";
    private array $curlInfo = [];

    public function __construct($access_token)
    {
        $this->contentTypes = [
            "application/json"    => "Content-Type: application/json",
            "multipart/form-data" => "Content-Type: multipart/form-data",
        ];

        $this->headers = [
            $this->contentTypes["application/json"],
            "Authorization: Bearer $access_token",
        ];
    }

    # text to speech
    public function textToSpeech(array $opts)
    {
        $url = "https://texttospeech.googleapis.com/v1beta1/text:synthesize";
        return $this->sendRequest($url, 'POST', $opts);
    }

    /**
     * @param  string  $url
     * @param  string  $method
     * @param  array   $opts
     * @return bool|string
     */
    private function sendRequest(string $url, string $method, array $opts = [])
    {
        $post_fields = json_encode($opts);

        if (array_key_exists('file', $opts) || array_key_exists('image', $opts)) {
            $this->headers[0] = $this->contentTypes["multipart/form-data"];
            $post_fields      = $opts;
        } else {
            $this->headers[0] = $this->contentTypes["application/json"];
        }
        $curl_info = [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => $this->timeout,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_POSTFIELDS     => $post_fields,
            CURLOPT_HTTPHEADER     => $this->headers,
        ];

        if ($opts == []) {
            unset($curl_info[CURLOPT_POSTFIELDS]);
        }

        if (!empty($this->proxy)) {
            $curl_info[CURLOPT_PROXY] = $this->proxy;
        }


        $curl = curl_init();

        curl_setopt_array($curl, $curl_info);
        $response = curl_exec($curl);

        $info           = curl_getinfo($curl);
        $this->curlInfo = $info;

        // CURL Error Log Set
        if (curl_errno($curl) > 0) {
            wLog("Google core CURL Error", ["errPayload" => curl_error($curl), "payloads" => $opts], logService()::LOG_OPEN_AI);

            $error_msg = curl_error($curl);

            session([sessionLab()::SESSION_GOOGLE_ERROR => $error_msg]);

            throw new \Exception(localize("Google core Failed communication") . curl_error($curl));
        }

        curl_close($curl);

        // if (!$response) throw new Exception(curl_error($curl));

        return $response;
    }

}
