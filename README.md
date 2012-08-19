# Vagrant Shim

_Version 0.1_


## Description

Transparently runs commands through your Vagrant VM.


## The Problem

When developing with Vagrant, I am constantly switching between my local terminal
when making commits and my Vagrant terminal when running tests, DB commands,
and various other app-specific commands.


## Installation

### 1. Install dependencies

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar install


### 2. Install `vagrant-shim`

_Defaults to `/usr/local/bin`_

    $ ./bin/vagrant-shim install


### 3. Add the following to `~/.bash_profile` or `~/.profile`

    eval "$(vagrant-shim enable)"


## Usage

### 1. Shim useful programs

    $ vagrant-shim shim php phpunit ...


### 2. Run locally, as normal

	$ cd ~/Sites/My/Normal/App/tests
	$ phpunit
    ...normal output...


### 3. Run remotely, via shim

    $ cd ~/Sites/My/Vagrant/App/tests
    $ phpunit
    Shimming...
    ...shimmed output...

The shim will automatically `cd` to the correct directory before
running your command inside Vagrant!


### 4. Run remotely, explicitly

    $ vagrant-shim run php -m


### 5. Bypass shim

    $ phpunit --no-shim ...
    Bypassing...
    ...normal output...


### 4. Get Help

    $ vagrant-shim
    ...lists all commands...

    $ vagrant-shim enable --help
    ...help text for "enable"


## Author

[Eric Clemmons](http://github.com/ericclemmons)


## License

Copyright (c) 2012 Eric Clemmons

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is furnished
to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
