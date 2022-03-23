# ECF - ECO IT PROJECT / STUDI DIGITAL CAMPUS

<hr />

<img src="https://zupimages.net/up/22/11/nfdm.png" alt="logo eco it" width="250px" height="auto" />

<hr />

## Notion Dashboard

Hi there! You can find my project management on this Notion link => [My Notion Project](https://coffee-comic-8d3.notion.site/37fcafe356514e68ac0400ee902792b1?v=94015e345f4844d7bffc321ff7c0629f)

Well... Now, I try to described this little part of code and I give you some kind of advices to install this piece of bullshit...

## Check Requirements

I Use Symfony CLI => [Symfony CLI is good for you](https://symfony.com/download)  
First of All, try this some command line to check your requirements before install this project :

`symfony check:requirements`

You must install Composer at [Composer is Good For You](https://getcomposer.org/)  
And Yarn! At [Yarn is Good for you](https://yarnpkg.com/getting-started/install)

## Install

Fork, Download or clone my project baby and stand by me...  
Great... Now, You should do that => `composer install`  
and... That => `yarn install`

## Environment DEV

At first, you must configure your developement environment.  
I usually store my environment variables in an env.local.php file

Do the trick with => `composer dump-env dev`

Now, you should to see your .env.local.php on the root directory project.  
Configure your database at the DATABASE_URL key.

## Migrations to be Free...

Now that your environment variables are set, you will be able to create your database with :  
`symfony console doctrine:database:create`

In a second step, you will send all this beautiful data to your database using the command :  
`symfony console doctrine:migrations:migrate`

You can load of bunch of weird fixtures with :  
`symfony console doctrine:fixtures:load`

## I Want to be a User

Here some user login :

A simple and dummy learner :  
```
email : user@example.com
password : tada
```

A great but violent instructor :  
```
email: userInstructor@example.com
password : 123456
```

A super Admin :  
```
email : admin@example.com
password : tada
```
