
// On load, colorize blocks
$(function () {
	colorizeMatrixBlocks();
});

// Listen for new blocks
$(document).on('click', '.matrix .btn', function () {
	colorizeMatrixBlocks();
});

// Find all matrix blocks, add specified background color
function colorizeMatrixBlocks() {
	var blockType;
	$('.matrixblock').each(function () {
		blockType = $(this).find('input[type="hidden"][name*="][type]"]').val();
		$(this).css({'background-color':blockColors[blockType]});
	});
}
