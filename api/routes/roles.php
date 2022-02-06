<?php
$app->get("/roles/", function ($request, $response) {
    $db     = $this->db;
    $result = getRoles($db);

    if ($result != false) {
        foreach ($result as $key => $value) {
            $tes[] = [
                'id_roles' => $value->id_roles,
                'akses' => json_decode($value->akses),
                'nama' => $value->nama,
            ];
        }
        return successResponse($response, $tes);
    } else {
        return unprocessResponse($response, "Data not found");
    }
});

$app->get("/roles/{id_roles}", function ($request, $response) {
    $id_roles =  $request->getAttribute('id_roles');
    $db     = $this->db;
    $result = getRolesByID($db, $id_roles);
    if ($result != false) {
        $result = [
            'id_roles' => $result->id_roles,
            'akses' => json_decode($result->akses),
            'nama' => $result->nama,
        ];
        return successResponse($response, $result);
    } else {
        return unprocessResponse($response, "Data not found");
    }
});
