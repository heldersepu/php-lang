<?php
session_start();
include ('lang_handler.php');
?>

Language: 
<select onchange="location = 'index.php?lang='+this.options[this.selectedIndex].value;">                  
    <option>Select your language</option>
    <?php
        foreach(getLanguageList() as $key => $value) {
            echo "<option value=".$value.">";
            echo isset($allLangList[$value])? $allLangList[$value] : $value ;
            echo "</option>";
        }
    ?>
</select>            
<br/>
<br/>

<?php
echo "<h1> $lang->hello </h1>";

echo $lang->the_end;

?>