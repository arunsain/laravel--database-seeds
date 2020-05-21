						how to seed database in laravel

1. Create migration file for user and paste this code 

	php artisan make:model User -m

2. Paste this code in users migartion inside up function 


	Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });


3.  Create migration file for users and paste this code 

	php artisan make:model Post -m

4. Paste this code in posts migartion inside up function 


	Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });



4. Use this command to migrate table

	 	php artisan migrate

		note :- maybe its give error of this type ..

		Illuminate\Database\QueryException  : SQLSTATE[42S02]: Base table or view not found: 1146 Table 'query.priorities' doesn't exist (SQL: alter table `priorities` add constraint `priorities_user_id_foreign` foreign key (`user_id`) references `users` (`id`))

		this errors says that datatype of primary key in user table and datatype of foreign key nin post table is not same  . so please check datatype of both primary key (user table )and  foreign key (post table ) must be same .


5. Command to create seeder file (here we seed two table users and posts)

		php artisan make:seed UsersTableSeeder
		php artisan make:seed PostsTableSeeder

6. creating Laravel Model Factories


		if you go to database/factories folder, you will find that Laravel comes with the factory class for User model. It will look like something below.

		$factory->define(User::class, function (Faker $faker) {
		    return [
		        'name' => $faker->name,
		        'email' => $faker->unique()->safeEmail,
		        'email_verified_at' => now(),
		        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
		        'remember_token' => Str::random(10),
		    ];
		});

7. Create to factory for post table (factory of user is already comes with laravel)		

		php artisan make:factory PostFactory

		Note :-
		When we create the model using php artisan make:model Post command, we can pass the -f flag to create the factory with the model. We used the -m flag to generate the migration in our above example, we can run php artisan make:model Post -m -f to generate model, migration and factory all together.


8. Edit the code of PostFactory 

		use App\Post;

		$factory->define(Post::class, function (Faker $faker) {
		    return [
		        'title'         =>      $faker->sentence(6),
		        'post_date'     =>      $faker->date(),
		        'published'     =>      true,
		        'content'       =>      $faker->realText(500),
		        'user_id'       =>      function () {
		                                return App\User::inRandomOrder()->first()->id;
		        }
		    ];
		});		


9.  we have just defined our model factories, it’s time to use them. Firstly, we will open the DatabaseSeeder clsss from database/seeds folder and make following changes to run() function.

	use Illuminate\Database\Eloquent\Model;

	public function run()
    {
        Model::unguard(); // Disable mass assignment

        $this->call(UsersTableSeeder::class);
        $this->call(PostsTableSeeder::class);

        Model::reguard(); // Enable mass assignment
    }	


    Note
	By default, Laravel doesn’t allow the mass assignment for models. By using Model::unguard() method, we are disabling the mass assigmnet restrictions and after calling the seeds, we are enabling the mass assignment from models using Model::reguard() method.

10. Now, open the UsersTableSeeder class and add below line of code inside run() function.

	public function run()
	{
	    factory('App\User', 10)->create();
	}	

	In above code, we are using the facotry() helper function and creating 10 records for User model.

11. Now, in PostsTableSeeder‘s run() function, we will add below code:

		public function run()
		{
		    factory('App\Post', 20)->create();
		}	


	Here, we are creating 20 records for the Post model.
	
12. command to seed database

		php artisan db:seed

	output :  php artisan db:seed
				Seeding: UsersTableSeeder
				Seeding: PostsTableSeeder
				Database seeding completed successfully. 	

14. Another  seeder is Added for Employee

	$factory->define(Employee::class, function (Faker $faker) {

	$gender = $faker->randomElement(['male','female']);

	    return [
	         'firstName' => $faker->name,
	         'lastName' => $faker->name,
	        'email' => $faker->unique()->safeEmail,
	        'gender' => $gender,
	        'dateOfBirth' => $faker->dateTimeBetween('1990-01-01', '2007-12-31')->format('Y-m-d'),
	        'hiredOn' => $faker->dateTimeBetween('2016-01-01','2020-03-31')->format('Y-m-d'),
	    ];
	});






13. if we want to add dateofbirth add like this 

	'date_of_birth' => $faker->dateTimeBetween('1990-01-01', '2012-12-31')
	    ->format('d/m/Y'), // outputs something like 17/09/2001
