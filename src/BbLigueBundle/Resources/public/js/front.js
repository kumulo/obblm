var options = {
	bg: '#333',

	// leave target blank for global nanobar
	target: document.getElementById('myDivId'),

	// id for new nanobar
	id: 'mynano'
};

var nanobar = new Nanobar( options );

// move bar
nanobar.go( 30 ); // size bar 30%

// Finish progress bar
nanobar.go(100);
