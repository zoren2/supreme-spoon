<?php
namespace Zoren\SupremeSpoon;
/**
 * Communicates with the Reddit API.
 */
class RedditAPI
{
    const BASE_URL = 'reddit.com/r/';
    /**
     * @var bool
     */
    protected $use_https = false;
    /**
     * Whether or not to use HTTPS when making requests to the reddit API
     * 
     * @param bool $use_https
     */
    public function useHTTPS($use_https)
    {
        $this->use_https = $use_https;
    }
    /**
     * Fetches the most recent posts from the given subreddit
     * 
     * Usage:
     * ```
     * $api = new RedditAPI();
     * $posts = $api->fetchPosts('funny');
     * print_r($posts);
     *
     * @param string $subreddit
     * @return array
     */
    public function fetchPosts($subreddit)
    {
        $url = $this->buildURL($subreddit);
        $data = $this->fetch($url);
        $resp =  array();// contains array of posts 
        date_default_timezone_set('UTC');

        foreach($data['data']['children'] as $children) {
            $imageurl = $children['data']['url'];
            $thumburl = $children['data']['thumbnail'];
            $title = $children['data']['title'];
            $permalink = $children['data']['permalink']; // Link to thread
            $datecreated = date('Y-m-d H:i:s', $children['data']['created_utc']); // Takes timestamp from Reddit and turns it into YYYY/MM/DD HH:MM:SS

            $temparray = [ "subreddit"   => "${subreddit}", 
                           "imageurl"    => "${imageurl}", 
                           "thumburl"    => "${thumburl}", 
                           "title"       => "${title}", 
                           "permalink"   => "${permalink}", 
                           "datecreated" => "${datecreated}" ];

            if($this->urlContainsImage($imageurl)) {
                array_push($resp, $temparray); // $resp array accumulates filtered array
            }
        } // End foreach loop
        // return $this->fetch($url);
        return $resp;
    }

    /**
     * Returns 1 if URL includes JPG, PNG, or GIF.
     *
     * @return int
     */
    public function urlContainsImage($imageurl){
            return preg_match('/\bhttps?:\/\/\S+(?:png|jpg|gif)\b/', $imageurl);
    } // End of urlContainsImage function


    /**
     * @param string $subreddit
     * @return string
     */
    private function buildURL($subreddit)
    {
        $schema = 'http://';
        if ($this->use_https) {
            $schema = 'https://';
        }
        return $schema . self::BASE_URL . "${subreddit}.json";
    }
    /**
     * @param string $url
     * @return array
     */
    private function fetch($url)
    {
        $data = file_get_contents($url);
        return json_decode($data, true);
    }
}
