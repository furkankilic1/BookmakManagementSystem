<?php
require "db.php";
?>

<div>

    <center>
        <h3>Search Page</h1>
        <h4>You are looking at results of '<?= $_POST['term'] ?>' term;</h4>
    </center>
    <div>

        <?php
        try {
            $rowcnt = 0;
            $term = $_POST['term'];
            $trimmed = trim($term);
            if ($trimmed != '') {
                $stmt = $db->prepare("select * from bookmark where title LIKE :keywords OR note LIKE :keywords;");
                $stmt->bindValue(':keywords', "%$term%");
                $stmt->execute();

                $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $rowcnt = $stmt->rowCount();


                if ($rowcnt != 0) {
                    echo '<table class="striped container" style= "margin-top:20px">
                            <tr style= "height:60px" class="grey lighten-5">
                                <th class="title">Title</th>
                                <th>Note</th>
                            </tr> ';
                    foreach ($list as $listbm) {
                        echo "<tr>";
                        echo "<td><span><a href='".$listbm["url"]."'>".$listbm["title"]."</a></span></td>" ;
                        echo "<td><span>".$listbm["note"]."</span></td>" ;
                        echo "</tr>";
                    }

                    echo "</table>";
                }
            }

            if ($rowcnt == 0) {
                echo '
                      <center><div class="red" style="margin-top: 60px;">
                        <strong>Sorry!</strong>
                        <br>We could not find any result related to this term.
                        </div></center><br><br><br>';
            }
        } catch (Exception $ex) {
            echo "<p>DB Error : " . $ex->getMessage() . " </p>";
        }

        ?>
    </div>
    <br>
    <?php if ($rowcnt > 0) {
    ?>
        <p style="text-align: center; clear: both;">There are <?= $rowcnt ?> items.</p>
    <?php
    }
    ?>
</div>