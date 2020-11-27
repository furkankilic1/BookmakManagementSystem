<?php
  $register_link = ["home", "loginForm"] ;
  $login_link = ["home", "registerForm"] ;
  $main_link = ["main"] ;
?>
<style>
  .pht{height: 420px;}
</style>

<nav style="background: #142850;">
    <div class="nav-wrapper">
      <a href="?" class="brand-logo"><i class="material-icons left hide-on-med-and-down">home</i>BMS</a>
      <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
      
      <!-- Menu Items -->
      <?php
      $menu_items = [
        "desktop" => '<ul id="nav-mobile" class="right hide-on-med-and-down">',
        "mobile" => '<ul class="sidenav" id="mobile-demo">'
      ];

     

      ?>

      <?php foreach($menu_items as $type => $menu)  : ?>
          <?= $menu ?>
          <?php if ( $type == "mobile") : ?>
            <li class="red-text" style="margin-left: 3em; margin-top:2em">BMS v1.0</li>
            <li class="divider"></li>
          <?php endif ?>
          <?php if ( in_array($page, $register_link)) : ?>
            <li>
                <a href="?page=registerForm"><i class="material-icons left">person_add</i>Register</a>
            </li>
          <?php endif ?>

          <?php if ( in_array($page, $login_link)) : ?>
            <li>
                  <a href="?page=loginForm"><i class="material-icons left">directions_run</i>Sign in</a>
            </li>
          <?php endif ?>

          <?php if ( in_array($page, $main_link)) : ?>
            <li>
            <?php
            //Cem burası normalde AJAX olmalıymış.
                 require "db.php";
                 //Getting shared info 
                 $shared = $db->query("select * from share,bookmark where receiver_id = {$_SESSION["user"]["id"]} and bookmarkid = bookmark.id");
                 $count = $shared->rowCount();
                 if ( $count >= 1) {
                  $share_info = $shared->fetchAll(PDO::FETCH_ASSOC) ;
                }
            ?>
              <?php if ( $_SESSION["user"] != NULL ) : ?>
                  <a href="?page=sharedbm" class="modal-trigger barred"><i class="material-icons" style="margin-right:0px;">notifications_active</i></a> 
                <?php endif ?>
              </li>
              <li>
              <?php if ( $_SESSION["user"] != NULL ) : ?>
                <a class="waves-effect waves-light btn-small red" style="margin-top: 0px; margin-left:0px;" <?= isset($share_info)  ? ' style="display:block"' : 'none' ?>> <span>0 new</span></a>
                <?php endif ?>
              </li>
            <li>
                
                <?php if ( $_SESSION["user"]["profile"] != NULL ) : ?>
                  <a href="?page=profile">
                    <img src="upload/<?= $_SESSION["user"]["profile"] ?>" class="profile_pic">  <?= $_SESSION["user"]["name"] ?> 
                  </a>
                <?php endif ?>
                <?php if ( $_SESSION["user"]["profile"] == NULL ) : ?>
                  <a href="?page=profile">
                      <a href="?page=profile"><i class="material-icons left">person</i><?= $_SESSION["user"]["name"] ?></a> 
                  </a>
                <?php endif ?>
            </li>
            <li>
                <a href="?page=logout"><i class="material-icons left">exit_to_app</i>Logout</a>
            </li>
          <?php endif ?>
      </ul>
      <?php endforeach ?>
    </div>
  </nav>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems);
  });
  </script>