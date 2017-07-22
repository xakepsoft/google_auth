<?php

    function google_auth( $google_client_id , $google_client_secret )
    {
        function redirect($url) {
            header('Location: '.$url );
            exit();
        }

        if(session_status() == PHP_SESSION_NONE) session_start();

        $redirect_uri  = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $params = [ 'redirect_uri'  => $redirect_uri , 'client_id' => $google_client_id , 'scope' => 'email profile' , 'response_type' => 'code' ];
        $auth_url = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query( $params );

        if( isset($_GET['google_signout']) && $_GET['google_signout'] == '1' )
        {
            //file_get_contents( 'https://accounts.google.com/o/oauth2/revoke?token=' . rawurlencode( $_SESSION['google_access_token'] ) );
            $_SESSION['google_access_token'] = NULL;
            $_SESSION['google_userinfo'] = NULL;
            //redirect('https://www.google.com/accounts/Logout?continue='. rawurlencode('https://appengine.google.com/_ah/logout?continue='. rawurlencode( $redirect_uri )));
            redirect('https://www.google.com/accounts/Logout?continue='. rawurlencode( $auth_url ));
        }

        if (isset( $_SESSION['google_userinfo'] ) && is_object( $_SESSION['google_userinfo'] ) )
            return  $_SESSION['google_userinfo'];
        else
        {
            $params['client_secret'] = $google_client_secret;
            $params['grant_type'] = 'authorization_code';
            $params['code'] = $_GET['code'];
            $params['response_type'] = NULL;

            if( isset($_GET['code']) && !empty($_GET['code']) )
            {
                $opts = [
                    'http'=>[ 'timeout'=>30, 'method'=>'POST', 'header'=>'Content-type: application/x-www-form-urlencoded', 'content'=>http_build_query( $params ) ],
                    'ssl'=>[ 'verify_peer' => false, 'verify_peer_name' => false ] ];

                @$tokeninfo = json_decode( file_get_contents( 'https://www.googleapis.com/oauth2/v4/token' , false , stream_context_create( $opts ) ));

                if ( !isset( $tokeninfo->access_token ) || strlen( $tokeninfo->access_token ) == 0 )
                    redirect('https://www.google.com/accounts/Logout?continue='. rawurlencode( $auth_url ));

                $opts['http'] = [ 'timeout'=>30 ];
                @$_SESSION['google_access_token'] = $tokeninfo->access_token;
                @$_SESSION['google_userinfo'] = json_decode( file_get_contents( 'https://www.googleapis.com/oauth2/v3/userinfo?access_token=' . rawurlencode($tokeninfo->access_token ) , false , stream_context_create( $opts )) );

                redirect($params['redirect_uri']); 
            }
            redirect($auth_url);
        }
    }
