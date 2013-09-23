Metafid-Base
============

This is a repo for the base classes that are utilized by the Metafid coder generator.

Metafid Description
============

The Metafid code generater is a private, not for sale, internal piece of software utilized to efficiently develop web bots. 

Metafid works in the following way:

1. Web actions are recorded via Fiddler2 (http://fiddler2.com/)

2. A Fiddler archive file is exported from the recorded web requests

2. This file is imported into Metafid which intelligently creates code to replicate the web actions preformed.

3. Changes are made to the code depending on need, Metafid provides an IDE environment to easy do things like HTML parsing, cookie clearing, user-agent changing, etc.

4. The project is exported for production use.



While the Metafid-Base is released under a GPLv3 license, the code generating part of Metafid is not open source, or available to the public in any way. 


Created by Matthew Bryant (mandatory)
