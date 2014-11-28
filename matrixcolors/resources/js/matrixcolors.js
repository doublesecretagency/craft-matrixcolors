
// On load, colorize blocks
$(function () {
	colorizeMatrixBlocks();
	colorizeMatrixButtons();
});

// Listen for new blocks
$(document).on('click', '.matrix .btn, .menu ul li a', function () {
	colorizeMatrixBlocks();
});

// Find all matrix blocks, add specified background color
function colorizeMatrixBlocks() {
	var blockType;
	$('.matrixblock').each(function () {
		blockType = $(this).find('input[type="hidden"][name*="][type]"]').val();
		$(this).css({'background-color':blockColors[blockType]});
		$(this).find('.titlebar').css({'background-color':'rgba(255, 255, 255, 0.5)'});
	});
}

// Find buttons related to Matrix, update background color
function colorizeMatrixButtons() {
	var blockType;
	for (blockType in blockColors) {
		if (blockColors.hasOwnProperty(blockType)) {
			$('.matrix').find('.buttons .btngroup .btn[data-type="'+blockType+'"]').css({'background-image':'linear-gradient(white,'+blockColors[blockType]+')'});
		}
	}
}
