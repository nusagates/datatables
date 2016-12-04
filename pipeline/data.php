<?php
try {
  $db = new PDO("mysql:host=localhost;dbname=DATABASE;charset=utf8mb4", "USER", "PASSWORD");
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
  exit("Tidak dapat menyambungkan dengan database! " . $ex->getMessage());
}
$k=array();
$sql = "SELECT count(*) FROM airport"; 
$result = $db->prepare($sql); 
$result->execute(); 
$total = $result->fetchColumn(); 
$mulai= $_GET['start'];
$limit= $_GET['length'];
$ambil = $db->query("SELECT * FROM airport limit $mulai,$limit");
while ($row = $ambil->fetch(PDO::FETCH_BOTH)) {
  $k[]=array('id'=>$row[0], 'country_code'=>$row[1], 'airport_code'=>$row[2]);
  $data= array(
    "draw" => $_GET['draw'],
    "recordsTotal" => $total,
    "recordsFiltered" =>$total,
    "data" => $k);
}

echo json_encode($data);
