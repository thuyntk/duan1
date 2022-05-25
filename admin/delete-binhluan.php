<?php
    require_once '../module/db.php';
    $id = (int)$_GET['id'];
    $sql = "DELETE FROM binhluan WHERE id_bl = $id";
    $query = $db->prepare($sql);
    $query->execute();
    header("Location: list-binhluan.php");
?>