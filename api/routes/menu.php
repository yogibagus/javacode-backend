<?php
// insert menu
$app->post("/menu/insert/", function ($request, $response) {
    //get request body body
    $parsedBody = $request->getParsedBody();
    $nama = $parsedBody['nama'] ?? false;
    $harga = $parsedBody['harga'] ?? false;
    $deskripsi = $parsedBody['deskripsi'] ?? false;
    $kategori = $parsedBody['kategori'] ?? false;

    if ($nama != false && $harga != false && $deskripsi != false && $kategori != false) {
        $data = [
            'nama' => $nama,
            'harga' => $harga,
            'deskripsi' => $deskripsi,
            'kategori' => $kategori,
            'created_by' => "",
            'modified_by' => ""
        ];

        $db     = $this->db;
        $insertMenu = $db->insert('m_menu', $data);
        if ($insertMenu != false) {
            $result = [
                'message' => 'Berhasil menambahkan menu',
                'response' => $insertMenu
            ];
            return successResponse($response, $result);
        } else {
            return unprocessResponse($response, "Data not found");
        }
    } else {
        return unprocessResponse($response, "Bad paramenters");
    }
});

// get All menu
$app->get("/menu/", function ($request, $response) {
    $db     = $this->db;
    $result = getMenu($db);
    if ($result != false) {
        return successResponse($response, $result);
    } else {
        return unprocessResponse($response, "Data not found");
    }
});


// get menu by id menu
$app->get("/menu/{id_menu}", function ($request, $response) {
    $id_menu =  $request->getAttribute('id_menu');
    $db     = $this->db;
    $result = getMenuByID($db, $id_menu);
    if ($result != false) {
        return successResponse($response, $result);
    } else {
        return unprocessResponse($response, "Data not found");
    }
});


// get menu by id menu
$app->get("/menu/detail/{id_menu}", function ($request, $response) {
    $id_menu =  $request->getAttribute('id_menu');
    $db     = $this->db;
    $getMenu = getMenuByID($db, $id_menu);
    if ($getMenu != false) {
        $db     = $this->db;
        $getTopping = getTopping($db, $id_menu);
        ($getTopping == false ? $getTopping = "Topping tidak tersedia" : $getTopping);

        $db     = $this->db;
        $getLevel = getLevel($db, $id_menu);
        ($getLevel == false ? $getLevel = "Level tidak tersedia" : $getLevel);

        $result = [
            'menu' => $getMenu,
            'topping' => $getTopping,
            'level' => $getLevel,
        ];


        return successResponse($response, $result);
    } else {
        return unprocessResponse($response, "Data not found");
    }
});

// delete menu
$app->post("/menu/delete/{id_menu}", function ($request, $response) {


    // get atribute
    $id_menu =  $request->getAttribute('id_menu') ?? false;

    if ($id_menu != false) {
        $db     = $this->db;
        $data = [
            'is_deleted' => 1,
            'modified_by' => "",
            'modified_at' => "",
        ];
        $updateMenu =  updateMenu($db, $data, $id_menu);
        if ($updateMenu != false) {
            $result = [
                'message' => 'Berhasil menghapus menu',
                'response' => $updateMenu
            ];
            return successResponse($response, $result);
        } else {
            return unprocessResponse($response, "Data not found");
        }
    } else {
        return unprocessResponse($response, "Bad parameters");
    }
});

// update menu
$app->post("/menu/update/{id_menu}", function ($request, $response) {
    // get atribute
    $id_menu =  $request->getAttribute('id_menu') ?? false;

    //get body
    $parsedBody = $request->getParsedBody();
    $nama = $parsedBody['nama'] ?? false;
    $harga = $parsedBody['harga'] ?? false;
    $deskripsi = $parsedBody['deskripsi'] ?? false;
    $kategori = $parsedBody['kategori'] ?? false;

    if ($id_menu != false && $nama != false && $harga != false && $deskripsi != false && $kategori != false) {
        $db     = $this->db;
        $data = [
            'nama' => $nama,
            'harga' => $harga,
            'deskripsi' => $deskripsi,
            'kategori' => $kategori,
            'modified_by' => "",
            'modified_at' => ""
        ];
        $updateMenu =  updateMenu($db, $data, $id_menu);
        if ($updateMenu != false) {
            $result = [
                'message' => 'Berhasil menghapus menu',
                'response' => $updateMenu
            ];
            return successResponse($response, $result);
        } else {
            return unprocessResponse($response, "Data not found");
        }
    } else {
        return unprocessResponse($response, "Bad parameters");
    }
});


// insert detail menu
$app->post("/menu/insert/detail/", function ($request, $response) {
    //get body
    $parsedBody = $request->getParsedBody();
    $id_menu = $parsedBody['id_menu'] ?? false;
    $type = $parsedBody['type'] ?? false;
    $harga = $parsedBody['harga'] ?? false;
    $keterangan = $parsedBody['keterangan'] ?? false;

    if ($type != false && $harga != false && $keterangan != false && $id_menu != false) {
        $db     = $this->db;
        $data = [
            'id_menu' => $id_menu,
            'type' => $type,
            'harga' => $harga,
            'keterangan' => $keterangan,
            'created_by' => "",
            'modified_by' => "",
        ];
        $insertDetailMenu =  $db->insert('m_detail_menu', $data);
        if ($insertDetailMenu != false) {
            $result = [
                'message' => 'Berhasil menambahkan detail menu',
                'response' => $insertDetailMenu
            ];
            return successResponse($response, $result);
        } else {
            return unprocessResponse($response, "Something when wrong during inserting data");
        }
    } else {
        return unprocessResponse($response, "Bad parameters");
    }
});



// update detail menu
$app->post("/menu/update/detail/{id_detail_menu}", function ($request, $response) {
    // get atribute
    $id_detail_menu =  $request->getAttribute('id_detail_menu') ?? false;

    //get body
    $parsedBody = $request->getParsedBody();
    $type = $parsedBody['type'] ?? false;
    $harga = $parsedBody['harga'] ?? false;
    $keterangan = $parsedBody['keterangan'] ?? false;

    if ($id_detail_menu != false && $type != false && $harga != false && $keterangan != false) {
        $db     = $this->db;
        $data = [
            'type' => $type,
            'harga' => $harga,
            'keterangan' => $keterangan,
            'modified_by' => "",
            'modified_at' => ""
        ];
        $updateDetailMenu =  updateDetailMenu($db, $data, $id_detail_menu);
        if ($updateDetailMenu != false) {
            $result = [
                'message' => 'Berhasil memperbarui detail menu',
                'response' => $updateDetailMenu
            ];
            return successResponse($response, $result);
        } else {
            return unprocessResponse($response, "Something when wrong during inserting data");
        }
    } else {
        return unprocessResponse($response, "Bad parameters");
    }
});
