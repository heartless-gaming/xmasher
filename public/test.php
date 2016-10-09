<?php
if (!empty($_POST)) {
  var_dump($_POST);
  var_dump($_FILES);
}
?>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="foo" value=""/>
    <input type="submit" value="Upload File"/>
</form>
