<?php

namespace App\Services\Core;

class AzureCore
{

    private array $headers;
    private array $contentTypes;
    private int $timeout = 0;
    private string $proxy = "";
    private array $curlInfo = [];

    public function __construct($azureKey)
    {
        $this->contentTypes = [
            "application/json"    => "Content-Type: application/ssml+xml",
            "multipart/form-data" => "Content-Type: multipart/form-data",
        ];

        $this->headers = [
            $this->contentTypes["application/json"],
            'Ocp-Apim-Subscription-Key: ' . $azureKey,        
            'X-Microsoft-OutputFormat:audio-24khz-48kbitrate-mono-mp3',
            'User-Agent: Berkine',
        ];
    }

    # text to speech
    public function textToSpeech($opts, $region)
    {
        $url = 'https://' . $region . '.tts.speech.microsoft.com/cognitiveservices/v1';
     
        return $this->sendRequest($url, 'POST', $opts);
    }

    /**
     * @param  string  $url
     * @param  string  $method
     * @param  array   $opts
     * @return bool|string
     */
    private function sendRequest(string $url, string $method,  $opts)
    {
        $ssml_text = $opts;      
        $curl_info = [
            CURLOPT_URL            => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => $this->timeout,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_POSTFIELDS     => $ssml_text,
            CURLOPT_HTTPHEADER     => $this->headers,
        ];
        $curl = curl_init();
        curl_setopt_array($curl, $curl_info);
  
        $response = curl_exec($curl);

        $info           = curl_getinfo($curl);
        $this->curlInfo = $info;

        // CURL Error Log Set
        if (curl_errno($curl) > 0) {
            wLog("Azure core CURL Error", ["errPayload" => curl_error($curl), "payloads" => $opts], logService()::LOG_OPEN_AI);

            $error_msg = curl_error($curl);

            session([sessionLab()::SESSION_GOOGLE_ERROR => $error_msg]);

            throw new \Exception(localize("Azure core Failed communication") . curl_error($curl));
        }

        curl_close($curl);

        // if (!$response) throw new Exception(curl_error($curl));

        return $response;
    }

}
