<?php
include('db.php');
if(isset($_POST['id'])){
    $id = intval($_POST['id']);
    $res = mysqli_query($conn, "SELECT * FROM offers WHERE id = $id");
    echo json_encode(mysqli_fetch_assoc($res));
}
?>