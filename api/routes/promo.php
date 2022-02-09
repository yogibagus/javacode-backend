<?php

// insert menu
$app->post("/promo/insert/", function ($request, $response) {
    //get request body body
    $parsedBody = $request->getParsedBody();
    $nama = $parsedBody['nama'] ?? false;
    $type = $parsedBody['type'] ?? false;
    $nominal = $parsedBody['nominal'] ?? false;
    $kadaluarsa = $parsedBody['kadaluarsa'] ?? false;
    $syarat_ketentuan = $parsedBody['syarat_ketentuan'] ?? false;

    if ($nama != false && $type != false && $nominal != false && $kadaluarsa != false && $syarat_ketentuan != false) {
        $data = [
            'nama' => $nama,
            'type' => $type,
            'nominal' => $nominal,
            'kadaluarsa' => $kadaluarsa,
            'syarat_ketentuan' => $syarat_ketentuan,
        ];

        $db     = $this->db;
        $insertPromo = $db->insert('m_promo', $data);
        if ($insertPromo != false) {
            $result = [
                'message' => 'Berhasil menambahkan promo',
                'response' => $insertPromo
            ];
            return successResponse($response, $result);
        } else {
            return unprocessResponse($response, "Data not found");
        }
    } else {
        return unprocessResponse($response, "Bad paramenters");
    }
});

// get all promo
$app->get("/promo/", function ($request, $response) {
    $db     = $this->db;
    $getPromo = getPromo($db);
    if ($getPromo != false) {
        foreach ($getPromo as $key => $value) {
            $result[] = [
                'id_promo' => $value->id_promo,
                'nama' => $value->nama,
                'type' => $value->type,
                'nominal' => $value->nominal,
                'kadaluarsa' => $value->kadaluarsa,
                'syarat_ketentuan' => $value->syarat_ketentuan,
                'gambar' => $value->gambar,
            ];
        }

        return successResponse($response, $result);
    } else {
        return unprocessResponse($response, "Data not found");
    }
});

// get promo by id promo
$app->get("/promo/{id_promo}", function ($request, $response) {
    $id_promo =  $request->getAttribute('id_promo');
    $db     = $this->db;
    $getPromoByID = getPromoByID($db, $id_promo);
    if ($getPromoByID != false) {
        $result = [
            'id_promo' => $getPromoByID->id_promo,
            'nama' => $getPromoByID->nama,
            'type' => $getPromoByID->type,
            'nominal' => $getPromoByID->nominal,
            'kadaluarsa' => $getPromoByID->kadaluarsa,
            'syarat_ketentuan' => $getPromoByID->syarat_ketentuan,
            'gambar' => $getPromoByID->gambar,
        ];

        return successResponse($response, $result);
    } else {
        return unprocessResponse($response, "Data not found");
    }
});

// update promo
$app->post("/promo/update/{id_promo}", function ($request, $response) {
    $id_promo =  $request->getAttribute('id_promo') ?? false;

    //get request body body
    $parsedBody = $request->getParsedBody();
    $nama = $parsedBody['nama'] ?? false;
    $type = $parsedBody['type'] ?? false;
    $nominal = $parsedBody['nominal'] ?? false;
    $kadaluarsa = $parsedBody['kadaluarsa'] ?? false;
    $syarat_ketentuan = $parsedBody['syarat_ketentuan'] ?? false;

    if ($nama != false && $type != false && $nominal != false && $kadaluarsa != false && $syarat_ketentuan != false && $id_promo != false) {
        $data = [
            'nama' => $nama,
            'type' => $type,
            'nominal' => $nominal,
            'kadaluarsa' => $kadaluarsa,
            'syarat_ketentuan' => $syarat_ketentuan,
        ];

        $db     = $this->db;
        $updatePromo = updatePromo($db, $data, $id_promo);
        if ($updatePromo != false) {
            $result = [
                'message' => 'Berhasil memperbarui promo',
                'response' => $updatePromo
            ];
            return successResponse($response, $result);
        } else {
            return unprocessResponse($response, "Data not found");
        }
    } else {
        return unprocessResponse($response, "Bad paramenters");
    }
});
