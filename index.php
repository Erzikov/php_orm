<?php 
require_once("Database.php");
require_once("SqlBilder.php");

$bilder = new SqlBilder();
$db = Database::getConnection();

$sql = $bilder
            ->select('users',['name', "city"])
            ->limit(2)
            ->offset(3)
            ->getQuery();

echo $sql;

$query = $db->query($sql);
$result = $query->fetchAll();

echo "<pre>";
print_r($result);
echo "</pre>";