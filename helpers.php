<?php

function write_header() {
  echo <<<EOD
	<!DOCTYPE html>
	<html lang="en">

 	<head>
   	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="The Supreme Spoon">
    <meta name="author" content="">

    <title>The Supreme Spoon</title>

    <!-- Bootstrap -->
    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/main.css" rel="stylesheet">

  </head>

  <body>
EOD;
}

function write_banner() {
	echo <<<EOD
  <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top navbar-inverse">
      <div class="container">
        <a class="navbar-brand" href="#">Supreme Spoon</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="true" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="#">Sign Up</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Log In</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Temporary Banner --> 
    <header class="masthead text-center text-white">
      <div class="masthead-content">
        <div class="container">
          <h1 class="masthead-heading mb-0">What If I Told You</h1>
          <h2 class="masthead-subheading mb-0">This Is The Spoon</h2>
          <a href="#" class="btn btn-primary btn-xl rounded-pill mt-5">LOL</a>
        </div>
      </div>
      <div class="bg-circle-1 bg-circle"></div>
      <div class="bg-circle-2 bg-circle"></div>
      <div class="bg-circle-3 bg-circle"></div>
      <div class="bg-circle-4 bg-circle"></div>
    </header>
EOD;
}

// Creates content sections in the middle of the page
function write_sections($data) {

  // Navigates JSON data to access Reddit threads
	foreach($data['data']['children'] as $children) {
		$url = $children['data']['url'];
    $title = $children['data']['title'];
		$content = ''; // Accumulates content from Reddit Images

    if(url_contains_image($url)) {
      $content = <<<EOD
          <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 order-lg-2">
                  <div class="p-5">
                      <img class="img-fluid" src=${url} alt="">
            </div>
              </div>
                <div class="col-lg-6 order-lg-1">
                  <div class="p-5">
                      <h2 class="display-5">
                        ${title}
                      </h2>
                      <p>Placeholder Text</p>
                </div></div></div></div></section>';
EOD;
    } // End If
  echo $content;
	} // end foreach
}

// Creates footer for page
function write_footer() {
echo <<<EOT
  <!-- Footer -->
    <footer class="py-5 bg-black">
      <div class="container">
        <p class="m-0 text-center text-white small">Copyright &copy; Supreme Spoon 2018</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="node_modules/tether/dist/js/tether.js"></script>
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>

    </body>
  </html>
EOT;
}

// Returns true if URL contains an image, supports jpg, png, gif
function url_contains_image ($urlImage) { 
	return preg_match('/\bhttps?:\/\/\S+(?:png|jpg|gif)\b/', $urlImage);
} // End of isImage function

?>