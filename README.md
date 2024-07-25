## About Guest Book
This project is maden by Bayram for bumper's job application.

You can add new entries, you can get users' data and also you can get all entries with pagination

## How to run
Please be sure you have min qualifications. You must have, php8.1, composer, mysql, and postman(or stg like that)
You should take the postman collection in the project's main folder. Named "[Guest book.postman_collection.json](Guest%20book.postman_collection.json)"

Download the codes

run composer packages:
```shell
composer install
```

run migrations:
```shell
php artisan migrate
```

run tests:
```shell
php artisan test
```

That's all! You can start to use application with your postman now!

## WHY?
Due to lack of time, this is the most I could do. Due to my high responsibilities in the company I work for, I shortcut some of the items in the instructions. However, I realize it doesn't have to be that way. For example, I added username to each entry line. The main reason for this and similar choices was that I did not know the limits to deal with an optimized query. You cannot pull data from the users table without pagination forever. For this reason, I wrote a trigger in the entries table, and every time a new entry is entered, it finds and updates the relevant column in the users table. If I had known the character limit and the reasons why we followed this path, I could have gone through a much different process. In this case, there is no need to use indexes nor do I need to write an optimized query. Maybe what you were expecting was to measure my level of SQL knowledge, but as it is, I don't think the problem is deep enough for you to measure it. If I had time, I would also code the frontend side of this. I didn't do it because I was told "it's not difficult to do". I also ran the tests to check whether the endpoints were working. I hope you can have enough idea about me.
I wish conveniences.
