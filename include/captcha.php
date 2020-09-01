<?php

try {
    function getCaptcha($secretKey)
    {
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . SECRET_KEY . "&response={$secretKey}");
        $x = json_decode($response);
        return $x;
    }

    $return = getCaptcha($reqHeaders['key']);
    var_dump($return);
} catch (PDOException $e) {
    echo 'captcha went wrong:' . "\n" . $e->getMessage() . "\n\n";
}
