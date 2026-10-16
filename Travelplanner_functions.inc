function getdestinations($conn, $search, $category)
WHERE (name LIKE ? OR country LIKE ?)
AND (? = '' OR category = ?)
ORDER BY name