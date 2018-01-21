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
     */
    public function fetchPosts($subreddit)
    {
    
    }
}