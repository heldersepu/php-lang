<?php
    include_once 'langList.php';
    include_once 'common.php';
    echoStyle();

    if ( isset($_POST['strLine'], $_POST['intLine'], $_POST['fileName'] )){
        doPost($_POST['strLine'] , $_POST['intLine'], $_POST['fileName']);
    }
    elseif(isSet($_GET['lang'])) {
        $filename = strtolower($_GET['lang']);
        if ($filename!=""){
            if (in_array($filename, getLangFiles())) {
                showEdit($filename);
            }
            else {
                badData("LANGUAGE FILE (".$filename.") NOT FOUND");
            }
        }
        else {
            badData("NO LANGUAGE FILE ENTERED");
        }
    }
    else {
        badData("NO LANGUAGE FILE ENTERED");
    }

    function doPost($strLine, $intLine, $fileName)
    {
        $strLine = str_replace("\\", "", $strLine);
        if (substr($strLine,0,1) != '"' or substr($strLine,-2) != '";') {
            showError('All lines must start with " and end with "; ', $strLine);
        }
        else
        {
            $flines  = file($fileName);
            //Update the line
            $flines[$intLine] = substr($flines[$intLine],0,40) . $strLine . "\n" ;
            //reWrite the file
            $fh = fopen($fileName, 'w');
            while(1) {
                if (flock($fh, LOCK_EX)) {
                    fwrite($fh, implode("", $flines));
                    flock($fh, LOCK_UN);
                    break;
                }
            }
        }
        showEdit($fileName);
    }

    function showError($strMessage, $strData)
    {
        iniTable();
        echo "<h1>Data not updated!</h1>";
        echo "$strMessage<br>";
        echo "<pre>".htmlspecialchars($strData)."</pre>";
        endTable();
        echo "<br>";
    }

    function showEdit($filename)
    {
        iniTable();
        echo "<h1>".$filename."</h1>";
        if ($filename != "lang.en.php") {
            echo "<h2>To prevent data losses Edit and Save only one record at a time!<h2>";
        }

        $flines  = file($filename);
        $isDictionary = False;
        echo '<table border="1" cellspacing="0">';
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>KEY</th>";
        echo "<th>VALUE</th>";
        echo "</tr>";
        foreach ($flines as $line_num => $oneLine) {
            $oneLine = trim($oneLine);
            if ($isDictionary) {
                if ($oneLine == "}") {
                    //End of the dictionary
                    $isDictionary = False;
                }
                else {
                    echo "<tr> ";
                    echo "<td><a name='ID$line_num'>$line_num</a></td>";
                    if (strpos($oneLine, "=") !== false) {
                        foreach(split("=", $oneLine) as $value) {
                            $value = trim($value);
                            if (substr($value,0,7) != "public ") {
                                echo "<td >";
                                echo "<form action='".$_SERVER['PHP_SELF']."#ID".((int)$line_num - 1)."' method='post'>";
                                echo "<input type='hidden' name='intLine' value='$line_num' />";
                                echo "<input type='hidden' name='fileName' value='$filename' />";
                                echo "<input type='text' size='90' style=' border:0; font-family: Courier' name='strLine' value='".str_replace("'", "&#39;", $value)."' />";
                                if ($filename != "lang.en.php") {
                                    echo "<input type='submit' value='Save' />";
                                }
                                echo "</form>";
                                echo "</td >";
                            }
                            else {
                                echo "<td style='color:blue'>".htmlspecialchars($value)."</td>";
                            }
                        }
                    }
                    else {
                        if (substr($oneLine,0,2) == "//"){
                            //Line Comments
                            echo "<td colspan='2' style='color:green'>".htmlspecialchars($oneLine)."</td>";
                        }
                        elseif ($oneLine == "") {
                            //Blank spaces
                            echo "<td colspan='2' >&nbsp;</td>";
                        }
                    }
                    echo "</tr>";
                }
            }
            else {
                if (strpos($oneLine, "class language {") !== false) {
                    //Begining of the dictionary
                    $isDictionary = True;
                }
            }
        }
        echo "</table>";
        endTable();
    }

    function echoStyle()
    {
        echo "<style type='text/css'>";
        echo "h1 {color:red; text-align:center;}";
        echo "h2 {color:red; text-align:center;}";
        echo "form {margin: 0; padding: 2px;}";
        echo "th {background-color:#999;}";
        echo "</style>";
    }
?>
