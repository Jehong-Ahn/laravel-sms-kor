
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
   `php artisan config:publish vendor/package`
- Customize the package config files.  
   `app/config/JehongAhn/LaravelSmsKor`


