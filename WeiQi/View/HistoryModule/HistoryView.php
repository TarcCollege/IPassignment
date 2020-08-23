<?php
include('../MasterPage.html');
require '../../Controller/History/HistoryController.php';

session_start();
?>
<!DOCTYPE html>

<!-- 
 * Description of Authentication
 *
 * @author Kuek Yong Boon
-->

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/history.css">
    </head>
    <body>
        <div class="container">
            <div class="detailContainer">
                <?php
//                $_SESSION["compID"] = 1;
                $_SESSION["role"] = "admin";
                $compID = $_SESSION["compID"];
                $compHistory = getHistoryDetail($compID, $_SESSION["role"]);
                $listOfMatches = viewHistoryScore($compHistory->getHistory_ID(), $_SESSION["role"]);
                closeCon($_SESSION["role"]);


                echo "<h1> " . $compHistory->getName() . " Competition History</h1>";
                echo "<h3>". $compHistory->getHstart() . " - " . $compHistory->getHend() ."</h3>"
                ?>

                <?php
                if ($_SESSION["role"] == "admin") {
                    echo "<button onCLick=\"window.location='EditHistory.php?id=" . $_SESSION["compID"] . "'\">" . "Edit History</button>";
                }
                ?>
                <div>
                    <?php
                    echo "<div style='text-align:center;'>" . $compHistory->getRemark() . "</div>";
                    ?>
                </div>
                <div >
                    <table class="tableStyle" style='text-align:center;' border="1" >
                        <thead>
                        <th>Matches</th>
                        <th>Black</th>
                        <th>White</th>
                        <th>View Final Board</th>
                        </thead>

                        <?php
                        foreach ($compHistory->getMatches() as $value) {
                            echo "<tr>";
                            echo "<td style='text-align:center;'>" . $value["black_User"] . " vs " . $value["white_User"] . "</td>";
                            echo "<td>" . $value["black_User"] . "</td>";
                            echo "<td>" . $value["white_User"] . "</td>";

                            if ($_SESSION["role"] == "admin") {
                                echo "<td data-id='" . $value["match_ID"] . "'>"
                                . "<a style='margin-left: 5px; class='link' href='' data-href='HistoryDetail.php' >Board</a>"
                                . "<a style='margin-left: 5px;' class='link' href='EditMatch.php' data-href='EditMatch.php'>Edit</a>"
                                . "<a style='margin-left: 5px; class='link' href='HistoryDetail.php' data-href='HistoryDetail.php'>Delete</a>"
                                . "</td>";
                                echo "</tr>";
                            } else {
                                echo "<td data-id='" . $value["match_ID"] . "'>"
                                . "<a style='margin-left: 5px; class='link' href='' data-href='HistoryDetail.php' >Board</a>";
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div class="resultListContainer">
                <p>Result : </p>
                <table class="tableStyle">
                    <thead>
                    <th>Rank</th>
                    <th>Name</th>
                    <th>Score</th>
                    </thead>
                    <?php
                     $listOfMatches = calculateHistoryScore($compHistory->getMatches());
                    $index = 1;

                    foreach ($listOfMatches as $match) {
                  
                        echo "<tr>";
                        echo "<td style='text-align:center;'>" . $index . "</td>";
                        echo "<td style='text-align:center;'>" . $match["Name"] . "</td>";
                        echo "<td style='text-align:center;'>" . $match["Score"] . "</td>";
                        $index += 1;
                    }
                    ?>
                </table>
            </div>
        </div>

        <script type="text/javascript">
            var a = document.getElementsByClassName("link");

            for (var i = 0; i < a.length; i++) {
                a[i].addEventListener('click', function (e) {
                    e.preventDefault();
                    console.log(this.parentNode.getAttribute('data-id'));
                    console.log(this.getAttribute('data-href'))
                    window.location.href = this.getAttribute('data-href') + "?id="
                            + this.parentNode.getAttribute('data-id') + "";
                });
            }
        </script>

    </body>
</html>
