<?php

function getdestinations($conn, $search, $category)
{
    "SELECT name, country,category,avg_daily_cost, best month,
    FROM destinations
WHERE (name LIKE ? OR country LIKE ?)
AND (? = '' OR category = ?)
ORDER BY name";

$stmt = mysqli_prepare ($conn, $sql);
if (!$stmt) {
    return[];
}

$like= '%' . $search . '%';
mysqli_stmt_bind_param($stmt,'ssss', $like, $category, $category);
mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
 $rows = $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
    mysqli_stmt_close($stmt);

    return $rows;
}