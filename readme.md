
## Laravel sms bundle for korean

Currently available for cafe24.


### INSTALL

- composer.json
- composer update
- app/config/app.php  
```php
	'providers' => Array(
		...,
		'JehongAhn\LaravelSmsKor\LaravelSmsKorServiceProvider'
	);
	'aliases' => Array(
		...,
		'Sms' => 'JehongAhn\LaravelSmsKor\Sms',
	);
```	
- Publish the package config files.  
   `php artisan config:publish jehong-ahn/laravel-sms-kor`
- Customize the package config files.
   `app/config/packages/jehong-ahn/laravel-sms-kor`


### HOW TO USE

```php
Sms::send([
	'phone' => '01011112222', // recipient
	'message' => 'Hello.'
]);
```

