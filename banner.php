<?php

$query = "
    SELECT COUNT(p.IMAGES) AS counts
    FROM tblpromopro pr
    JOIN tblproduct p ON pr.PROID = p.PROID
    WHERE p.PROBANNER = 1
";

$stmt = $pdo->prepare($query);
$stmt->execute();

// Fetch the result
$result = $stmt->fetch(PDO::FETCH_OBJ);

// Assign the count to $maxrow
$maxrow = $result->counts;
?>