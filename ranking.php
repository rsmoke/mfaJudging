<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContestJudging.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

  if (isset($_POST["summarize"])) {
      if ($_SESSION["isJudge"]){
    //gather all ten entries and build an insert query
    //scrub inputs

    $responses = $_POST;
    $resultset = "";
    foreach ($responses as $key => $value ){

      if ($key != "summarize"){
        if (substr($key,0,4) == "entr"){
          $resultset .= "('" . $login_name . "'," . $db->real_escape_string(htmlspecialchars($value)) . ",";
        } elseif (substr($key,0,4) == "cont"){
          $resultset .= $db->real_escape_string(htmlspecialchars($value)) . ",";
        } elseif (substr($key,0,4) == "rank"){
          if ($value > 0){
            $resultset .= $db->real_escape_string(htmlspecialchars($value)) . ",";
          } else {
            $resultset .= "0,";
          }
        } elseif (substr($key,0,4) == "summ"){
          $resultset .= "'" . $db->real_escape_string(htmlspecialchars($value)) . "'),";
        }
      }
    }
    $insertValues = trim($resultset,",");

    $sqlInsert = <<<SQL
        INSERT INTO `quilleng_ContestManager`.`tbl_ranking`
        (`rankedby`,
        `entryid`,
        `contestID`,
        `rank`,
        `comment`)
        VALUES
        $insertValues
SQL;
echo $sqlInsert;
        if (!$result = $db->query($sqlInsert)) {
              db_fatal_error($db->error, $login_name . " -data insert issue- " . $sqlInsert);
              exit($user_err_message);
        } else {
            $db->close();
            unset($_POST['summarize']);
            safeRedirect('rating.php');
            exit();
        }
      }else{
        non_db_error("User: " . $login_name . " -ranking submission error- isJudge set to: " . $_SESSION["isJudge"] );
      }
  }

  if (isset($_GET["ctst"])){
      $contestID = htmlspecialchars(($_GET["ctst"]));
  } else {
    $contestID = "Variable ctst Not sent!";
    non_db_error("User: " . $login_name . " -ranking page access error- variable ctst= " . $contestID);
    exit($user_err_message);
  }

  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="utf-8">

    <title>LSA-<?php echo "$contestTitle";?> Writing Contests</title>

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
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="index.php"><?php echo "$contestTitle";?></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                   <a href="#" class="dropdown-toggle" data-toggle="dropdown">Signed in as <?php echo $login_name;?><strong class="caret"></strong></a>
                  <ul class="dropdown-menu">
                    <li>
                      <a href="index.php"><?php echo "$contestTitle";?> main</a>
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

      <?php if ($_SESSION["isJudge"]) {
          ?>
    <div class="container"><!-- container of all things -->
    <div class="row clearfix">
      <div class="col-md-12">
          <div>
              <h4>Summary of Evaluations for
<?php
$contestSelect = <<<SQL
  SELECT name
  FROM tbl_contest
  JOIN lk_contests ON (lk_contests.id = tbl_contest.contestsID)
  WHERE tbl_contest.id = $contestID
SQL;

    if (!$result = $db->query($contestSelect)) {
        db_fatal_error($db->error, "data select issue", $sqlSelect);
        exit($user_err_message);
    }
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo $row['name'];
      }
    }
?>

</h4>
<?php
$checkforranking = <<< SQL
  SELECT DISTINCT contestID
  FROM tbl_ranking
  WHERE rankedby = '$login_name' AND contestID = $contestID
