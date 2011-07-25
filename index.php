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


<h3 align="center">
<?php echo $lang->hello;?>
</h3>
<table align="center" width="99%" border="0" cellspacing="20">
<tr align="center">
<td width="33%"><a href="http://picasaweb.google.com/heldersepu">
	<?php echo $lang->photo_album;?></a>
</td>
<td width="33%"><a href="/scripts">
	<?php echo $lang->some_javascripts;?></a>
</td>
<td width="33%"><a href="/res">
	<?php echo $lang->my_resume;?></a>
</td>
</tr>

<tr align="center">
<td width="33%"><a href="/scripts/pages/Upload4.htm">
	<?php echo $lang->upload;?></a>
</td>
<td width="33%"><a href="http://www.youtube.com/user/heldersepu">
	<?php echo $lang->videos;?></a>
</td>
<td width="33%"><a href="/tictactoe">
	<?php echo $lang->tic_tac_toe;?></a>
</td>
</tr>

<tr align="center">
<td width="33%"><a href="#" onMouseover="showmenu(event,linkset[0])" onMouseout="delayhidemenu()">
	<?php echo $lang->emulators;?></a>
</td>
<td width="33%"><a href="/res/code">
	<?php echo $lang->code_samples;?></a>
</td>
<td width="33%"><a href="#" onMouseover="showmenu(event,linkset[1], '180px')" onMouseout="delayhidemenu()">
	<?php echo $lang->news_sites;?></a>
</td>
</tr>

<tr align="center">
<td width="33%"></td>
<td width="33%"><a href="http://code.google.com/p/gmapcatcher/">
	<?php echo $lang->gmapcatcher;?></a>
</td>
<td width="33%"></td>
</tr>
</table>
