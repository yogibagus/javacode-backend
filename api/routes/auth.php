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
$app->post("/auth/login/", function ($request, $response) {

    $parsedBody = $request->getParsedBody();
    $email = $parsedBody['email'] ?? false;
    $password = $parsedBody['password'] ?? false;

    if ($email != false && $password != false) {

        // get user
        $db     = $this->db;
        $user = getUsersByEmail($db, $email);

        if ($user != false) {
            $passwordHash = $user->password;
            // $tes = password_hash($password, PASSWORD_DEFAULT);
            if (password_verify($password, $passwordHash)) {

                // get roles
                $id_roles =  $user->m_roles_id;
                $roles = getRolesByID($db, $id_roles);

                // set token
                $token = bin2hex(random_bytes(16)) . $user->id_user;

                //get tokens
                $id_user =  $user->id_user;
                $db     = $this->db;
                $check_token = getTokenByIDUser($db, $id_user);

                if ($check_token == false) {
                    $data_token = [
                        'token' => $token,
                        'm_user_id' => $id_user
                    ];
                    $db     = $this->db;
                    $insert_token = $db->insert('m_token', $data_token);
                } else {
                    $db     = $this->db;
                    $insert_token = $db->update('m_token', ['token' => $token], ['m_user_id' => $id_user]);
                }

                if ($roles != false && $check_token != false && $insert_token != false) {
                    /**
                     * Simpan user ke dalam session
                     */
                    if (isset($user)) {
                        $_SESSION['user']['id']         = $user->id_user;
                        $_SESSION['user']['username']   = $user->username;
                        $_SESSION['user']['nama']       = $user->nama;
                        $_SESSION['user']['m_roles_id'] = $user->m_roles_id;
                        $_SESSION['user']['token']      = $token;
                        $_SESSION['user']['akses']      = json_decode($roles->akses);
                        $session = 'saved';
                    } else {
                        $session = 'not saved';
                    }

                    // set user
                    $data_user = [
                        'id_user' => $user->id_user,
                        'email' => $user->email,
                        'nama' => $user->nama,
                        'm_roles_id' => $user->m_roles_id,
                        'akses' => json_decode($roles->akses),
                        'token' => $token
                    ];

                    $result =  [
                        'user' => $data_user,
                        'session' => $session
                    ];

                    return successResponse($response, $result);
                } else {
                    return unprocessResponse($response, "Kesalahan saat menyimpan data");
                }
            } else {
                return unprocessResponse($response, "Password salah");
            }
        } else {
            return unprocessResponse($response, "Data not found");
        }
    } else {
        return unprocessResponse($response, "Data not found");
    }
})->setName('login');;
