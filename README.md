supreme-spoon
========
Humor served utilizing Reddit API.

## Installing Vendors

In order to install Bootstrap 4 and retrieve proper vendors, go into command line 

```
npm install bootstrap@4.0.0-alpha.6
```

Once packages are installed, compile the CSS using the command at the base of the project (inside supreme-spoon).

```
npm run build-css
```

To add the database locally, add the posts table using this command.

```
CREATE TABLE `posts` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`subreddit` varchar(60) NOT NULL,
`imageurl` varchar(255) NOT NULL,
`thumburl` varchar(255) NOT NULL,
`title` varchar(255) NOT NULL,
`permalink` varchar(255) NOT NULL,
`datecreated` datetime NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `permalink` (`permalink`),
KEY `subreddit` (`subreddit`)
) ENGINE=InnoDB
```

To enable logging, you may need to set permissions to the log file to 777. In the terminal inside /logs -

```
chmod 777 supremespoon.log
```
