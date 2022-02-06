<?php

// Ambil customer
$app->get("/tokens/", function ($request, $response) {
    $db     = $this->db;
    $result = getUsersByRoles($db, 2);
    if ($result != false) {
        return successResponse($response, $result);
    } else {
        return unprocessResponse($response, "Data not found");
    }
});
