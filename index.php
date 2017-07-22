<?php

    // This is a simple example of how to use Google user authentication in your application.

    // First you need to get google client_id and client_secret for your app 
    //  - https://console.developers.google.com/apis/credentials

    // Then you need to register all URL(s) of your app entry points as an Authorized redirect URIs:

    //  if the index.php is in a subdirectory you have to register these 3 URIs:
    //      https://www.example.com/example_dir/index.php
    //      https://www.example.com/example_dir/
    //      https://www.example.com/example_dir

    //  if the index.php is in a web root directory you have to register these 3 URIs:
    //      https://www.example.com/index.php
    //      https://www.example.com/
    //      https://www.example.com

    $client_id = '945796353720-eraqu5p2v0cl21que4sfiofhbve3en6i.apps.googleusercontent.com';
    $client_secret = 'YbIhAq8ARhmMteFQDlQrZD0d';
    require 'google_auth.inc.php';
    $user_info = google_auth( $client_id , $client_secret );

    // At this point user is authenticated by Google...
    // $user_info contains all relevant user information



    $allowed_users = [ 
          'dummy_user1@gmail.com' , 
          'john.smith@example.com' ,
          'larry.page@google.com' ,
          'zapavednik@yandex.com' ,
          ];
          
    if( in_array( $user_info->email , $allowed_users ) )
    {
        echo "<font color=green><h2>ACCESS GRANTED!</h2></font>\n";
        echo "User: <b>" , $user_info->name ,"</b> has been successfully authenticated by GOOGLE and is allowed to access our application...";
    }
    else
    {
        echo "<font color=red><h2>ACCESS DENIED!</h2></font>\n";
        echo "User: <b>" , $user_info->name ,"</b> has been successfully authenticated by GOOGLE but has not been whitelisted by our app yet...";
    }
          
          
    echo "<br /><pre>User info:" , print_r( $user_info , true ); 


    echo '<a href="?google_signout=1"><b>GOOGLE Signout</b></a>';
