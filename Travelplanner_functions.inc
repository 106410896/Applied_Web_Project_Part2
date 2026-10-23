/*----
       Created by Kshitij Shetty ----*/


<?php 
function getdestinations($conn, $search, $category)
{
    $sql = "SELECT * FROM destinations
            WHERE (name LIKE ? OR country LIKE ?)
            AND (? = '' OR category = ?)
            ORDER BY name";

   $stmt = mysqli_prepare($conn, $sql);
    $like = '%' . $search . '%';
    mysqli_stmt_bind_param($stmt, 'ssss', $like, $like, $category, $category);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}