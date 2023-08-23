<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"> <a href="https://pestphp.com/" target="_blank"></a></a></p>


## Requirement

- PHP 8.0

- MongoDB 4.2

# Langkah-langkah menjalankan project

- Exstract project ke direktori yang anda inginkan
- Buat database baru yang bernama `inosoft-penjualan-kendaraan`
- Jalankan command `composer install`
- Buat file baru yang bernama `.env`
- Copy seluruh isi dari file `.env.example`, kemudian paste isi ke file `.env` anda
- Konfigurasi `DB_CONNECTION` di file `.env` menjadi 'mongodb'
- Konfigurasi `DB_DATABASE` di file `.env` anda dengan nama database diatas
- Jalankan command `php artisan key:generate`
- Jalankan command `php artisan migrate --seed` untuk stok mobil dan motor
- Jalankan `php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"`
- Jalankan `php artisan jwt:secret`
- Jalankan project dengan command `php artisan serve`
- API sudah berjalan


## Running Tests

Untuk menjalankan unit test anda bisa menjalankan command

bash
 php artisan test

## Documentation

Api Documentation bisa dilihat dibawah ini, pastikan project sudah berjalan terlebih dahulu

`https://documenter.getpostman.com/view/5053441/2s9Y5VU4Gn`

Agar memudahkan saat testing, berikut saya lampirkan postman collection yang saya gunakan untuk testing :

`https://drive.google.com/file/d/14Ysg2-9pCILq3wr46U0n1i3hmiD7zfXl/view?usp=sharing`