<?php
/**
* Coding Pirates Teaminator
* Used to generate teams at Coding Pirates Game Jam 2015-2016
*/

include("header.php");
?>

<div class="row">
  <div class="col-md-4"></div>
  <div class="col-md-4">
    <form class="form-horizontal" name="loginForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="form-group">
        <label class="control-label col-sm-2" for="username">Brugernavn</label>
        <div class="col-sm-10 pull-right">
          <input type="text" name="username" id="username" />
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="username">Kodeord</label>
        <div class="col-sm-10 pull-right">
          <input type="password" name="password" id="password" />
        </div>
      </div>
      <br />
      <button name="submit" type="submit" class="btn btn-default btn-block">Log ind</button>
    </form>
  </div>
  <div class="col-md-4"></div>
</div>

<?php
include("footer.php");
?>
