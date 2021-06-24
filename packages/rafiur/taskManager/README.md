--> Dont forget to dump-autoload
--> Then migrate database
--> then run following coomand for sortings table seed

 php artisan vendor:publish --tag=sorting-seeder
 php artisan db:seed --class=SortingTableSeeder