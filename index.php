<?php
include('./includes/config.php');
global $sJavascript, $sTable;

$query = mysql_query("SELECT * FROM servers ORDER BY id") or die(mysql_error());
  $sJavascript .= '<script type="text/javascript">
    function uptime() {
      $(function() {';
while($result = mysql_fetch_array($query)){
  $sJavascript .= '$.getJSON("pull/index.php?url='.$result["id"].'",function(result){
  $("#online'.$result["id"].'").html(result.online);
  $("#uptime'.$result["id"].'").html(result.uptime);
  $("#lastdown'.$result["id"].'").html(result.lastdown);
  $("#load'.$result["id"].'").html(result.load);
  $("#memory'.$result["id"].'").html(result.memory);
  $("#hdd'.$result["id"].'").html(result.hdd);
  });';
  $sTable .= '
    <tr>
      <td id="online'.$result["id"].'">
        <div class="progress">
          <div class="bar bar-danger" style="width: 100%;"><small>Down</small></div>
        </div>
      </td>
      <td>'.$result["name"].'</td>
      <td>'.$result["type"].'</td>
      <td>'.$result["host"].'</td>
      <td>'.$result["location"].'</td>
      <td id="uptime'.$result["id"].'">n/a</td>
      <td id="lastdown'.$result["id"].'">n/a</td>
      <td id="load'.$result["id"].'">n/a</td>
      <td id="memory'.$result["id"].'">
        <div class="progress progress-striped active">
          <div class="bar bar-danger" style="width: 100%;"><small>n/a</small></div>
        </div>
      </td>
      <td id="hdd'.$result["id"].'">
        <div class="progress progress-striped active">
          <div class="bar bar-danger" style="width: 100%;"><small>n/a</small></div>
        </div>
      </td>
    </tr>
  ';
}
  $sJavascript .= '});
  }
  uptime();
  setInterval(uptime, '.$sSetting['refresh'].');
  </script>';

include($index);

?>