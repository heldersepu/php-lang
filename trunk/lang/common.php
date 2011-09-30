<?php
    function badData($strMessage)
    {
        echo "<h2>$strMessage</h2>";
        echo "<a href=index.php>Click here to GO BACK!</a>";
    }

    function iniTable()
    {
        echo "<table align='center' border='0' cellpadding='0' cellspacing='0'>";
        echo "<tbody>";
        echo "    <tr>";
        echo "        <td width='9'><img src='img/bar3_left.gif' /></td>";
        echo "        <td background='img/bar3_center.gif' ></td>";
        echo "        <td width='9'><img src='img/bar3_right.gif' /></td>";
        echo "    </tr>";
        echo "    <tr>";
        echo "        <td background='img/main_left.gif'></td>";
        echo "        <td valign='top' bgcolor='#ffffff'>";
    }

    function endTable()
    {
        echo "                    <br />";
        echo "            </td>";
        echo "            <td background='img/main_right.gif'></td>";
        echo "        </tr>";
        echo "        <tr>";
        echo "            <td><img src='img/main_bottom_left.gif' /></td>";
        echo "            <td background='img/main_bottom_center.gif'><img src='img/clear_pixel.gif' width='1' height='1' /></td>";
        echo "            <td><img src='img/main_bottom_right.gif' /></td>";
        echo "        </tr>";
        echo "    </tbody>";
        echo "</table>";
    }
    
    function echoJavaScript()
    {
        $month = strtoupper(date("F"));
        echo "<script type=\"text/javascript\">";
        echo "function upBtn(theText)";
        echo "{";
        echo "  if (theText.value == '".$month[0].ord($month[1])."') {";        
        echo "    document.getElementById('Save').disabled=false;";
        echo "    return true;";
        echo "  }";
        echo "  return false;";
        echo "}";
        echo "</script>";    
    }
?>