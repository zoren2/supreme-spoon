<?php
namespace Zoren\SupremeSpoon;
use PDO;

class DBHelper
{

	/**
	 * @var PDO
	 */
	protected $conn = null;
	
	/**
	 * @var Config
	 */
	protected $config;

	public function __construct(Config $config) {
		$this->config = $config;
    }

	/**
	 * Fetches metadata from a particular Reddit subreddit and
	 * inserts into db.
	 *
	 * Usage
	 * ```
	 * $api = new RedditAPI();
	 * $config = new Config();
	 * $dbHelper = new DBHelper($config);
	 * $resp = $api->fetchPosts('subreddit');
	 * $dbHelper->updatePosts('subreddit', $resp); 
	 * ``` 
	 *
	 * @return bool
	 */
	public function updatePosts($subreddit, $resp) {
		$conn = $this->getConnection();
		$stmt = $this->conn->prepare($sqlquery);
		$sqlquery = "INSERT IGNORE INTO posts
                        (subreddit, imageurl, thumburl, title, permalink, datecreated)
                        VALUES (:subreddit, :imageurl, :thumburl, :title, :permalink, :datecreated)";

		foreach($resp as $key => $array) {
			if(!$this->fetchPermalink($array['permalink'])) {
                $stmt->execute([
                    'subreddit'     => $array['subreddit'],
                    'imageurl'      => $array['imageurl'],
                    'thumburl'      => $array['thumburl'],
                    'title'         => $array['title'],
                    'permalink'     => $array['permalink'],
                    'datecreated'   => $array['datecreated']
                ]);
			}
		} // End foreach
		return true;
	}

	/**
	 * Returns the time of the most recent post in DB.
	 *
	 * @return int
	 */
	public function fetchMostRecent($subreddit) {
		$conn = $this->getConnection(); 
		$sqlquery = "select * from posts where subreddit = :subreddit order by id desc limit 1";

		$stmt = $this->conn->prepare($sqlquery);
		$stmt->bindParam(':subreddit', $subreddit, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetch()['date_created'];
	} 

	/**
	 * Fetches specified number of posts from given subreddit and populates
	 * a reponse with an array of posts.
	 *
	 * @return array
	 */
	public function fetchPosts($subreddit, $numofposts) {
		$conn = $this->getConnection();
		$numofposts = (int)$numofposts; // Cast to int to prevent string content
		$sqlquery = "SELECT * FROM posts WHERE subreddit = :subreddit ORDER BY id DESC LIMIT ${numofposts}";
		$resp = []; // will contain the array of posts
		
		$stmt = $this->conn->prepare($sqlquery);
		$stmt->bindParam(':subreddit', $subreddit, PDO::PARAM_STR);
		$stmt->execute();

		while($row = $stmt->fetch()) {
			// Appends array to response
			$resp[] = $row;
		} // End while

		return $resp;
	}

	/**
	 * Returns true if a post is already in the DB. Returns false otherwise.
	 *
	 * @return bool
	 */
	private function fetchPermalink($permalink) {
		$conn = $this->getConnection();
		$sqlquery = "SELECT * FROM posts WHERE permalink = :permalink";

		$stmt = $this->conn->prepare($sqlquery);
		$stmt->bindParam(':permalink', $permalink, PDO::PARAM_STR);
		$stmt->execute();
		$row = $stmt->fetch();
		return $row['permalink'] == $permalink; // Found duplicate
	}

	/**
     * Retrieves an instance of PDO
     *
     * @return PDO
     */
    private function getConnection() {
        if (is_null($this->conn)) {
            $this->conn = new PDO("mysql:host=".$this->config->get('database')['host'].";dbname=".$this->config->get('database')['name'], $this->config->get('database')['user'], $this->config->get('database')['pass']);
            }
        return $this->conn;
    }
}