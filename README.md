#Wheel of Fortune
######Initial Release: 18 July, 2006

####About

This script came about as a result of an evening with friends playing the Wheel of Fortune board game. We had run out of the question sheets that came with the game and I thought that implementing part of the game as a script would greatly simplify and streamline the game play and offer a more diverse set of answers.

The script only implements part of the game, so you will still require the wheel, the free spin tokens and money from the board game in order to play. The script takes care of the answer, the display and keeps track of the letters for you. In a pinch, you could build your own spinner and tokens, and use play money from another game.

####Installation instructions

This program should run on any PHP-enabled webserver. It has been tested on PHP 5.1.4 but it should also run on recent versions of PHP.

Session support is required. If it isn't enabled, the game won't work.

Just place the script and the CSV file somewhere on your web server. You can use the included CSV file, or create your own. There are several sources of past game answers online, or you can think up your own.

The CSV format is very straightforward; there are only two columns. The first is the type (ie, phrase, person, title), and then the answer. The answer should be in upper-case. Of course, the CSV file must be readable by the script (ie, your web server/PHP process must be able to read the file)

If you create a CSV answer file that you would like distributed, please contact me and I will include it with future releases.

You may contact the author at: http://marty.anstey.ca/etc/
