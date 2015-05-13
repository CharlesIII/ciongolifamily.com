<?php
    
    //Set the name you want to use for your recipe site (this will appear on any emails sent out)
    
    $clientname='My Web Recipe Manager';
    
    //Set the email you would like to be used to receive any help or registration forms submitted
    
    $csuppemail='';
    
    //The following line sets the name for email address from which all emails will be sent from My Web Recipe Manager
    
    $emailfrom="My Web Recipe Manager Administrator";
    
    //The following sets the signature at the bottom of courtesy emails sent to people who use the contact form, etc. the <br> tag creates a new line.
    
    $emailsig='Thankyou,<br>Support<br>My Web Recipe Manager';
    
    //******* Below are the settings used to customise your version of My Web Recipe Manager
    //******* These settings are written in PHP so plase ensure you don't change or remove any ' " or ; characters
    //******* If you need any help with these settings please use the help link on your home page to contact
    //******* Web Recipe Manager Support
    
    //set the url to your copy of My Web Recipe Manager on your server at $wrmpath="url"
    //for example if you have placed the mywrm folder on your local server on your pc use $wrmpath="localhost/mywrm/"
    //if it's on a remote server use $wrmpath="http://www.yourdomain/mywrm/"
    //DON'T FORGET THE TRAILING / character
    
    $wrmpath="localhost/mywrm/";
    
    //set the url to your login page at $emailurl="url" this will be included in emails sent to new users
    
    $emailurl='';
    
    //you will need a mail server setup on your server
    //uncomment the next 2 lines (remove the // at the beginning of the line) and replace the server and the port with your mail server details
    //HINT the port is usually 25
    
    //$eserver="";
    //$eport=25;
    
    //If authentification is required on your mail server or you are using the gmail server - uncomment the 3 lines
    //below (remove the // at the beginning of each line) and replace user and password with your values
    
    //$eauthreq="yes";
    //$euser="";
    //$epass="";
    
    //If you wish to upload pdfs to your recipes that will display within your recipe you will need to install Imagemagick 
    //on your computor/server and enter the path to the convert executable (convert.exe) here with a slash on the end. 
    //It is suggested you install to the location shown here otherwise it may not be found.
    //On a unix server the path will be something like /usr/local/bin/
    
    $impath='C:/IM/';
    
    //database settings
    
    //choose whether you are using a postgresql or mysql database  by commenting or uncommenting the appropriate line below
    
    $dbsql = 'mysql';
    //$dbsql = 'postgresql';
    
    //change the name of your recipe database here if you chose not to use the default
    
    $dbrecipes = 'mywrm';
    
    // set the user and password for your database here
    
    $dbuser = "username";
    $dbpass = "password";
    
    //change the domain where your database resides here if it is not on your local server
    
    $dbhost = "localhost";
    
    //*********** DON'T CHANGE ANYTHING BELOW THIS LINE *************
    
    $client='mywrm';

?>