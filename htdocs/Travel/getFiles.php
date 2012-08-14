<?php


if ($handle = opendir('xls/')) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            echo '<li id="'.$entry.'" class="plupload_done"><div class="plupload_file_name"><span>'.$entry.'</span></div><div class="plupload_file_action"><a href="xls/'.$entry.'" style="display: block; "></a></div><div class="plupload_file_status">100%</div><div class="plupload_file_size">'.round((filesize("xls/".$entry)/1024)).' KB</div><div class="plupload_clearer">&nbsp;</div><input type="hidden" name="html4_uploader_0_name" value="'.$entry.'"><input type="hidden" name="html4_uploader_0_status" value="done"></li>';
        }
    }
    closedir($handle);
}
?>