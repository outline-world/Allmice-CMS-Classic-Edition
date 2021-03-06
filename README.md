# Allmice CMS Classic Edition

A free, fast, simple, lightweight, extendable modern Content Management System (CMS). It is programmed in PHP and uses MySQL or MariaDB database system. See the [project website](http://www.allmice.com/cms) for more details, documentation, support and help.

Newer stable versions will be released first on project website. Thus, if you wish to be more sure to get the most recent version, then it is better to download it from the project website.


## Short Overview

 * Allmice™ CMS Classic Edition
 * Version 1.8.1 (2021-01-03)
 * Copyright 2020 - 2021 by Adeenas OÜ, Copyright 2016 - 2020 by Any Outline LTD
 * http://www.allmice.com/cms
 * Allmice CMS is released under the "GNU GENERAL PUBLIC LICENSE".
 * See LICENSE.txt file in Allmice CMS root directory for more details about the license.


## Documentation, Help, Support

How to learn the system, how to get help and support?
Instructions, tutorials and various other useful information about Allmice CMS are available for free on the website [Allmice CMS](http://www.allmice.com/cms). If you can not get enough help from this website, then you may find there also instructions how to get help in other ways.


## Versioning

Releases are numbered using following format:
`<major>.<minor>.<patch>`


## History

Allmice CMS has been developed since 2016 by the companies Adeenas OÜ registered in Estonia and Any Outline LTD registered in England and Wales.


### Changelog

Changes in a version compared with its previous version are listed below.


#### Version 1.8.1, 2021-01-03

* A new PHP Mailer version was integrated to Message and User modules. PHP Mailer implementations were changed in those modules to support in system and on contact forms generated messages non-English alphabet letters (UTF-8 character encoding) and DKIM authentication method.
* A navigation menu style problem of Allmice Default Theme was fixed.
* Some other general initializing problems were fixed.
* Copyright holder company and system developing company was changed.


#### Version 1.7.1, 2019-11-19

* A bug in SystemManager module was fixed in uninstallModuleStructureEvent method. When using this method for uninstalling a module, then the data of such module will not be deleted any more from database.
* Page module can view after change pages in PDF format and also all themes are supporting PDF format.
* The file .htaccess was changed so, that URLs, which are containing www subdomains, are not supported by default. This change was done to avoid various problems, which may be caused by letting the websites be accessed through many URLs.
* The way how data is requested from database was changed in all modules. This change was done to make the performance of websites better.
* README.txt files were added to empty directories, which are explaining the purpose of such directories. The .gitignore files were deleted from these directories.


#### Version 1.6.5, 2019-09-09

* List styles were improved in all themes.
* User module was improved.


#### Version 1.6.4, 2019-08-31

* Supporting of remote hosts was fixed in many modules.
* A check was added in Page module not to process those global snippets, which have no tokens for them by viewing a page.
* The structure and names of README* and LICENSE* files were changed.


#### Version 1.6.3, 2019-08-08

* Some styles were changed in all themes.
* Installing process in App module was changed.
* Other minor changes.


#### Earlier versions

No changelog is available for versions before 1.6.3.
