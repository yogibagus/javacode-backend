<?php
$app->add(function ($request, $response, $next) {
    /**
     * Get route name
     */
    $route = $request->getAttribute('route');

    $routeName = '';
    if ($route !== null) {
        $routeName = $route->getName();
    }
    /**
     * Set Global route
     */
    $publicRoutesArray = array(
        'login',
        'session',
        'logout',
    );
    /**
     * Check session
     */
    if ($request->getHeader("Authorization")) {
        // get token from header
        $getHeader = ($request->getHeader("Authorization"));
        $token = (explode(" ", $getHeader[0]));

        // check tokens from db
        $db = $this->db;
        $getToken = getToken($db, $token[1]);
        if ($getToken != false) {
            $is_login = true;
        } else {
            $is_login = false;
        }
    } else {
        $is_login = false;
    }



    // if (($is_login != true || !isset($_SESSION['user']['akses'])) && !in_array($routeName, $publicRoutesArray)) {
    //     return unauthorizedResponse($response, ['Mohon maaf, anda tidak mempunyai akses']);
    // 
    if (!in_array($routeName, $publicRoutesArray) && $is_login == false) {
        return unauthorizedResponse($response, ['Mohon maaf, anda tidak mempunyai akses']);
    }
    /**
     * Return if isset session
     */
    return $next($request, $response);
});
