<?php
    include_once 'langList.php';
    include_once 'common.php';
    echoStyle();
    
    $iniKey = "public $";
    $iniValue = '"";';
    
    $strKey = $iniKey;
    $strValue = $iniValue;
    if ( isset($_POST['strKey'], $_POST['strValue'])){
        $strKey = str_replace("\\", "", $_POST['strKey']);
        $strValue = str_replace("\\", "", $_POST['strValue']);
        //Validate
        $strMessage = validate($strKey, $strValue);
        if ($strMessage == '') {
            $strMessage = doPost($strKey, $strValue);   
            $strKey = $iniKey;
            $strValue = $iniValue;
        }
    }
    iniTable();
?>

<h1 align="center">- Select Action -</h1><br>

<strong>1 - Edit Language File:</strong>
<select onchange="location = 'edit.php?lang='+this.options[this.selectedIndex].value;">
    <option value="">Select lang file </option>
    <?php
        foreach(getLangFiles() as $key => $value) {
            echo "<option value=".$value.">".$value."</option>";
        }
    ?>
</select>

<br><br><br>

<strong>2 - Create new language:</strong>
<select onchange="location = 'addnew.php?lang='+this.options[this.selectedIndex].value;">
    <option value="">Select language </option>
    <?php
        foreach($allLangList as $key => $value) {
            if (!in_array("lang.".$key.".php", getLangFiles())) {
                echo "<option value=".$key.">".$value."</option>";
            }
        }
    ?>
</select>

<br><br><br>

<strong>3 - Add new key to all dictionaries:</strong><br>

    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method='post'>
        <table border="0" cellspacing="10">
        <tr>
        <td>Key :</td>
        <td><input type='text' size='30' maxlength='25' style='font-family: Courier' name='strKey' value="<?php echo $strKey ?>" /></td>
        </tr>
        <tr>
        <td>Value : </td>
        <td><input type='text' size='80' style='font-family: Courier' name='strValue' value='<?php echo $strValue ?>' /></td>
        </tr>
        <tr>
        <td colspan='2' >
            <input type='text' size='4' name='strCode' value='Code' onkeyup='return upBtn(this);'>
            <input type='submit' value='Add Data' id='Save' disabled='true' />
        </td>
        </tr>
        </table>
    </form>


<?php
    echo "<h2>$strMessage<h2>";
    endTable();

    function doPost($strKey, $strValue)
    {
        if (substr($strKey,0,2) == '//'){
            $strNewLine = "\n        " . $strKey . $strValue . "\n" ;
        }
        else {
            $strNewLine = "        " . str_pad($strKey, 29) . " = " . $strValue . "\n" ;
        }
        foreach(getLangFiles() as $key => $fileName) {
            //Search for the end of the dictionary
            $flines  = file($fileName);            
            for ($i = count($flines); $i > 1; $i-- ) {
                $flines[$i+1] = $flines[$i];
                if (trim($flines[$i]) == "}") {
                    break;
                }                
            }
            if (trim($flines[$i]) == "}") {
                //Update the line
                $flines[$i] = $strNewLine;
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
        }
        return "Data added successfully: <br><br>" . htmlspecialchars($strNewLine);        
    }
    function validate($strKey, $strValue)
    {
        $strMessage = '';
        if (substr($strKey,0,2) == '//'){
            $strMessage = '';
        }
        elseif ($strKey == $iniKey) {
            $strMessage = "Your Key is empty! You must enter a valid Key";
        }
        elseif (substr($strKey,0,strlen($iniKey)) != $iniKey) {
            $strMessage = "The Key must start with $iniKey ' ";
        }
        elseif (strlen($strKey) > 25) {
            $strMessage = "The Key must be less than 25 chars  ";
        }
        elseif (substr($strValue,0,1) != '"' or substr($strValue,-2) != '";') {
            $strMessage = 'The Value must start with " and end with "; ';
        }
        else {
            //Prevent duplicate keys
            $flines  = file("lang.en.php");
            foreach ($flines as $line_num => $oneLine) {
                $oneLine = trim($oneLine);
                if ($oneLine[0] == "'") {
                    if (strtolower(substr($oneLine,0,strlen("$strKey"))) == strtolower($strKey)) {
                        $strMessage = 'Your key already exists! <br> <br>' . htmlspecialchars($oneLine);
                        break;
                    }
                }
            }
        }
        return $strMessage;
    }

    function echoStyle()
    {
        echo "<style type='text/css'>";
        echo "h2 {color:red; text-align:center;}";
        echo "</style>";
        echoJavaScript();    
    }
?>
