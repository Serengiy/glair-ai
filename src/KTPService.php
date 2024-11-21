<?php

namespace Serengiy\GlairAI;

use Illuminate\Support\Facades\Http;

final class KTPService extends GlairAIAbstract
{

    private array $religion = [];
    private array $address = [];
    private array $validUntil = [];
    private array $bloodType = [];
    private array $gender = [];
    private array $district = [];
    private array $subdistrictVillage = [];
    private array $nationality = [];
    private array $cityRegency = [];
    private array $name = [];
    private array $nik = [];
    private array $occupation = [];
    private array $province = [];
    private array $neighborhoodAssociation = [];
    private array $maritalStatus = [];
    private array $birthDate = [];
    private array $birthPlace = [];
    /**
     * @throws \Exception
     */
    public function check(string $imagePath): KTPService
    {
        $url = $this->url . '/ocr/v1/ktp';
        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
        ])
            ->withBasicAuth('able-remittance', '1TuCQ7dUo2Yiz6ALFwer')
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

        if($read = $response->json()['read']){
            $this->mapResponse($read);
            return $this;
        }else{
            throw new \Exception('Failed to read image', 500);
        }
    }
    /**
     * Get the religion data.
     *
     * The returned array can either be empty or contain the following fields:
     * - "confidence" (int): The confidence level.
     * - "value" (string): The value of the religion.
     *
     * @return array{confidence?: int, value?: string} The religion data.
     */
    public function getReligion(): array
    {
        return $this->religion ?? [];
    }

    /**
     * Get the address data.
     *
     * The returned array can either be empty or contain the following fields:
     * - "confidence" (int): The confidence level.
     * - "value" (string): The value of the religion.
     *
     * @return array{confidence?: int, value?: string} The address data.
     */
    public function getAddress(): array
    {
        return $this->address ?? [];
    }

    /**
     * Get the ValidUntil data.
     *
     * The returned array can either be empty or contain the following fields:
     * - "confidence" (int): The confidence level.
     * - "value" (string): The value of the ValidUntil.
     *
     * @return array{confidence?: int, value?: string} The address data.
     */
    public function getValidUntil(): array
    {
        return $this->validUntil ?? [];
    }

    /**
     * Get the BloodType data.
     *
     * The returned array can either be empty or contain the following fields:
     * - "confidence" (int): The confidence level.
     * - "value" (string): The value of the BloodType.
     *
     * @return array{confidence?: int, value?: string} The address data.
     */
    public function getBloodType(): array
    {
        return $this->bloodType ?? [];
    }

    /**
     * Get the gender data.
     *
     * The returned array can either be empty or contain the following fields:
     * - "confidence" (int): The confidence level.
     * - "value" (string): The value of the gender.
     *
     * @return array{confidence?: int, value?: string} The address data.
     */
    public function getGender(): array
    {
        return $this->gender ?? [];
    }

    /**
     * Get the District data.
     *
     * The returned array can either be empty or contain the following fields:
     * - "confidence" (int): The confidence level.
     * - "value" (string): The value of the District.
     *
     * @return array{confidence?: int, value?: string} The address data.
     */
    public function getDistrict(): array
    {
        return $this->district ?? [];
    }

    /**
     * Get the SubdistrictVillage data.
     *
     * The returned array can either be empty or contain the following fields:
     * - "confidence" (int): The confidence level.
     * - "value" (string): The value of the SubdistrictVillage.
     *
     * @return array{confidence?: int, value?: string} The address data.
     */
    public function getSubdistrictVillage():array
    {
        return $this->subdistrictVillage ?? [];
    }

    /**
     * Get the Nationality data.
     *
     * The returned array can either be empty or contain the following fields:
     * - "confidence" (int): The confidence level.
     * - "value" (string): The value of the Nationality.
     *
     * @return array{confidence?: int, value?: string} The address data.
     */
    public function getNationality():array
    {
        return $this->nationality ?? [];
    }

    /**
     * Get the CityRegency data.
     *
     * The returned array can either be empty or contain the following fields:
     * - "confidence" (int): The confidence level.
     * - "value" (string): The value of the CityRegency.
     *
     * @return array{confidence?: int, value?: string} The address data.
     */
    public function getCityRegency():array
    {
        return $this->cityRegency ?? [];
    }

    /**
     * Get the Name data.
     *
     * The returned array can either be empty or contain the following fields:
     * - "confidence" (int): The confidence level.
     * - "value" (string): The value of the Name.
     *
     * @return array{confidence?: int, value?: string} The address data.
     */
    public function getName():array
    {
        return $this->name ?? [];
    }

    /**
     * Get the Nik (id) data.
     *
     * The returned array can either be empty or contain the following fields:
     * - "confidence" (int): The confidence level.
     * - "value" (string): The value of the Nik (id).
     *
     * @return array{confidence?: int, value?: string} The address data.
     */
    public function getNik():array
    {
        return $this->nik ?? [];
    }

    /**
     * Get the Occupation data.
     *
     * The returned array can either be empty or contain the following fields:
     * - "confidence" (int): The confidence level.
     * - "value" (string): The value of the Occupation.
     *
     * @return array{confidence?: int, value?: string} The address data.
     */
    public function getOccupation():array
    {
        return $this->occupation ?? [];
    }

    /**
     * Get the Province data.
     *
     * The returned array can either be empty or contain the following fields:
     * - "confidence" (int): The confidence level.
     * - "value" (string): The value of the Province.
     *
     * @return array{confidence?: int, value?: string} The address data.
     */
    public function getProvince():array
    {
        return $this->province ?? [];
    }

    /**
     * Get the NeighborhoodAssociation data.
     *
     * The returned array can either be empty or contain the following fields:
     * - "confidence" (int): The confidence level.
     * - "value" (string): The value of the NeighborhoodAssociation.
     *
     * @return array{confidence?: int, value?: string} The address data.
     */
    public function getNeighborhoodAssociation():array
    {
        return $this->neighborhoodAssociation ?? [];
    }

    /**
     * Get the MaritalStatus data.
     *
     * The returned array can either be empty or contain the following fields:
     * - "confidence" (int): The confidence level.
     * - "value" (string): The value of the MaritalStatus.
     *
     * @return array{confidence?: int, value?: string} The address data.
     */
    public function getMaritalStatus():array
    {
        return $this->maritalStatus ?? [];
    }

    /**
     * Get the BirthDate data.
     *
     * The returned array can either be empty or contain the following fields:
     * - "confidence" (int): The confidence level.
     * - "value" (string): The value of the BirthDate.
     *
     * @return array{confidence?: int, value?: string} The address data.
     */
    public function getBirthDate():array
    {
        return $this->birthDate ?? [];
    }

    /**
     * Get the BirthPlace data.
     *
     * The returned array can either be empty or contain the following fields:
     * - "confidence" (int): The confidence level.
     * - "value" (string): The value of the BirthPlace.
     *
     * @return array{confidence?: int, value?: string} The address data.
     */
    public function getBirthPlace():array
    {
        return $this->birthPlace ?? [];
    }

    private function mapResponse(array $read): void
    {
        $this->religion = $read['agama'] ?? null;
        $this->address = $read['alamat'] ?? null;
        $this->validUntil = $read['berlakuHingga'] ?? null;
        $this->bloodType = $read['golonganDarah'] ?? null;
        $this->gender = $read['jenisKelamin'] ?? null;
        $this->district = $read['kecamatan'] ?? null;
        $this->subdistrictVillage = $read['kelurahanDesa'] ?? null;
        $this->nationality = $read['kewarganegaraan'] ?? null;
        $this->cityRegency = $read['kotaKabupaten'] ?? null;
        $this->name = $read['nama'] ?? null;
        $this->nik = $read['nik'] ?? null;
        $this->occupation = $read['pekerjaan'] ?? null;
        $this->province = $read['provinsi'] ?? null;
        $this->neighborhoodAssociation = $read['rtRw'] ?? null;
        $this->maritalStatus = $read['statusPerkawinan'] ?? null;
        $this->birthDate = $read['tanggalLahir'] ?? null;
        $this->birthPlace = $read['tempatLahir'] ?? null;
    }
}
