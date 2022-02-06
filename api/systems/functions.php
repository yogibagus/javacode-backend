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
