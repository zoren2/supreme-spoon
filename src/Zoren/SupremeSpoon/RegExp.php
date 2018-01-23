<?php
namespace Zoren\SupremeSpoon;
/**
 * Helper classes to help parse URL's
 */
class RegExp {

	/**
	 * Returns 1 if URL includes JPG, PNG, or GIF.
	 *
	 * @return int
	 */
	public function urlContainsImage($imageurl){
			return preg_match('/\bhttps?:\/\/\S+(?:png|jpg|gif)\b/', $imageurl);
	} // End of urlContainsImage function
	
} // End class

?>
