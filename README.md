mintypublish - Decidedly minty content management
=================================================

Important
-------------------------------------------------
Please be aware that mintypublish is **in pre-alpha** and as such is not feature-complete, is
buggy and is *definitely* not recommended for usage in a production environment

Getting started
-------------------------------------------------
* Make sure where you're installing mintypublish into has at least PHP 5.2.0 and MySQL
  (unsure on version)
* Copy everything in the `trunk` folder to where you want mintypublish to be installed
* Go into `trunk/mintypublish/config.php` and edit the MySQL settings as appropriate
* Use a script such as phpMyAdmin to run the `dump.sql` file
* Go to where you've installed mintypublish, and bask in the glory!
* To get the administration tools, say you have mintypublish in `http://yoursite.com/mp/`,
  you'd go to `http://yoursite.com/mp/mintypublish/`

Roadmap
-------------------------------------------------
mintypublish as it is, is a personal project created and developed by a single person for
both hobbyist and school purposes.

The goal of mintypublish is to be a sleek, yet functional CMS.

Currently, it has basic page and file management functionalities.

### What is a 1.0?
A 1.0 should be stable, obviously. Placeholders and comments currently exist scattered around
the place. Placeholders should be heavily prioritised for completion into proper features.

### Letting in new features from time to time
The problem with basic functionality is that basic is *not enough* much of the time. As a
hobbyist/student project, much work still has to go into adding more features. But constantly
focusing on adding new features with no limit is obviously bad, which is why professional
development cycles have a feature lock. Self-imposition for a hobbyist project isn't
particularly easy.

### File management

#### What should probably be done
* Inserting videos is **extremely** unflexible, as it imposes a 800x600 limit. TinyMCE has
  a part to play in this as well due to its handling of things like Flash
* The "mediasponge" dialog is cluttered and keeps the old "giant list" methodology back from
  the "Sponge CMS" days, even after a cleanup

### Page management
#### What could be done
* Custom CSS/JS, but what about caching it?