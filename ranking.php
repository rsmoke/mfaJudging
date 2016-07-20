<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContestJudging.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION["isJudge"]) {

    if (isset($_POST["summarize"])) {
        //gather all ten entries and build an insert query
        //scrub inputs

        $responses = $_POST;
        $resultset = "";
        foreach ($responses as $key => $value) {

            if ($key != "summarize") {
                if (substr($key, 0, 4) == "entr") {
                    $resultset .= "('" . $login_name . "'," . $db->real_escape_string(htmlspecialchars($value)) . ",";
                } elseif (substr($key, 0, 4) == "cont") {
                    $resultset .= $db->real_escape_string(htmlspecialchars($value)) . ",";
                } elseif (substr($key, 0, 4) == "rank") {
                    if ($value > 0) {
                        $resultset .= $db->real_escape_string(htmlspecialchars($value)) . ",";
                    } else {
                        $resultset .= "0,";
                    }
                } elseif (substr($key, 0, 4) == "summ") {
                    $resultset .= "'" . $db->real_escape_string(htmlspecialchars($value)) . "',";
                } elseif (substr($key, 0, 4) == "comm") {
                    $resultset .= "'" . $db->real_escape_string(htmlspecialchars($value)) . "'),";
                }
            }
        }
        $insertValues = trim($resultset, ",");

        $sqlInsert = <<<SQL
        INSERT INTO `quilleng_ContestManager`.`tbl_ranking`
        (`rankedby`,
        `entryid`,
        `contestID`,
        `rank`,
        `summarycomment`,
        `committeecomment`
        )
        VALUES
        $insertValues
SQL;
        if (!$result = $db->query($sqlInsert)) {
            dbFatalError($db->error, " -data insert issue- ", $sqlInsert, $login_name);
            exit($user_err_message);
        } else {
            $db->close();
            unset($_POST['summarize']);
            safeRedirect('ranking.php');
            exit();
        }
        unset($_POST['summarize']);
    }

    if (isset($_GET["ctst"])) {
        $contestID = htmlspecialchars(($_GET["ctst"]));
    } else {
        $contestID = "Variable ctst Not sent!";
        nonDbError(" -ranking page access error- variable ctst= " . $contestID, $login_name);
        exit($user_err_message);
    }

    ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="utf-8">

    <title>LSA-<?php echo "$contestTitle"; ?> Writing Contests</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="LSA-English Writing Contests">
    <meta name="keywords" content="LSA-English, Hopwood, Writing, UniversityofMichigan">
    <meta name="author" content="LSA-MIS_rsmoke">
    <link rel="icon" href="img/favicon.ico">

    <link rel="stylesheet" href="css/bootstrap.min.css"><!-- 3.3.1 -->
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/bootstrap-formhelpers.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/normalize.css" media="all">
    <link rel="stylesheet" href="css/default.css" media="all">
    <link rel="stylesheet" href="css/validator.css" media="all">

    <base href=<?php echo URL ?>>
  </head>

  <body>
          <nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
            <div class="container">
            <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="index.php"><?php echo "$contestTitle"; ?><span style="color:#00FF80"> - Judging</span></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                   <a href="#" class="dropdown-toggle" data-toggle="dropdown">Signed in as <?php echo $login_name; ?><strong class="caret"></strong></a>
                  <ul class="dropdown-menu">
                    <li>
                      <a href="index.php"><?php echo "$contestTitle"; ?> main</a>
                    </li>
                    <li>
                      <a href="https://weblogin.umich.edu/cgi-bin/logout">logout</a>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
            </div>
          </nav>

    <div class="container"><!-- container of all things -->
    <div class="row clearfix">
      <div class="col-md-12">
          <div>
              <h4>You are submitting evaluations for
<?php
$contestSelect = <<<SQL
  SELECT name
  FROM tbl_contest
  JOIN lk_contests ON (lk_contests.id = tbl_contest.contestsID)
  WHERE tbl_contest.id = $contestID
SQL;

    if (!$result = $db->query($contestSelect)) {
        dbFatalError($db->error, "data select issue", $sqlSelect);
        exit($user_err_message);
    }
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo $row['name'];
        }
    }
    ?>

</h4>
      <div class="bg-warning infosection">
           <p><strong>Ranking  Instructions:</strong> Using the
           dropdown menu next to each entry, select a ranking value (1 <em>being the best</em> down to 10) for that entry. You will only be selecting
           a ranking for the top ten entries.</p>
           <p><em>NOTE: Each time you select a number it will no longer be available from the dropdown list. If you want to use a rank value that is already on another entry
           you will need to remove the value from the other entry first. </em></p>

        <a class="btn btn-xs btn-warning fa fa-info-circle" href="http://lsa.umich.edu/hopwood/contests-prizes.html" target="_blank"> Contest Rules</a>

      </div>
    </div>

           <hr>

          <form class="validate-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

          <table class="table table-hover">
            <thead>
              <th>Ranking<br><small><em>1 is best</em></small></th><th>Entry Title</th><th>Read</th><th>Authors<br>Pen-name</th><th>Division</th><th>Comments for<br>contestants</th><th>Comments for<br>committee</th><th><small>entry id</small></th>
            </thead>
            <tbody>
            <?php
