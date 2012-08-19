# Vagrant Passthrough

_Version 0.1_


## Description

Transparently runs commands through your Vagrant VM.


## The Problem

When developing with Vagrant, I am constantly switching between my local terminal
when making commits and my Vagrant terminal when running tests, DB commands,
and various other app-specific commands.


## Installation

Alias your commonly used commands to run through Vagrant:

	$ ./install php phpunit whatever
	Setting up /usr/local/bin/vphp...Done.
	Setting up /usr/local/bin/vphpunit...Done.
	Setting up /usr/local/bin/vwhatever...Done.

Go to somewhere in your app:

	$ cd ~/Sites/My/App/tests
	$ vwhatever

Vagrant will run `cd tests && whatever` (assuming `Vagrantfile` is in
your `App` folder) for you!


## Author

[Eric Clemmons](http://github.com/ericclemmons)

