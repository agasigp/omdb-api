# OMDB API
Contoh penggunaan api [omdbapi.com](https://www.omdbapi.com/). Dibuat untuk memenuhi tecnical test dari [PT Trawlbens Teknologi Anak Indonesia (Troben)](https://troben.id/)

## Kebutuhan Aplikasi
- Minimal PHP 8.2 (dan sesuai dengan [persyaratan server Laravel 11.x](https://laravel.com/docs/11.x/deployment#server-requirements)).

## Cara instalasi
1. Clone repositori ini dengan perintah: `git clone https://github.com/agasigp/omdb-api.git`
2. Masuk ke direktori omdb-api: `$ cd omdb-api`
3. Instal dependensi menggunakan: `$ composer install`
4. Salin berkas `.env.example` ke `.env`: `$ cp .env.example .env`
5. Generate kunci aplikasi: `$ php artisan key:generate`
6. Konfigurasi pengaturan lainnya yang dibutuhkan di berkas `.env`. Untuk api key omdbapi, bisa diisi di bagian `OMDB_APIKEY`.
    ```
    OMDB_APIKEY=omdbapikey
    ```
7. Mulai server untuk menjalankan aplikasi : `$ php artisan serve`
8. Untuk menjalankan testing otomatis, jalankan perintah : `./vendor/bin/pest`
9. Untuk aplikasi versi online, bisa diakses juga di [https://omdbapi.agasigp.web.id/](https://omdbapi.agasigp.web.id/), contoh : [https://omdbapi.agasigp.web.id/movie/detail?imdbId=tt1285011](https://omdbapi.agasigp.web.id/movie/detail?imdbId=tt1285011) untuk menampilkan detail film dengan imdb id `tt1285011`
