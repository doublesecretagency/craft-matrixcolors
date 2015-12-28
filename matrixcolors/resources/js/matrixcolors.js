// ==================================================================== //
// BEHAVIOR

// Find all matrix blocks, add specified background color
function colorizeMatrixBlocks() {
	var blockType;
	$('.matrixblock').each(function () {
		blockType = $(this).find('input[type="hidden"][name*="][type]"]').val();
		$(this).addClass('mc-solid-'+blockType);
		$(this).find('.titlebar').css({'background-color':'rgba(255, 255, 255, 0.5)'});
	});
}

// Find buttons related to Matrix, update background color
function colorizeMatrixButtons() {
	for (var i in colorList) {
		$('.matrix').find('.btn[data-type="'+colorList[i]+'"]').addClass('mc-gradient-'+colorList[i]);
	}
}

// Colorize all components
function colorizeAll() {
	colorizeMatrixBlocks();
	colorizeMatrixButtons();
}

// Refresh colorization over a timed period
function timedRefresh() {
	var counter = 1;
	var maxLoops = 10;
	var loop = setInterval(function () {
		colorizeAll();
		if (maxLoops <= counter++) {
			clearInterval(loop);
		}
	}, 200);
}

// ==================================================================== //
// TRIGGERS

// On load, colorize blocks
$(function () {
	colorizeAll();
});

// Listen for new blocks
$(document).on('click', '.matrix .btn, .menu ul li a', function () {
	colorizeMatrixBlocks();
});

// Listen for changed entry type
$(document).on('change', '#entryType', function () {
	timedRefresh();
});

// Listen for new Super Table rows
$(document).on('click', '.superTableContainer .btn', function () {
	timedRefresh();
});
