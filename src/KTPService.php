<?php

namespace Serengiy\GlairAI;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

final class KTPService extends GlairAIAbstract
{
    /**
     * @throws \Exception
     */
    public function readKTP(string $imagePath): KYCResponse
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

    /**
     * @throws ConnectionException
     * @throws \Exception
     */
    public function basicVerification(array $payload): array
    {
        if(!isset($payload['nik']))
            throw new \Exception("'nik' field is required");

        if(count($payload) < 2)
            throw new \Exception(
                'You must fill in at least one of the following: name, date_of_birth, liveness_fail_message, liveness_result, no_kk, mother_maiden_name, place_of_birth, address, gender, marital_status, job_type, province, city, district, subdistrict, rt, rw.',
                400
            );

        $url = $this->url . '/identity/v1/verification';

        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
        ])
            ->withBasicAuth($this->username, $this->password)
            ->timeout(300)
            ->post($url, $payload);

        if(!$response->ok() && isset($response->json()['reason'])){
            throw new \Exception($response->json()['reason']);
        }

        if($response->ok()) {
            return $response->json();
        }else{
            throw new \Exception(
                'Check request ' . ' ' . $url . ' failed! Status: ' . $response->status() . '. Error: ' . $response->body(),
                $response->status()
            );
        }
    }

}
