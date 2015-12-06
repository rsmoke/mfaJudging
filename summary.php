<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContestJudging.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

  if (isset($_POST["summarize"])) {
      if ($_SESSION["isJudge"]){

  }else{

      }
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
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="index.php"><?php echo "$contestTitle";?><span style="color:#00FF80">-Judging</span></a>
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
          <?php $contestID = 11; ?>
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
                <a class="btn btn-xs btn-warning" href="http://lsa.umich.edu/hopwood/contests-prizes.html" target="_blank">Contest Rules</a>
          </div>

           <hr>

          <form class="validate-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
           <input type="hidden" name="evaluator" value=" <?php echo  $login_name; ?> ">
           <div class="bg-warning infosection">
           <strong>Ranking  Instructions:</strong> You are asked to select the top 10 entries from the list of applications you have evaluated. Using the 
           dropdown menu next to each entry, select a ranking value (1-10) for that entry. You will only be selecting a ranking for the top ten entries.

           </div>
          <table class="table table-hover">
            <thead>
              <th>Rank</th><th>Rating</th><th>Entry Title</th><th>Read</th><th>Authors Pen-name</th><th>Division</th><th>Rating Comment</th><th>Comment</th>
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
              JOIN tbl_applicant AS ta ON (teval.entry_id = ta.id)
              JOIN lk_category as lcat ON (te.`categoryID` = lcat.id)
              WHERE teval.evaluator = '$login_name' AND te.contestID = $contestID
              ORDER BY teval.rating DESC

_SQL;
$resultsInd = $db->query($getratings);
if (!$resultsInd) {
    echo "<tr><td>There are no entries available</td></tr>";
} else {
    while ($entry = $resultsInd->fetch_assoc()) {
echo              '<tr><td>
                <div class="form-group">
                  <select class="form-control" id="rank_' . $entry['entry_id'] . '" name="' . $entry['entry_id'] . '">
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
                <input type="text" class="form-control" id="summaryComment" name="summaryComment" />
              </td></tr>';
    }
}

?>

            </tbody>
          </table>

          </form>
          <p>Status: <span id="status">Unsubmitted</span></p>
<?php
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