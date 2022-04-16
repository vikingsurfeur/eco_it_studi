# ECF - ECO IT PROJECT / STUDI DIGITAL CAMPUS

<hr />

<img src="https://zupimages.net/up/22/11/nfdm.png" alt="logo eco it" width="250px" height="auto" />

<hr />

## Table of Contents
- [Project - Notion Dashboard](#notion-dashboard)
- [Requirements](#check-requirements)
- [Install](#install)
- [Environment Variables](#environment-dev)
- [Migrations - Database](#migrations-to-be-free)
- [Login](#ready-to-fight)
- [Using this App](#i-want-to-be-a-user)
- [Known Issues](#known-issues)
- [Contact Me](#contact-me)


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

After fixtures loading, you can log in with those ultra secure passwords :

A simple and dummy learner :  
```
email : user@example.com
password : tada
```

A great but violent instructor :  
```
email: instructor@example.com
password : tada
```

A super Admin :  
```
email : admin@example.com
password : tada
```

#### <b>Beware Dude, CRSF is checked in my Security Protocol, you must cleared your cache before changing User log in !</b>

## Ready to Fight !

#### ADMIN ROLE
<b>Now, you can log in with your admin ID and see your users on the dashboard.</b>  
Move the accepted boolean field to the first instructor have you seen.

#### INSTRUCTOR ROLE
Now you can log out and log back in with the Instructor account.
If you log in with the instructor account without having validated his account, you will see that the dashboard will be blocked pending validation by an admin.   
So happy? Now that you are logged in as an instructor, you can create your courses, your sections and much more dude!  

#### LEARNER / USER ROLE
When you are logged in as a learner/user, you will need to register for a course before you can take it.  
Your courses will be stored on the "Mes Cours" page.  
Once your lessons are over, check the box and you will be able to see your progress thanks to the badges.  
Once the section is over, a Quiz will be unlocked if it has one.

## Known Issues
- Connected as an instructor, to the addition of a collection of images for lessons, if a block of adding image is carried out without filling it in, we get an error in the validation of the form.
- No Quiz form validation yet...

## Contact Me
If you are interested in working with me on open source projects, I'm up for it! I am still a beginner but I have a good foundation in JS / TS / Node / React and PHP / Symfony / API Platform.

See You!
D.Bouscarle