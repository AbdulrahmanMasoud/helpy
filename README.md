# Helpy
This code as a Backend only for Helpy app to create API to use it with Flutter.
## About Helpy
Helpy app is a mobile app that supports the first 3 goals of SDGs, No poverty, zero hunger, and good health.<br>
Suppose one day that you are walking in one of Cairo streets, and you see someone hungry and need food, or on a very cold night, you found someone has a bad need for clothes or blanket or maybe he needs for health care and visit hospital.<br>
Remember with me how many times you have a surplus of food and you have to throw it, and how many times you have to store your good old clothes and buy new on.<br>
Now! In one Click

## Which Technology I am Use It In This Project?
* [Laravel]    : It is a PHP framework, Laravel is a web application framework with expressive, elegant syntax.
* [JWT]        : it called JSON Web Tokens  it is a self-contained way for securely transmitting information between parties as a JSON object
* [Swagger API]: Swagger can help you design and document your APIs at scale, so I am using it to simplify API for flutter developer.

## How To Use Helpy API
1- First one you must open API documention for <a href="http://dsc-helpy.herokuapp.com/api/documentation">Here</a>
you will see page like this image
<br><br><img src="https://i.imgur.com/ynlYG7j.png" width="400px"><br><br>
2- Second on you can go ahead to register and login and when you login you will receive a tokin to use it 
so this tokin should add it in Authorize field like this Now You Are Loged In<br><br>
<img src="https://i.imgur.com/JBywgJB.png"><br><br>
So now you can add Marker and edit  it and you can see all Markers has helped on has no help and you can help this marker also you can report about any marker.
<br>
<b>This How To Use API Let's Go To How to Run This Project On Your Local PC</b>
<br>
## How to Run This Project On Your Local PC <br>
Let's remember Laravel is PHP Framework so you will Run PHP in Your PC
so a PHP code will run as a web server module or as a command-line interface. To run PHP for the web, you need to install a Web Server like Apache and you also need a database server like MySQL. There are various web servers for running PHP programs like WAMP & XAMPP. WAMP server is supported in windows and XAMP is supported in both Windows and Linux. 
You Can Download XAMPP From <a href="https://www.apachefriends.org/download.html">Here</a><br>
Now You Can RUN Any PHP code In Your PC By Add Your Script In htdocs in Xampp Folder
<br> But you can't run Laravel Project cuse you need to install Composer And then you can Install Laravel From Compser <br>
Laravel utilizes Composer to manage its dependencies.
<br>
If your computer already has PHP and Composer installed, you may create a new Laravel project by using Composer directly. After the application has been created, you may start Laravel's local development server using the Artisan CLI's
```  composer create-project laravel/laravel example-app ```
Now you can Install Laravel Framework and also you can use any Laravel Projects. <br>
So Now You Have Everything to Run this Project.

## Run Project
1- You Must Clone This Repo Using This Comand Or Download It as ZIP File
``` git clone https://github.com/AbdulrahmanMasoud/helpy.git ```
<br>
2- Open Xampp to make server on your PC
3- make database called helpy in your xampp server in PHPMyAdmin
4- open project and run this command to migrate database
``` php artisan migrate ``` <br>
5- also run ths command to run project on xampp server
``` php artisan serv ``` <br>
6- no you can open API documentaion From this link in your PC
http://127.0.0.1:8000/api/documentation
<br>
<b>That's all about how to run this code</b>
2-
