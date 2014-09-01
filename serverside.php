<?php
$m=new Mysqli("localhost","root","","test");
if (stripos($_SERVER['REQUEST_METHOD'],"post")!==FALSE) {
 $person=json_decode(file_get_contents('php://input'));
 if(isset($_REQUEST['addperson'])) {
  error_log('addperson ' . json_encode($person,JSON_NUMERIC_CHECK));
  $sql="insert into people values (0,'$person->name','$person->age')";
  $m->query($sql);
  if ($m->errno!=0) {
    http_response_code(503);
    exit("{\"err\":\"".$m->error."\"}");
   }
  $person->id=$m->insert_id;
  exit(json_encode($person,JSON_NUMERIC_CHECK));
 } else if(isset($_REQUEST['updateperson'])) {
  $sql="update people set name='" . $person->name . "', age=" . $person->age . " where id = " . $person->id;
  error_log($sql);
  $m->query($sql);
  if ($m->errno!=0) {
    http_response_code(503);
    exit("{\"err\":\"".$m->error."\"}");
  }
  exit(json_encode($person,JSON_NUMERIC_CHECK));
 }else if(isset($_REQUEST['deleteperson'])) {
  $sql="delete from people where id=$person->id";
  error_log($sql);
  $m->query($sql);
  exit(json_encode($person->id,JSON_NUMERIC_CHECK));
 }
} else {
 $res=$m->query("select * from people");
 exit (json_encode($res->fetch_all(MYSQLI_ASSOC),JSON_NUMERIC_CHECK));
}
?>
