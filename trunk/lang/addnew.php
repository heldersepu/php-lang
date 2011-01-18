<?php
    include_once 'langList.php';
    include_once 'common.php';
    echoStyle();

    if ( isset($_POST['strSource'], $_POST['strDest'])){
        doPost($_POST['strSource'] , $_POST['strDest']);
    }
    elseif(isSet($_GET['lang'])) {
        $lang = strtolower($_GET['lang']);
        if ($lang!=""){
            if (!in_array("lang.".$lang.".php", getLangFiles())) {
                if(preg_match("/^[a-zA-Z0-9_-]*$/",$lang)){
                    showAddNew($lang);
                }
                else {
                    badData("LANGUAGE (".$lang.") HAS INVALID CHARS");
                }
            }
            else {
                badData("THAT LANGUAGE ALREADY EXISTS");
            }
        }
        else {
            badData("NO LANGUAGE ENTERED");
        }
    }
    else {
        badData("NO LANGUAGE ENTERED");
    }

    function doPost($strSource, $strDest)
    {
        if (!in_array($strDest, getLangFiles())) {
            if (copy($strSource, $strDest)) {
                iniTable();
                echo "<h1>File created successfully</h1>";
                echo "you can now edit your file: <a href=edit.php?lang=$strDest>$strDest</a><br>";
                echo "or you can also <a href=index.php>go back to the main page</a>";
                endTable();
            }
            else
            {
                showError("There was an error creating the file, please try again in a few minutes.");
            }
        }
        else
        {
            showError("That file already exists.");
        }
    }

    function showError($strMessage)
    {
        iniTable();
        echo "<h1>File not Created!</h1>";
        badData($strMessage);
        endTable();
        echo "<br>";
    }

    function showAddNew($lang)
    {
        iniTable();
        $langFile = "lang.".$lang.".php";
        echo "<h1>$langFile</h1>";
        echo "Your new languange file will be created from the english template! <br>";
        echo "<form action='".$_SERVER['PHP_SELF']."'  method='post'>";
        echo "<input type='hidden' name='strSource' value='lang.en.php' />";
        echo "<input type='hidden' name='strDest' value='$langFile' /><br>";
        echo "<input type='text' size='4' name='strCode' value='Code' onkeyup='return upBtn(this);'>";
        echo "<input type='submit' id='Save' disabled='true' value='Create File' />";
        echo "</form>";
        endTable();
    }

    function echoStyle()
    {        
        echo "<style type='text/css'>";
        echo "h1 {color:red; text-align:center;}";
        echo "</style>";
        echoJavaScript();
    }

?>
