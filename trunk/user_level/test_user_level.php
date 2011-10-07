<?php
include_once 'user_level.php';
 
$tArray[0][0] = "SERVICES";
$tArray[0][1] = "GPRS";
$tArray[0][2] = "MaxDevices";
$tArray[0][3] = "MaxAdmin"   ;
$tArray[0][4] = "MaxUsers"   ;
$tArray[0][5] = "DataQueries";
$tArray[0][6] = "DataHistory";
$tArray[0][7] = "DataReports";
$tArray[0][8] = "POIs"       ;
$tArray[0][9] = "Sensors"    ;
$tArray[0][10] = "ModDevices";
$tArray[0][11] = "EditPOI   ";
$tArray[0][12] = "Alerts    ";
$tArray[0][13] = "DefaultMap";

$maxUserLevels = 6;
for($i=1;$i<$maxUserLevels+1;$i++) {
    $uLevel = new UserLevel($i-1);
    $tArray[$i][0] = $i-1;
    $tArray[$i][1] = $uLevel->GPRS;
    $tArray[$i][2] = $uLevel->MaxDevices;
    $tArray[$i][3] = $uLevel->MaxAdmin   ;
    $tArray[$i][4] = $uLevel->MaxUsers   ;
    $tArray[$i][5] = $uLevel->DataQueries;
    $tArray[$i][6] = $uLevel->DataHistory;
    $tArray[$i][7] = $uLevel->DataReports;
    $tArray[$i][8] = $uLevel->POIs       ;
    $tArray[$i][9] = $uLevel->Sensors    ;    
    $tArray[$i][10] = $uLevel->ModDevices ;    
    $tArray[$i][11] = $uLevel->EditPOI    ;    
    $tArray[$i][12] = $uLevel->Alerts     ;    
    $tArray[$i][13] = $uLevel->DefaultMap ;    
}


echo "<table border = 1 cellpadding = 5 cellspacing = 0>";
echo "<tr><td width='100' >&nbsp;</td>";
echo "<td bgcolor='#87CEEB'align=center colspan=$maxUserLevels>";
echo "USER_LEVELS</td></tr>";
for($j=0;$j<14;$j++) {    
    echo "<tr align=center>";
    foreach(array(0,1,3,4,5,6,2) as $i) {
        echo ($j!=0 && $i!=0) ? "<td width='60'>": 
             (($i!=0) ? "<th bgcolor='#87CEEB'>" : "<th bgcolor='#E0E0E0'>") ;
        echo $tArray[$i][$j]   ;
        echo ($j!=0 && $i!=0) ? "</td>": "</th>"   ;        
    }
    echo "</tr> ";
}
echo "</table>";
?>