$getratings = <<<SQL
    SELECT *
    FROM vw_entrydetail_with_classlevel AS vw
    LEFT OUTER JOIN tbl_ranking ON (vw.`EntryId`= `tbl_ranking`.`entryid` AND `tbl_ranking`.rankedby = '$login_name')
    WHERE vw.ContestInstance = $contestID AND vw.manuscriptType IN (
      SELECT DISTINCT name
      FROM `lk_category`
      JOIN `tbl_contestjudge` AS CJ ON (CJ.`categoryID` = `lk_category`.`id`)
      WHERE uniqname = '$login_name') AND vw.status = 0 AND
            ((CASE WHEN vw.`classLevel` < 20 THEN 1 WHEN  vw.`classLevel` = 20 THEN 2 END) =
              (SELECT CJ2.classLevel
                FROM `tbl_contestjudge` AS CJ2
                WHERE CJ2.uniqname = '$login_name' AND CJ2.`contestsID` =
                (SELECT contestsID
                  FROM tbl_contest
                  WHERE tbl_contest.id = $contestID)) OR 0 =
                  (SELECT CJ2.classLevel
                    FROM `tbl_contestjudge` AS CJ2
                    WHERE CJ2.uniqname = '$login_name' AND CJ2.`contestsID` =
                    (SELECT contestsID
                      FROM tbl_contest
                      WHERE tbl_contest.id = $contestID)))


SQL;
//$resultsInd = $db->query($getratings);
        //if (!$resultsInd) {
        if (!$resultsInd = $db->query($getratings)) {
            dbFatalError($db->error, "data select issue", $getratings);
            exit($user_err_message);
        }
        if ($resultsInd->num_rows <= 0) {
            echo "<tr><td>There are no rated entries available</td></tr>";
        } else {
            while ($entry = $resultsInd->fetch_assoc()) {
                echo '<input type="hidden" name="entryID_' . $entry['EntryId'] . '" value="' . $entry['EntryId'] . '">
              <input type="hidden" name="contestID_' . $entry['EntryId'] . '" value="' . $contestID . '">
              <tr><td>
                <div class="form-group">
                  <select class="form-control" id="rank_' . $entry['EntryId'] . '" name="rank_' . $entry['EntryId'] . '">
                    <option></option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                    <option>7</option>
                    <option>8</option>
                    <option>9</option>
                    <option>10</option>
                  </select>
                </div>
              </td><td>
                ' . $entry['title'] . '
              </td><td>
                <a href="contestfiles/' . $entry['document'] . '" target="_blank"><span class="fa fa-book fa-lg"></span></a>
              </td><td>
                ' . $entry['penName'] . '
              </td><td>
                ' . $entry['manuscriptType'] . '
              </td>
              <td>
                <textarea class="form-control" id="summaryComment" name="summaryComment_' . $entry['EntryId'] . '" ></textarea>
              </td><td>
                <textarea class="form-control" id="committeeComment" name="committeeComment_' . $entry['EntryId'] . '" ></textarea>
              </td>
              <td><small>
                ' . $entry['EntryId'] . '
              </small></td>
              </tr>';
            }
        }

        ?>

            </tbody>
          </table>
          <input type="submit" class="btn btn-success" name="summarize" value="Submit"/>
          </form>
          <p>Status: <span id="status">Unsubmitted</span></p>
<?php include "footer.php";?>
    <!-- //additional script specific to this page -->
      <script src="js/jdgMyScript.js"></script>
      <script src="js/validator.js"></script>
</div><!-- End Container of all things -->
</body>
</html>

<?php
$db->close();
} else {
    nonDbError(" -ranking submission error- isJudge set to: " . $_SESSION["isJudge"], $login_name);
    ?>
  <!doctype html>

  <html lang="en">
        <head>
          <meta charset="utf-8">

          <title><?php echo $siteTitle; ?></title>
          <meta name="description" content="<?php echo $siteTitle; ?>">
          <meta name="rsmoke" content="LSA_MIS">

          <link rel="shortcut icon" href="ico/favicon.ico">

          <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
          <link rel="stylesheet" href="css/bootstrap-theme.min.css" type="text/css">
          <link rel="stylesheet" href="css/bootstrap-formhelpers.min.css" type="text/css">
          <link rel="stylesheet" type="text/css" href="css/myStyles.css">

          <!--[if lt IE 9]>
          <script src="http://html5shiv-printshiv.googlecode.com/svn/trunk/html5.js"></script>
          <![endif]-->
        </head>

        <body>
          <div id="notAdmin">
          <div class="row clearfix">
            <div class="col-xs-8 col-xs-offset-2">
              <div id="instructions" style="color:sienna;">
                <h1 class="text-center" >You are not authorized to this space!!!</h1>
                <h4 class="text-center" >University of Michigan - LSA Computer System Usage Policy</h4>
                <p>This is the University of Michigan information technology environment. You
                  MUST be authorized to use these resources. As an authorized user, by your use
                  of these resources, you have implicitly agreed to abide by the highest
                  standards of responsibility to your colleagues, -- the students, faculty,
                  staff, and external users who share this environment. You are required to
                  comply with ALL University policies, state, and federal laws concerning
                  appropriate use of information technology. Non-compliance is considered a
                  serious breach of community standards and may result in disciplinary and/or
                legal action.</p>
                <div class="text-center">
                  <a href="http://www.umich.edu"><img alt="University of Michigan" src="img/michigan.png" height:280px;width:280px; /> </a>
                </div>
                </div><!-- #instructions -->
              </div>
            </div>
          </div>
        </body>
      </html>
<?php
}
