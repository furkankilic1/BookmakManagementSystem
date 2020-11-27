<?php
//Cem burası normalde AJAX olmalıymış.
require "db.php";
$sqlAllCategories =  "select categoryname from categories order by categoryname";
try {
  $stmtAllCategories = $db->query($sqlAllCategories);
  $allCategories = $stmtAllCategories->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
  die("<p>Try Later</p>");
}

//Getting shared info 
$shared = $db->query("select * from share,bookmark where receiver_id = {$_SESSION["user"]["id"]} and bookmarkid = bookmark.id");
$count = $shared->rowCount();
if ($count >= 1) {
    $share_info = $shared->fetchAll(PDO::FETCH_ASSOC);
}else{
  header("Location: ?page=main") ;
  exit;
}
?>

<div class="container">
        <h4 class="center" style="margin-top: 30px; margin-bottom: 30px;">Shared Bookmarks</h4>
        <table class="striped">
            <tr>
                <td>Title</td>
                <td>Notes</td>
                <td>URL</td>
                <td>Add</td>
            </tr>
            <?php foreach ($share_info as $bsh) : ?>
                <tr>
                    <td><?= $bsh['title'] ?></td>
                    <td><?= $bsh['note'] ?></td>
                    <td><?= $bsh['url'] ?></td>
                    <td>
                    <a href="#add<?= $bsh['id'] ?>" class="modal-trigger btn-small colorBtn" ><i class="material-icons">add</i></a>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
</div>

<?php foreach ($share_info as $bsh) : ?>
    <div id="add<?= $bsh['id'] ?>" class="modal" style="margin-top: 100px;">
      <form action="?page=addSharedBM" method="post">
        <div class="modal-content">
          <input type="hidden" name="bshurl" value="<?= $bsh["url"] ?>">
          <input type="hidden" name="bshowner" value="<?= $_SESSION["user"]["id"] ?>">
          <input type="hidden" name="bshtitle" value="<?= $bsh["title"] ?>">
          <input type="hidden" name="bshnote" value="<?= $bsh["note"] ?>">
          <h5 class="center">Add Shared Bookmark</h5>
          <select class="browser-default" name="bshcategory">
            <option disabled selected>Choose Category</option>
            <?php
            foreach ($allCategories as $cat) {
              $categ = $cat["categoryname"];
              echo " <option  value='$categ'>$categ</option> ";
            }
            ?>
          </select>
        </div>

        <div class="modal-footer">
          <button class="waves-effect waves-light btn colorBtn" type="submit" name="action">Add Bookmark
            <i class="material-icons right">keyboard_arrow_right</i>
          </button>
        </div>
      </form>
    </div>
  <?php endforeach ?>

   <!-- Initialization of modal elements and listboxes -->
   <script>
    document.addEventListener('DOMContentLoaded', function() {
      var elems = document.querySelectorAll('.modal');
      var instances = M.Modal.init(elems);

      elems = document.querySelectorAll('select');
      M.FormSelect.init(elems);
    });
  </script>