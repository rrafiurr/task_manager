<h3>--> Dont forget to dump-autoload</h3>
<h3>--> Then migrate database</h3>
<h3>--> then run following coomand for sortings table seed</h3>

<p>
 php artisan vendor:publish --tag=sorting-seeder<br>
 php artisan db:seed --class=SortingTableSeeder
</p>    
