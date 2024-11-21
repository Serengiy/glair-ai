<?php

namespace Serengiy\GlairAI;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

abstract class GlairAIAbstract
{

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    /**
     * @var string
     */
    protected string $url;

    /**
     * @var string
     */
    protected string $username;

    /**
     * @var string
     */
    protected string $password;

    /**
     * @var string
     */
    protected string $apiKey;


    /**
     * @throws \Exception
     */
    public function __construct()
    {
        if(!config('glair-ai.url'))
            throw new \Exception('Client ID is not set');

        if(!config('glair-ai.key'))
            throw new \Exception('Client secret is not set');

        if(!config('glair-ai.username'))
            throw new \Exception('Username is not set');

        if(!config('glair-ai.password'))
            throw new \Exception('Password is not set');

        $this->url = config('glair-ai.url');
        $this->apiKey = config('glair-ai.key');
        $this->username = config('glair-ai.username');
        $this->password = config('glair-ai.password');
    }

    /**
     * @throws \Exception
     */
    protected function sendRequest(string $path, string $method = self::METHOD_GET, array $data = []): array
    {
        $url = $this->url .  Str::start($path, '/');

        $response = Http::withHeaders([
            'x-api-key' =>  $this->apiKey,
        ])->timeout(300)->$method($url, $data);

        if ($response->failed()) {
            $errorMessage = $response->body();
            throw new \Exception(
                'Request ' . $method . ' ' . $url . ' failed! Status: ' . $response->status() . '. Error: ' . $errorMessage,
                $response->status()
            );
        }
        return $response->json();
    }

    /**
     * Send GET request
     * @param string $path
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function get(string $path, array $data = []): array
    {
        return $this->sendRequest($path, self::METHOD_GET, $data);
    }

    /**
     * Send POST request
     * @param string $path
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function post(string $path, array $data = []): array
    {
        return $this->sendRequest($path, self::METHOD_POST, $data);
    }
}
