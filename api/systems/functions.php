<?php
function getUsers($db)
{
    $db->select("*")
        ->from("m_user")
        ->where("is_deleted", "=", 0);

    return $db->findAll();
}

function getUsersByID($db, $id_user)
{
    $db->select("*")
        ->from("m_user")
        ->where("is_deleted", "=", 0)
        ->andWhere("id_user", "=", $id_user);
    return $db->find();
}

function getUsersByRoles($db, $id_roles)
{
    $db->select("*")
        ->from("m_user")
        ->where("is_deleted", "=", 0)
        ->andWhere("m_roles_id", "=", $id_roles);
    return $db->findAll();
}

function getUsersByEmail($db, $email)
{
    $db->select("*")
        ->from("m_user")
        ->where("is_deleted", "=", 0)
        ->andWhere("email", "=", $email);
    return $db->find();
}

function updateUser($db, $id_user, $data)
{
    return $db->update('m_user', $data, ['id_user' => $id_user, 'is_deleted' => 0]);
}

function getTokenByIDUser($db, $id_user)
{
    $db->select("*")
        ->from("m_token")
        ->where("m_user_id", "=", $id_user);
    return $db->find();
}

function getToken($db, $token)
{
    $db->select("*")
        ->from("m_token")
        ->where("token", "=", $token);
    return $db->find();
}

function getRoles($db)
{
    $db->select("*")
        ->from("m_roles");
    return $db->findAll();
}

function getRolesByID($db, $id_roles)
{
    $db->select("*")
        ->from("m_roles")
        ->where("id_roles", "=", $id_roles);
    return $db->find();
}

function getMenu($db)
{
    $db->select("a.id_menu, a.nama, a.harga, a.status, a.kategori, b.nama_kat_menu")
        ->from("m_menu as a")
        ->leftJoin('m_kategori_menu as b', 'a.kategori = b.id_kat_menu')
        ->where("a.is_deleted", "=", 0);
    return $db->findAll();
}

function getMenuByID($db, $id_menu)
{
    $db->select("a.id_menu, a.nama, a.harga, a.status, a.kategori, a.deskripsi, b.nama_kat_menu")
        ->from("m_menu as a")
        ->leftJoin('m_kategori_menu as b', 'a.kategori = b.id_kat_menu')
        ->where("a.is_deleted", "=", 0)
        ->andWhere("a.id_menu", "=", $id_menu);
    return $db->find();
}

function getTopping($db, $id_menu)
{
    $db->select("id_detail_menu, type, harga, keterangan, id_menu")
        ->from("m_detail_menu")
        ->where("id_menu", "=", $id_menu)
        ->andWhere("is_deleted", "=", 0)
        ->andWhere("type", "=", "topping");
    return $db->findAll();
}

function getLevel($db, $id_menu)
{
    $db->select("id_detail_menu, type, harga, keterangan, id_menu")
        ->from("m_detail_menu")
        ->where("id_menu", "=", $id_menu)
        ->andWhere("is_deleted", "=", 0)
        ->andWhere("type", "=", "level");
    return $db->findAll();
}

function updateMenu($db, $data, $id_menu)
{
    return $db->update('m_menu', $data, ['id_menu' => $id_menu]);
}

function updateDetailMenu($db, $data, $id_detail_menu)
{
    return $db->update('m_detail_menu', $data, ['id_detail_menu' => $id_detail_menu]);
}

function getPromo($db)
{
    $db->select("*")
        ->from("m_promo")
        ->where("is_deleted", "=", 0);
    return $db->findAll();
}

function getPromoByID($db, $id_promo)
{
    $db->select("*")
        ->from("m_promo")
        ->where("is_deleted", "=", 0)
        ->andWhere("id_promo", "=", $id_promo);
    return $db->find();
}

function updatePromo($db, $data, $id_promo)
{
    return $db->update('m_promo', $data, ['id_promo' => $id_promo]);
}
