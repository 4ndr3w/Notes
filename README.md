# Notes
_Quick & Easy Notebook Renderer_

### About
This is an web application for rendering your markdown notes in HTML. I personally use this for viewing notes that I take in class.

### Install
1. Copy this directory to your web server
2. Setup your username and passwords in the $users array in authentication.php
3. Set your notebook path ($basePath) in index.php

### Usage
* Since there is no editor in the web interface, you will need to come up with something else. I personally use mod_dav to make the notebook directory accessable via WebDav and edit the files from the mounted drive.
* In the notebook directory, the script will look at acl.list to tell it which notes do not require authentication. Each line is the path to a note that you want to make public.
* The root of your notebook directory is only looked at for category directories. Subdirectories can contain markdown files and directories.

### Libraries
* PHP Markdown: http://michelf.ca/projects/php-markdown/
* Bootstrap: http://getbootstrap.com/2.3.2/