#!/usr/bin/perl
#
# convert html from fswiki text
#
# @author Jun Futagawa

use FindBin qw($Bin);
use lib "$Bin/fswiki/lib";
use strict;
use Wiki;
use Util;
use Jcode;
use HTML::Template;

my $input;
if (@ARGV == 1) {
	$input = $ARGV[0];
	chomp($input);
} else {
	while ($_ = <STDIN>) {
		chomp($_);
		$input .= $_ . "\n";
	}
}

# change directory
chdir "$Bin/fswiki" or die $!;

my $wiki = Wiki->new('setup.dat');

# load plugins
my @plugins = split(/\n/,&Util::load_config_text($wiki,$wiki->config('plugin_file')));
my $plugin_error = '';
foreach(sort(@plugins)){
	$plugin_error .= $wiki->install_plugin($_);
}
# initialize plugins
$wiki->do_hook("initialize");

# process
print $wiki->process_wiki($input);
