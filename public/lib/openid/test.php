<?php

    require __DIR__ . '/vendor/autoload.php';

    use Jumbojett\OpenIDConnectClient;

    $oidc = new OpenIDConnectClient(
        'http://identity-b-master.arwn7mv2hr.us-west-2.elasticbeanstalk.com/openid/',
        '093221',
        ''
    );

    $oidc->setCertPath('C:\xampp7\htdocs\openid\cert\cacert.pem');
    $oidc->addScope('profile');
    $oidc->addScope('openid');
    $oidc->authenticate();
    $name = $oidc->requestUserInfo('given_name');
    $email = $oidc->requestUserInfo('email');

?>

<html>
    
    <head>
        <title>Example OpenID Connect Client Use</title>
        <style>
            body 
            {
                font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
            }
        </style>
    </head>
    
    <body>

        <div>
            Hello <?php echo $name . ' ' . $email; ?>
        </div>

    </body>

</html>