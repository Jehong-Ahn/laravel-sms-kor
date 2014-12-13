
## Laravel sms bundle for korean

Currently available for cafe24.


### INSTALL

1. composer.json
1. composer update
1. app/config/app.php
	'providers' => Array(
		...,
		'JehongAhn\LaravelSmsKor\LaravelSmsKorServiceProvider'
	);
	'aliases' => Array(
		...,
		'Sms' => 'JehongAhn\LaravelSmsKor\Sms',
	);
1. Publish the package config files.  
   `php artisan config:publish vendor/package`
1. Customize the package config files.  
   `app/config/JehongAhn/LaravelSmsKor`


