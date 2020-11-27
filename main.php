<style>
  .profile_pic {
    width: 35px;
    height: 35px;
    border-radius: 50%;
  }

  .sideBar {
    border-right: 1px solid grey;
    float: left;
    text-align: center;
    height: 545px;
  }

  .collection {
    width: 200px;
    margin-left: 35px;
    margin-top: 10px;
  }

  .row {
    margin-top: 90px;
  }

  .colorBtn {
    background: #142850;
  }
</style>
<?php

require "db.php";

// To remember sort between pages.
// You can use the same technique for page numbers in pagination.
//$sort = $_GET["sort"] ?? "created" ;
if (!isset($_GET["sort"])) {
  $sort = $_SESSION["sort"] ?? "created";
} else {
  $sort = $_GET["sort"];
  $_SESSION["sort"] = $sort;
}

if (!isset($_GET["show"])) {
  $show = $_SESSION["show"] ?? "All";
} else {
  $show = $_GET["show"];
  $_SESSION["show"] = $show;
}

$userTable = $db->query("select * from user where id != {$_SESSION["user"]["id"]} order by name")->fetchAll(PDO::FETCH_ASSOC);
$users = $db->query("select * from user order by name")->fetchAll(PDO::FETCH_ASSOC);
$bookmarks = $db->query("select user.id uid, bookmark.category ct, bookmark.id bid, name, title, note, created, url
                            from bookmark, user 
                            where user.id = bookmark.owner and user.id = {$_SESSION["user"]["id"]}
                            ")->fetchAll(PDO::FETCH_ASSOC);
//Category SQL                           
$sqlAllCategories =  "select categoryname from categories order by categoryname";
try {
  $stmtAllCategories = $db->query($sqlAllCategories);
  $allCategories = $stmtAllCategories->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
  die("<p>Try Later</p>");
}
 

?>

<!-- Floating button at the bottom right -->
<div class="fixed-action-btn ">
  <a class="btn-floating btn-large red modal-trigger z-depth-2" href="#add_form">
    <i class="large material-icons colorBtn">add</i>
  </a>
</div>

<!-- Categories and Search -->
<div class="sideBar">

  <!-- Categories-->
  <div class="left">
    <div class="collection">
      <a href="?show=All" <?= $show == 'All' ? ' class="collection-item active"' : 'class="collection-item"' ?>>All</a>
      <?php foreach ($allCategories as $cat) : ?>
        <a href="?show=<?= $cat["categoryname"] ?>" <?= $show == $cat["categoryname"] ? ' class="collection-item active"' : 'class="collection-item"' ?>><?= $cat["categoryname"] ?></a>
      <?php endforeach ?>
    </div>
    <a href="#add_cat" class="btn-floating btn-medium waves-effect waves-light colorBtn modal-trigger"><i class="material-icons">add</i></a>
    <a href="$del_cat" class="btn-floating btn-medium waves-effect waves-light colorBtn modal-trigger"><i class="material-icons">remove</i></a>

    <!-- Search -->
    <div class="container" style="padding-top: 20px;">
      <form action="?page=search" method="post" class="container">
        <input name="term" value="<?php if (isset($_POST['term'])) echo $_POST['term']; ?>" type="search" placeholder="Search" aria-label="Search">
        <button class="btn" type="submit">Search</button>
      </form>
    </div>
  </div>

</div>

<!-- Main Table for all bookmarks -->
<div>
  <?php
  $selected = [];
  foreach ($bookmarks as $bms) {
    if ($show == 'All' || $show == $bms['ct']) {
      $selected[] = ["bid" => $bms["bid"], "title" => $bms["title"], "note" => $bms["note"], "url" => $bms["url"]];
    }
  }

  $no = $_GET["pagination"] ?? 1;
  $size = count($selected);
  $start = ($no - 1) * 4;
  $end = $start + 4 > $size ? $size : $start + 4;
  $totalPage = (int) ceil($size / 4);
  ?>

  <div style="width: 78%; " class="right">
    <table class="striped" id="main-table">
      <tr style="height:60px" class="grey lighten-5">
        <th class="title" style="width: 20%;">
          <a href="?sort=title">Title
            <?= $sort == "title" ? "<i class='material-icons'>arrow_drop_down</i>" : "" ?>
          </a>
        </th>
        <th class="note">
          <a href="?sort=note">Note
            <?= $sort == "note" ? "<i class='material-icons'>arrow_drop_down</i>" : "" ?>
          </a>
        </th>
        <th class="action">Actions</th>
      </tr>

      <?php for ($i = $start; $i < $end; $i++) : ?>
        <?php
        $bm = $selected[$i];
        ?>
        <tr id="row<?= $bm["bid"] ?>">
          <td><span class="truncate"><a href="<?= $bm['url'] ?>"><?= $bm['title'] ?></a></span></td>
          <td><span class="truncate"><?= $bm['note'] ?></span></td>
          <td class="action">
            <a class="btn-small modal-trigger colorBtn" href="#edit<?= $bm['bid'] ?>"><i class="material-icons">edit</i></a>
            <a href="<?= $bm["bid"] ?>" class="bms-delete btn-small colorBtn"><i class="material-icons">delete</i></a>
            <a href="#share<?= $bm['bid'] ?>" class="modal-trigger btn-small colorBtn" ><i class="material-icons">share</i></a>
            <a class="btn-small modal-trigger colorBtn" href="#bm<?= $bm['bid'] ?>"><i class="material-icons">visibility</i></a>
          </td>
        </tr>
      <?php endfor ?>
    </table>
    <?php
    echo "<ul class='pagination'>";
    if ($no == 1) {
      echo '<li class="disabled"><a href=""><i class="material-icons">chevron_left</i></a></li>';
    } else {
      echo "<li><a href='?pagination=" . ($no - 1) . "'><i class='material-icons'>chevron_left</i></a></li>";
    }

    for ($i = 1; $i <= $totalPage; $i++) {
      echo "<li ",
        ($no == $i ? "class='active'" : ""),
        "><a href='?page=main&pagination=$i'>$i</a></li>";
    }

    if ($no == $totalPage) {
      echo '<li class="disabled"><a href=""><i class="material-icons">chevron_right</i><a href=""></li>';
    } else {
      echo "<li class='waves-effect'><a href='?pagination=" . ($no + 1) . "'><i class='material-icons'>chevron_right</i></a></li>";
    }
    echo "</ul>";
    ?>

  </div>

  <!-- View Modal -->
  <?php foreach ($bookmarks as $bm) : ?>
    <div id="bm<?= $bm['bid'] ?>" class="modal">
      <div class="modal-content">
        <table class="striped">
          <tr>
            <td>Title:</td>
            <td><?= $bm['title'] ?></td>
          </tr>
          <tr>
            <td>Category:</td>
            <td><?= $bm['ct'] ?></td>
          </tr>
          <tr>
            <td>Notes:</td>
            <td><?= $bm['note'] ?></td>
          </tr>
          <tr>
            <td>URL:</td>
            <td><?= $bm['url'] ?></td>
          </tr>
          <tr>
            <td>Date:</td>
            <td><?= $bm['created'] ?></td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat colorBtn" style="color:aliceblue;">Close</a>
      </div>
    </div>
  <?php endforeach ?>

  <!-- EditBookmark Modal -->
  <?php foreach ($bookmarks as $bm) : ?>
    <div id="edit<?= $bm['bid'] ?>" class="modal">
      <form action="?page=editBM" method="post">
        <div class="modal-content">
          <input type="hidden" name="bookid" value="<?= $bm["bid"] ?>">
          <h5 class="center">Edit Bookmark</h5>
          <div class="input-field">
            <input id="edittitle" type="text" name="edittitle" placeholder="<?= $bm['title'] ?>">
            <label for="edittitle">Title</label>
          </div>
          <div class="input-field">
            <input id="editurl" type="text" name="editurl" placeholder="<?= $bm['url'] ?>">
            <label for="editurl">URL</label>
          </div>
          <div class="input-field">
            <textarea id="editnote" class="materialize-textarea" name="editnote" placeholder="<?= $bm['note'] ?>"></textarea>
            <label for="editnote">Notes</label>
          </div>
          <select class="browser-default" name="editcategory">
            <option disabled selected>Choose Category</option>
            <?php
            foreach ($allCategories as $cat) {
              $categ = $cat["categoryname"];
              echo " <option  value='$categ'>$categ</option> ";
            }
            ?>
          </select>
          <div class="input-field">
            <a class="waves-effect waves-light btn disabled">Bookmark ID: <?= $bm['bid'] ?> </a>
          </div>

        </div>
        <div class="modal-footer">
          <button class="btn waves-effect waves-light colorBtn" type="submit" name="action">Edit
            <i class="material-icons right">send</i>
          </button>
        </div>
      </form>
    </div>
  <?php endforeach ?>

  <!-- Modal Form for new Bookmark -->
  <div id="add_form" class="modal">
    <form action="?page=addBM" method="post">
      <div class="modal-content">
        <h5 class="center">New Bookmark</h5>
        <select class="browser-default" name="addcategory">
          <option disabled selected>Choose Category</option>
          <?php
          foreach ($allCategories as $cat) {
            $categ = $cat["categoryname"];
            echo " <option value='$categ'>$categ</option> ";
          }
          ?>
        </select>
        <input id="uidforajax" type="hidden" name="owner" value="<?= $_SESSION["user"]["id"] ?>">
        <div class="input-field">
          <input id="title" type="text" name="title">
          <label for="title">Title</label>
        </div>
        <div class="input-field">
          <input id="url" type="text" name="url">
          <label for="url">URL</label>
        </div>
        <div class="input-field">
          <textarea id="note" class="materialize-textarea" name="note"></textarea>
          <label for="note">Notes</label>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn waves-effect waves-light" type="submit" name="action">Add
          <i class="material-icons right">send</i>
        </button>
      </div>
    </form>

  </div>

  <!-- Modal Form for new Category -->
  <div id="add_cat" class="modal">
    <form action="?page=addCat" method="post">
      <div class="modal-content">
        <h5 class="center">New Category</h5>
        <div class="input-field">
          <input id="category" type="text" name="addnewcategory">
          <label for="category">Category Name</label>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn waves-effect waves-light" type="submit" name="action">Add
          <i class="material-icons right">send</i>
        </button>
      </div>
    </form>

  </div>

  <!-- Modal Form for delete Category -->
  <div id="del_cat" class="modal">
    <form action="?page=delCat" method="post">
      <div class="modal-content">
        <h5 class="center">Delete Category</h5>
        <select class="browser-default" name="deletecategory">
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
        <button class="btn waves-effect waves-light" type="submit" name="action">Delete
          <i class="material-icons right">delete</i>
        </button>
      </div>
    </form>

  </div>

  <!-- Share Modal -->
  <?php foreach ($bookmarks as $bm) : ?>
    <div id="share<?= $bm['bid'] ?>" class="modal" style="margin-top: 100px;">
      <form action="?page=share" method="post">
        <div class="modal-content">
          <input type="hidden" name="bmId" value="<?= $bm["bid"] ?>">
          <h5 class="center">Share Bookmark</h5>
          <select class="browser-default" name="selectUser">
            <option disabled selected>Choose User to Share</option>
            <?php
            foreach ($userTable as $us) {
              echo '<option value="' . $us["id"] . '">' . $us["name"] . '</option>';
            }
            ?>
          </select>
        </div>

        <div class="modal-footer">
          <button class="waves-effect waves-light btn colorBtn" type="submit" name="action">Share
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


    $(function() {
      // page is loaded
      //alert("jquery works");
      $(".bms-delete").click(function(e) {
        e.preventDefault();
        // alert("Delete Clicked") ;
        let id = $(this).attr("href");
        //alert( id + " clicked");
        $("#loader").toggleClass("hide"); // show loader.
        $.get("index.php", {
            "page": "delete",
            "id": id
          },
          function(data) {
            console.log(data);
            $("#row" + id).remove(); // removes from html table.
            $("#loader").toggleClass("hide"); // hide loader.
          },
          "json"
        );
      });

    });

      var ncnt = 0; 
      var cnt = 0; 
      // At startup, retrieve exchange rates.
      getNotificationCount() ;

      $(function() {
      window.setInterval(function(){
        getNotificationCount() ;
      }, 5000) ; 

      $(".barred").click(function() {
        //ve databasede seen olanların hepsi 1 olacak
        let nuid = $("#uidforajax").attr("value") ;
        $.get("notification.php", {"userid" : nuid , "isseen" : '1' }, function(data) {
          $(".red span").text("0 new") ;
        }, "json" ) ;
      });
    });
   
      // This sends an HTTP GET request 
      function getNotificationCount() {
        let nuid = $("#uidforajax").attr("value") ;
        $.get("notification.php", {"userid" : nuid }, function(data) {
            $(".red span").text(data + " new") ;
        },"json" ) ;
      }
   
  </script>

  

  <div class="center hide" id="loader">
    <div class="preloader-wrapper small active">
      <div class="spinner-layer spinner-green-only">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div>
        <div class="gap-patch">
          <div class="circle"></div>
        </div>
        <div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>
    </div>
  </div>

