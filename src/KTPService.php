<?php

namespace Serengiy\GlairAI;

use Illuminate\Support\Facades\Http;

final class KTPService extends GlairAIAbstract
{
    /**
     * @throws \Exception
     */
    public function check(string $imagePath): KYCResponse
    {
        $url = $this->url . '/ocr/v1/ktp';
        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
        ])
            ->withBasicAuth($this->username, $this->password)
            ->attach('image', file_get_contents($imagePath), basename($imagePath))
            ->timeout(300)
            ->post($url);

        if ($response->failed()) {
            $errorMessage = $response->body();
            throw new \Exception(
                'Check request ' . ' ' . $url . ' failed! Status: ' . $response->status() . '. Error: ' . $errorMessage,
                $response->status()
            );
        }

        if(empty($response->body()))
            throw new \Exception('Empty response from server', 500);

        if($read = $response->json()['read'] ?? null){
            return KYCResponse::make($read);
        }else{
            throw new \Exception('Failed to read image', 500);
        }
    }

}
