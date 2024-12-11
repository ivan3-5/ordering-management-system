<?php
    include 'DbConnector.php';
    include 'CommonQueryService.php';

    $activeTransaction = GetActiveTransaction($conn, $session_id);

    echo json_encode($activeTransaction);
?>