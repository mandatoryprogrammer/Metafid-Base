Metafid-Base
============

This is a repo for the base classes that are utilized by the Metafid coder generator. 

The base classes are not allowed to be used commercially without express written consent from the creator.

Metafid Description
============

The Metafid code generater is a private, not for sale, internal piece of software utilized to efficiently develop web bots. 

Metafid works in the following way:

1. Web actions are recorded via Fiddler2 (http://fiddler2.com/)

2. A Fiddler archive file is exported from the recorded web requests

2. This file is imported into Metafid which intelligently creates code to replicate the web actions preformed. This is where the Metafid Base Classes are used. The base classes are used to make PHP's cURL functions object orientated and to allow scalable patches for any of Metafid's created programs (in the case of a bug in the base classes).

3. Changes are made to the code depending on need, Metafid provides an IDE environment to easy do things like HTML parsing, cookie clearing, user-agent changing, etc.

4. The project is exported for production use.

Screenshots
============

![Main Page](http://i.imgur.com/QXC5N4U.png)

![Project Page](http://i.imgur.com/YoMpxLX.png)

![Static POST Code](http://i.imgur.com/yzpX1NX.png)

![After Dynamic POST is Applied](http://i.imgur.com/68xz3cs.png)

![Example of IDE Code Adder](http://i.imgur.com/fMlktqT.png)

Disclaimer
============
While the Metafid-Base is released under a GPLv3 license, the code generating part of Metafid is not open source, or available to the public in any way. 


Created by Matthew Bryant (mandatory)
