<?php

    require 'google_auth.inc.php';

    $google_client_id = '945696353750-eraqu5p2v0cl21que4sfiofhbve3en6i.apps.googleusercontent.com';
    $google_client_secret = 'YbIhAq8ARhmMteFQDlQrZD0d';

    $user_info = google_auth( $google_client_id , $google_client_secret );

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