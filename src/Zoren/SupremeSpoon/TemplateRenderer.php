<?php
namespace Zoren\SupremeSpoon;
/**
 * Class renders the landing page
 */ 
class TemplateRenderer
{
  /** 
   * @var RegExp 
   */ 
  protected $regexp; 
 
  /** 
   * Constructor  
   * 
   * @param RegExp $regexp 
   */ 
  public function __construct(RegExp $regexp) 
  { 
    $this->regexp = $regexp; 
  } 
  
	/**
	 * Function returns page as a string
	 *
	 * Usage
	 * ```
	 * $api = new RedditAPI();
	 * $data = $api->fetchPosts('subreddit');
	 * $template = new TemplateRenderer();
	 * $template->render($data);
	 * ```
	 *
	 * @param string
	 */
	public function render($data) {
		$page = '';
		$page .= $this->writeHeader();
		$page .= $this->writeBanner();
		$page .= $this->writeSections($data);
		$page .= $this->writeFooter();

		echo $page;
	}
  /**
   * Renders the error message page.
   *
   * Usage
   * ```
   * try {...} catch (PDOException $errormessage) { 
   * $template->renderError($errormessage);
   * }
   * ```
   */
  public function renderError($errormessage) {
    $page = '';
    $page .= $this->writeHeader();
    $page .= $this->writeBanner();
    $page .= $this->writeError($errormessage);
    $page .= $this->writeFooter();
  }

	/** 
	 * Writes HTTP Headers, Custom CSS
	 * 
	 * @return string
	 */
	protected function writeHeader() {
		$header = "
		<!DOCTYPE html>
 			<html lang='en'>
  			<head>
    		<meta charset='utf-8'>
    		<meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    		<meta name='description' content='The Supreme Spoon'>
    		<meta name='author' content=''>
    		<title>The Supreme Spoon</title>
    		<!-- Bootstrap core CSS -->
    		<link href='node_modules/bootstrap/dist/css/bootstrap.min.css' rel='stylesheet'>
    		<!-- Custom fonts for this template -->
    		<link href='https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900' rel='stylesheet'>
    		<link href='https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i' rel='stylesheet'>
    		<!-- Custom styles for this template -->
    		<link href='css/main.css' rel='stylesheet'>
    		<!-- Font Awesome -->
    		<link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'> </head>";

    	return $header;
	} // End writeHeader

