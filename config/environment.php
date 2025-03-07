<?php
if (env('APP_ENV') == 'live'){
    $rootDomain = "https://sweete.id.vn";
    $mediaDomain = "";
    $appDomain = "http://localhost:3000";
} else if (env('APP_ENV') == 'dev'){
    $rootDomain = "https://sweete.id.vn";
    $mediaDomain = "";
    $appDomain = "http://localhost:3000";
} else {
    $rootDomain = "http://localhost:9001";
    $mediaDomain = "http://localhost:9002";
    $appDomain = "http://localhost:3000";
}
return [
    'ROOT_DOMAIN' => $rootDomain,
    'MEDIA_DOMAIN' => $mediaDomain,
    'APP_DOMAIN' => $appDomain
];
