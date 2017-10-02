<html>
<head>
  <meta charset="utf-8">

      <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
  <style type="text/css">

  </style>
  <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
<title>WELCOME TO RSS CLEVER</title>
</head>
<?php
    require_once 'library.php';
    if(chkLogin()){

        echo "Logged in!";
        $name = $_SESSION["uname"];
        echo "WELCOME TO RSS CLEVER $name";


    }
    else{
        header("Location: login.php");
    }

    if(isset($_POST['logout'])){

        $var = removeall();
        if($var){
            header("Location:login.php");
        }
        else{
            echo "Error!";
        }

    }
    $feeds = array(
        "https://xkcd.com/rss.xml"
    );
    //array_push($feeds, "apple", "raspberry");
    //Read each feed's items
    $entries = array();
    foreach($feeds as $feed) {
        $xml = simplexml_load_file($feed);
        $entries = array_merge($entries, $xml->xpath("//item"));
    }

    //Sort feed entries by pubDate
    usort($entries, function ($feed1, $feed2) {
        return strtotime($feed2->pubDate) - strtotime($feed1->pubDate);
    });

?>
    <body>

        <div class='container'>
          <h1>Main Content Section</h1>
          <div class='navbar navbar-inverse'>
            <div class='navbar-inner nav-collapse' style="height: auto;">
              <ul class="nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Page One</a></li>
                <li><a href="#">Page Two</a></li>
                <li></li>
                <li></li>
                <li>
                  <form method="post" action="">
                      <input type="submit" name="logout" value="Logout!">
                  </form>
               </li>
              </ul>
            </div>
          </div>
            <table>
          <div id='content' class='row-fluid'>

              <tr>
                <td valign='top' width=30%>
          <div class='span2 sidebar'>
              <h3>Left Sidebar</h3>
              <ul class="nav nav-tabs nav-stacked">
                <li><a href='#'>Another Link 1</a></li>
                <li><a href='#'>Another Link 2</a></li>
                <li><a href='#'>Another Link 3</a></li>
              </ul>
            </div>
          </td>
            <td width=70%>
          <div>  <ul><?php
            foreach($entries as $entry){
                ?>
                <li><a href="<?= $entry->link ?>"><?= $entry->title ?></a> (<?= parse_url($entry->link)['host'] ?>)
                <p><?= strftime('%m/%d/%Y %I:%M %p', strtotime($entry->pubDate)) ?></p>
                <p><?= $entry->description ?></p></li>
                <?php
            }
            ?>
            </ul>
          </div>
        </td>

        </tr>
        </div>
      </table>

    </body>
</html>
