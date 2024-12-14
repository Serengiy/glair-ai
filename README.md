## SendPulse laravel package

### Installation

```
composer require serengiy/send-pulse
```

#### 1.	Add the Service Provider
```
Serengiy\GlairAI\Providers\GlairAIServiceProvider::class
```
#### 2.	Publish the Configuration File
Run the following Artisan command to publish the SendPulse configuration file:
```
php artisan vendor:publish --provider="Serengiy\GlairAI\Providers\GlairAIServiceProvider"
```

#### 3.	Add Environment Variables
Add the following configuration values to your .env file:

```dotenv
GLAIR_OCR_BASE_URL=YOUR_BASE_URL
GLAIR_API_KEY=YOUR_API_KEY
GLAIR_USERNAME=YOUR_GLAIR_USERNAME
GLAIR_PASSWORD=YOUR_GLAIR_PASSWORD
```
