<?php
function validasi($data, $custom = array())
{
    $validasi = array(
        "nama"       => "required",
        "username"   => "required",
        "m_roles_id" => "required",
    );
    GUMP::set_field_name("m_roles_id", "Hak Akses");
    $cek = validate($data, $validasi, $custom);
    return $cek;
}
/**
 * Ambil semua user aktif tanpa pagination
 */
$app->get("/users/", function ($request, $response) {
    $db     = $this->db;
    $result = getUsers($db);
    if ($result != false) {
        return successResponse($response, $result);
    } else {
        return unprocessResponse($response, "Data not found");
    }
});

$app->get("/users/{id_user}", function ($request, $response) {
    $id_user =  $request->getAttribute('id_user');
    $db     = $this->db;
    $result = getUsersByID($db, $id_user);
    if ($result != false) {
        return successResponse($response, $result);
    } else {
        return unprocessResponse($response, "Data not found");
    }
});

$app->post("/users/delete/{id_user}", function ($request, $response) {
    $id_user =  $request->getAttribute('id_user');
    $db     = $this->db;
    $delete_user = updateUser($db, ['is_deleted' => 1], $id_user);
    if ($delete_user != false) {
        $result = [
            'message' => "User berhasil dihapus"
        ];
        return successResponse($response, $result);
    } else {
        return unprocessResponse($response, "Gagal menghapus user. User tidak ditemukan");
    }
});

$app->post("/users/update/{id_user}", function ($request, $response) {
    $parsedBody = $request->getParsedBody();
    $email = $parsedBody['email'] ?? false;
    $nama = $parsedBody['nama'] ?? false;
    $hak_akses = $parsedBody['hak_akses'] ?? false;

    if ($email != false && $hak_akses != false && $nama != false) {
        $id_user =  $request->getAttribute('id_user');
        $db     = $this->db;
        $data = [
            'email' => $email,
            'nama' => $nama,
            'm_roles_id' => $hak_akses,
        ];
        $update = updateUser($db, $id_user, $data);
        if ($update != false) {
            return successResponse($response, $update);
        } else {
            return unprocessResponse($response, "Gagal menghapus user. User tidak ditemukan");
        }
    } else {
        return unprocessResponse($response, "Bad request");
    }
});

// Ambil customer
$app->get("/users/customers/", function ($request, $response) {
    $db     = $this->db;
    $result = getUsersByRoles($db, 2);
    if ($result != false) {
        return successResponse($response, $result);
    } else {
        return unprocessResponse($response, "Data not found");
    }
});
