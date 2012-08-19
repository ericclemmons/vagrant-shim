# Vagrant Shim

_Version 0.1_


## Description

Transparently runs commands through your Vagrant VM.


## The Problem

When developing with Vagrant, I am constantly switching between my local terminal
when making commits and my Vagrant terminal when running tests, DB commands,
and various other app-specific commands.


## Installation

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar install
    $ ./bin/vagrant-shim install


Now add the following to `~/.bash_profile` or `~/.profile`:

    eval "$(vagrant-shim enable)"


## Usage

    $ vagrant-shim shim php phpunit ...
	$ cd ~/Sites/My/App/tests
	$ phpunit
    Shimming...
    [shimmed output]

Vagrant will run `cd tests && whatever` (assuming `Vagrantfile` is in
your `App` folder) for you!


## Author

[Eric Clemmons](http://github.com/ericclemmons)

