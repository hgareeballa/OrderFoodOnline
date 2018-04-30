<div style="width: 640px; margin: 0 auto;">
   <h3>File upload Page.</h3>
 
<?php echo form_open_multipart('frontpage/do_upload');?>

<input type="file" name="userfile" size="20" />
<br /><br />

<input id="submit" type="Submit" value="upload" />

</form>

<div id="alert" class="alert alert-info">
make sure you remember the photo name. <br>

<? if (!empty($res)) echo $res; ?>
</div>

 