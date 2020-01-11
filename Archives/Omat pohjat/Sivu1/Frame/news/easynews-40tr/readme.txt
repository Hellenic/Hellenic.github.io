******************************************************************************
  EasyNews: Advanced Portal Management System
  ====================================================
  Copyright (c) 2004 by Angel Stoitsov and Mario Stoitsov
    http://software.stoitsov.com
******************************************************************************

Description
===========

EasyNews System is an extention of EasyDynamicPages product including
dynamical creation and managing of RSS news based on free GPL application
zFeeder (http://zvonnews.sourceforge.net/). It is a PHP script used to display
RSS content as an aggregator or feedreader and parses RSS (or RDF or backend)
files (xml files) and shows content formatted supporting all versions of RSS
(0.9, 0.9x, 1.0 and 2.0). As a free application, zFeederz script is completely
independent and can be used as stand alone application under the GPL licence.
For EasyNews it was modified to store its configuration and opml files in two
MySql tables. Therefore, Opml files and rss fields are stored in the MySQL
data base while the news are cashed.

EasyNews could be a Web Portal System, news system, personal or business site.
The goal is to have an automated web site not only to distribute news and
items but also easily to create and edit dynamic web pages (DynamicPages) with
internal or world news without knowledge of html, php or whether you need to
develop websites. Each user can submit news, comments, discuss articles and
more. Registered users and administrators can additionally create and modify
DynamicPages. Plugins included with the install are BookMarks manager,
E-Calendar, E-Publish, E-card and E-gallery, E-Classifier systems.

Features: design/content separation, web admin, user-customizable theme
management, SiteConfig manager, PageEdit manager, Search engine, Left/Right
blocks system, editor to add news and for content management, modular
DynamicPages structure, system self-install and more.

Written in PHP, works on windows, unix, linux and requires PHP, Apache and
MySQL.


Installation
============

Prerequisites:

Download and install MySQL.
Download and install Apache
Download and install PHP 4.1.0 or greater.

Then, do the following:

1. Unzip the zip file not in some subdirectory (e.g. easynews)
   under the root directory of your server.

2. Open the file  easynews/admin/serverdata.php and edit your
   server name, MySql user name, password and dbase table name

3. Point your browser to
http://your_domain.com/easydynamicpages/install/install.php
      and follow the instructions.

You are done.

Remember: Your admin name, password are demo, demo, respectively.
          Change them and delete folder easydynamicpages/install

Important: Make sure the folder easynews/staticpages/easynews/news/cache
           has chmode 777 (read-write) permition in order to allow cacheing
           the news.


Enjoy your EasyDynamicPages.

For more details visit:
http://myio.net/software
/********************************************************************************/
