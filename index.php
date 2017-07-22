<?php

    // Simple example of Google authentication for your application

    // Get client_id and client_secret for your Web application here: https://console.developers.google.com/apis/credentials
    // Please don't forget to register URL of this script as an Authorized redirect URI
    //      https://www.example.com/example_project/index.php

    $client_id = '945696353750-eraqu5p2v0cl21que4sfiofhbve3en6i.apps.googleusercontent.com';
    $client_secret = 'YbIhAq8ARhmMteFQDlQrZD0d';
    require 'google_auth.inc.php';
    $user_info = google_auth( $client_id , $client_secret );

    // At this point user is already authenticated by google...
    // $user_info contains all relevant information.



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
