<?php
    require_once '../module/function.php';
    $sql = "UPDATE user SET chan_user=1 WHERE id_user=".$_GET['id'];
    $query = $db->prepare($sql);
    $query->execute();

    $sql = "DELETE FROM binhluan WHERE id_user=".$_GET['id'];
    $query = $db->prepare($sql);
    $query->execute();

    header("Location: list-binhluan.php");
?>