	/** 
	 * Renders header at the top of the page
	 *
	 * @return string
	 */
	protected function writeBanner() {
		$banner = "
  		<div class='wrapper'>
        <!-- Sidebar Holder -->
        <nav id='sidebar'>
            <div id='dismiss'> <i class='fa fa-close'></i> </div>
            <div class='sidebar-header'>
                <h4>Supreme Spoon</h4> </div>
            <ul class='list-unstyled components'>
                <li class='active'> <a href='#homeSubmenu' data-toggle='collapse' aria-expanded='false'><i class='fa fa-home'></i>  Home</a>
                    <!-- Options inside list -->
                    <ul class='collapse list-unstyled' id='homeSubmenu'>
                        <li><a href='#'>Home 1</a></li>
                        <li><a href='#'>Home 2</a></li>
                        <li><a href='#'>Home 3</a></li>
                    </ul>
                </li>
                <li> <a href='#'>About</a> <a href='#pageSubmenu' data-toggle='collapse' aria-expanded='false'>Pages</a>
                    <ul class='collapse list-unstyled' id='pageSubmenu'>
                        <li><a href='#'>Page 1</a></li>
                        <li><a href='#'>Page 2</a></li>
                        <li><a href='#'>Page 3</a></li>
                    </ul>
                </li>
                <li> <a href='#'>Contact</a> </li>
            </ul>
            <ul class='list-unstyled CTAs'>
                <li><a href='' class='login'>Sign Up!</a></li>
                <li><a href='' class='signin'>Log In</a></li>
            </ul>
        </nav>
        <div id='content'>
            <!-- Navigation -->
            <nav class='navbar navbar-toggleable-md navbar-expand-lg navbar-dark navbar-custom fixed-top navbar-inverse'>
                <div class='container'> <a class='navbar-brand' href='#'>Supreme Spoon</a>
                    <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarResponsive' aria-controls='navbarResponsive' aria-expanded='true' aria-label='Toggle navigation'> <span class='navbar-toggler-icon'></span> </button>
                    <button type='button' id='sidebarCollapse' class='btn btn-danger navbar-btn'> <i class='fa fa-spoon'></i> <span>Pick Your Spoon</span> </button>
                    <div class='collapse navbar-collapse' id='navbarResponsive'>
                        <div class='container'>
                            <ul class='navbar-nav mr-auto'>
                                <li class='nav-item m-1'> <a class='nav-link' href='#'>Sign Up</a> </li>
                                <li class='nav-item m-1'> <a class='nav-link' href='#'>Log In</a> </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            <!-- Temporary Banner -->
            <header class='masthead text-center text-white'>
                <div class='masthead-content'>
                    <div class='container'>
                        <h1 class='masthead-heading mb-0'>What If I Told You</h1>
                        <h2 class='masthead-subheading mb-0'>This Is The Spoon</h2> <a href='#' class='btn btn-primary btn-xl rounded-pill mt-5'>LOL</a> </div>
                </div>
                <div class='bg-circle-1 bg-circle'></div>
                <div class='bg-circle-2 bg-circle'></div>
                <div class='bg-circle-3 bg-circle'></div>
                <div class='bg-circle-4 bg-circle'></div>
            </header>
            <!-- End header -->";

        return $banner;
	} // End writeBanner

	/**
	 * Creates content sections in the middle of the page
	 * ``
	 *
	 * @return string
	 */
	protected function writeSections($data) {
		$content = ''; // Accumulates content from Reddit Images
  		// Navigates JSON data to access Reddit threads
		foreach($data as $array) {
			$imageurl = $array['imageurl'];
   		 	$thumbnailurl = $array['thumburl'];
    		$title =  $array['title'];
    		$permalink = $array['permalink'];

	      	$content .= 
  	      	 	"<div class='container'>
    	        <div class='row align-items-center'>
                <div class='col-lg-6 order-lg-2'>
                  <div class='p-5'>
                      <img class='img-fluid' src=${imageurl} width='300px' height='300px' alt=''>
            	</div>
              	</div>
                <div class='col-lg-6 order-lg-1'>
                  <div class='p-5'>
                      <h2 class='display-5'>
                        <a href='https://reddit.com${permalink}'> ${title} </a>
                      </h2>
                      <p>Placeholder Text</p>
                </div></div></div></div></section>";
		} // End foreach

		return $content;
	} // End of writeSections function

	/**
	 * Creates footer of a page
	 * ``
	 *
	 * @return string
	 */
	protected function writeFooter() {
		$footer = "
            <footer class='py-5 bg-black'>
                <div class='container'>
                    <p class='m-0 text-center text-white small'>Copyright &copy; Supreme Spoon 2018</p>
                </div>
                <!-- container -->
            </footer>
        </div>
        <!-- End content -->
    	</div>
   		<!-- End Wrapper -->
    	<div class='overlay'></div>
    	<!-- Bootstrap core JavaScript -->
    	<script src='node_modules/tether/dist/js/tether.js'></script>
    	<script src='node_modules/jquery/dist/jquery.min.js'></script>
    	<script src='node_modules/bootstrap/dist/js/bootstrap.js'></script>
    	<script src='js/sidebar.js'></script>
    	<script src='js/customScrollbar.min.js'></script>
		</body>
		</html>";

		return $footer;
	} // End writeFooter

  /**
   * Write section if an error message if error is caught
   * 
   */
  protected function writeError($errormessage) {
    $content = "
      <div class='container'>
        <h2 class='display-5'>
          <p> Error! The site is temporarily unavailable: ${errormessage} </p>
        </h2>
      </div></div>";
  }
} // End class