SQL;
  if (!$resultsSel = $db->query($checkforranking)) {
          db_fatal_error($db->error, "data select issue", $checkforranking);
          exit($user_err_message);
      }
      if ($resultsSel->num_rows > 0) {
?>
    <div class="bg-info">
      <h5>You are done with the rankings for this contest.</h5> <p>Below is a summary of all the ratings and rankings you submitted. The greenbox contains
      the entries that ranked as being in the top ten.</p>
    </div>
        <table class="table table-hover bg-success">
          <thead>
            <th>Rank</th><th>Rating</th><th>Entry Title</th><th>Read</th><th>Authors<br>Pen-name</th><th>Division</th><th>Rating Comment</th><th>Ranking Comment</th>
          </thead>
          <tbody>
          <?php
      $getRankings = <<<SQL
              SELECT teval.id AS evalid, teval.evaluator, teval.rating, tr.rank, teval.comment, tr.comment AS rankcomment, teval.entry_id,
               te.title, te.documentname, te.contestID, lcs.name AS contestname, lcat.name AS division, ta.penName
              FROM tbl_evaluations AS teval
              JOIN tbl_entry AS te ON (teval.`entry_id` = te.`id`)
              JOIN `tbl_contest` AS tc ON (te.contestID = tc.id)
              JOIN lk_contests AS lcs ON (tc.`contestsID` = lcs.id)
              JOIN tbl_applicant AS ta ON (te.`applicantID` = ta.id)
              JOIN lk_category as lcat ON (te.`categoryID` = lcat.id)
              JOIN tbl_ranking AS tr ON (teval.`entry_id` = tr.entryid AND tr.`rankedby` = '$login_name')
              WHERE teval.evaluator = '$login_name' AND te.contestID = $contestID
              ORDER BY tr.rank ASC

SQL;
if (!$resultsSel = $db->query($getRankings)) {
        db_fatal_error($db->error, "data select issue", $getRankings);
        exit($user_err_message);
    }
    if ($resultsSel->num_rows > 0) {
    while ($entry = $resultsSel->fetch_assoc()) {
      if ($entry['rank'] > 0){
      echo  '<tr><td>
                ' . $entry['rank'] . '
              </td><td>
                <img src="img/' . $entry['rating'] . 'star.png">
              </td><td>
                ' . $entry['title'] . '
              </td><td>
                <a href="contestfiles/' . $entry['documentname'] . '" target="_blank"><span class="fa fa-book fa-lg"></span></a>
              </td><td>
                ' . $entry['penName'] . '
              </td><td>
                ' . $entry['division'] . '
              </td><td>
                ' . $entry['comment'] . '
              </td><td>
                ' . $entry['rankcomment'] . '
              </td><td>
                <small>' . $entry['entry_id'] . '</small>
              </td></tr>';
      }
    }
    echo '</tbody></table>';
  }

if (!$resultsSel = $db->query($getRankings)) {
        db_fatal_error($db->error, "data select issue", $getRankings);
        exit($user_err_message);
    }
    if ($resultsSel->num_rows > 0) {
      echo '<table class="table table-hover">
            <thead>
            <th>Rank</th><th>Rating</th><th>Entry Title</th><th>Read</th><th>Authors<br>Pen-name</th><th>Division</th><th>Rating Comment</th><th>Ranking Comment</th>
          </thead>
          <tbody>';
    while ($entry = $resultsSel->fetch_assoc()) {
      if ($entry['rank'] == 0){
      echo  '<tr><td>
                ' . $entry['rank'] . '
              </td><td>
                <img src="img/' . $entry['rating'] . 'star.png">
              </td><td>
                ' . $entry['title'] . '
              </td><td>
                <a href="contestfiles/' . $entry['documentname'] . '" target="_blank"><span class="fa fa-book fa-lg"></span></a>
              </td><td>
                ' . $entry['penName'] . '
              </td><td>
                ' . $entry['division'] . '
              </td><td>
                ' . $entry['comment'] . '
              </td><td>
                ' . $entry['rankcomment'] . '
              </td><td>
                <small>' . $entry['entry_id'] . '</small>
              </td></tr>';
      }
    }
          echo '</tbody></table>';
  }
      } else {
?>
      <div class="bg-warning infosection">
           <p><strong>Ranking  Instructions:</strong> Please select the top entries from the list of applications you have rated. Using the
           dropdown menu next to each entry, select a ranking value (1 <em>being the best</em> down to 10) for that entry. You will only be selecting
           a ranking for the top ten entries.</p>
           <p><em>NOTE: Each time you select a number it will no longer be available from the dropdown list. If you want to use a rank value that is already on another entry
           you will need to remove the value from the other entry first. </em></p>
          <p class="text-danger"><em>NOTE: Once you press submit all your rankings will be recorded and the the ranking stage is final.</em></p>

        <a class="btn btn-xs btn-warning fa fa-info-circle" href="http://lsa.umich.edu/hopwood/contests-prizes.html" target="_blank"> Contest Rules</a>

      </div>
    </div>

           <hr>

          <form class="validate-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

          <table class="table table-hover">
            <thead>
              <th>Rank</th><th>Rating</th><th>Entry Title</th><th>Read</th><th>Authors<br>Pen-name</th><th>Division</th><th>Rating Comment</th><th>Comment</th>
            </thead>
            <tbody>
            <?php
            $getratings = <<<_SQL
              SELECT teval.id AS evalid, teval.evaluator, teval.rating, teval.comment, teval.entry_id,
               te.title, te.documentname, te.contestID, lcs.name AS contestname, lcat.name AS division, ta.penName
              FROM tbl_evaluations AS teval
              JOIN tbl_entry AS te ON (teval.`entry_id` = te.`id`)
              JOIN `tbl_contest` AS tc ON (te.contestID = tc.id)
              JOIN lk_contests AS lcs ON (tc.`contestsID` = lcs.id)
              JOIN tbl_applicant AS ta ON (te.`applicantID` = ta.id)
              JOIN lk_category as lcat ON (te.`categoryID` = lcat.id)
              WHERE teval.evaluator = '$login_name' AND te.contestID = $contestID
              ORDER BY teval.rating DESC

_SQL;
//$resultsInd = $db->query($getratings);
//if (!$resultsInd) {
if (!$resultsInd = $db->query($getratings)) {
        db_fatal_error($db->error, "data select issue", $getratings);
        exit($user_err_message);
    }
    if ($resultsInd->num_rows <= 0) {
    echo "<tr><td>There are no rated entries available</td></tr>";
} else {
    while ($entry = $resultsInd->fetch_assoc()) {
echo         '<input type="hidden" name="entryID_' . $entry['entry_id'] . '" value="' . $entry['entry_id'] . '">
              <input type="hidden" name="contestID_' . $entry['entry_id'] . '" value="' . $contestID . '">
              <tr><td>
                <div class="form-group">
                  <select class="form-control" id="rank_' . $entry['entry_id'] . '" name="rank_' . $entry['entry_id'] . '">
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
                <img src="img/' . $entry['rating'] . 'star.png">
              </td><td>
                ' . $entry['title'] . '
              </td><td>
                <a href="contestfiles/' . $entry['documentname'] . '" target="_blank"><span class="fa fa-book fa-lg"></span></a>
              </td><td>
                ' . $entry['penName'] . '
              </td><td>
                ' . $entry['division'] . '
              </td><td>
                ' . $entry['comment'] . '
              </td><td>
                <textarea class="form-control" id="summaryComment" name="summaryComment_' .$entry['entry_id'] . '" ></textarea>
              </td><td>
                <small>' . $entry['entry_id'] . '</small>
              </td></tr>';
    }
}

?>

            </tbody>
          </table>
          <input type="submit" class="btn btn-success" name="summarize" value="Submit"/>
          </form>
          <p>Status: <span id="status">Unsubmitted</span></p>
<?php
    }
      } else {
?>

  <!-- if there is not a record for $login_name display the basic information form. Upon submitting this data display the contest available section -->
  <div id="notAdmin">
    <div class="row clearfix">
      <div class="col-md-12">

          <div id="instructions" style="color:sienna;">
            <h1 class="text-center" >You are not authorized to this space!!!</h1>
            <h4>University of Michigan - LSA Computer System Usage Policy</h4>
            <p>This is the University of Michigan information technology environment. You
            MUST be authorized to use these resources. As an authorized user, by your use
            of these resources, you have implicitly agreed to abide by the highest
            standards of responsibility to your colleagues, -- the students, faculty,
            staff, and external users who share this environment. You are required to
            comply with ALL University policies, state, and federal laws concerning
            appropriate use of information technology. Non-compliance is considered a
            serious breach of community standards and may result in disciplinary and/or
            legal action.</p>
            <div style="postion:fixed;margin:10px 0px 0px 250px;height:280px;width:280px;"><a href="http://www.umich.edu"><img alt="University of Michigan" src="img/michigan.png" /> </a></div>
          </div><!-- #instructions -->
      </div>
    </div>
  </div>

    <?php
}
    include("footer.php");?>
    <!-- //additional script specific to this page -->
      <script src="js/jdgMyScript.js"></script>
      <script src="js/validator.js"></script>
</div><!-- End Container of all things -->
</body>
</html>

<?php
  $db->close();