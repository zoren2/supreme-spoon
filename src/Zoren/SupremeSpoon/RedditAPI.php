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
     * ```
     * 
     * @param string $subreddit
     * @return array
     */
    public function fetchPosts($subreddit)
    {
        $url = $this->buildURL($subreddit);
        return $this->fetch($url);
    }
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
