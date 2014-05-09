
// On load, colorize blocks and listen for new blocks
$(function () {
	colorizeMatrixBlocks();
	$('.matrix .btn').on('click', function () {
		colorizeMatrixBlocks();
	});
});

// Find all matrix blocks, add specified background color
function colorizeMatrixBlocks() {
	var blockType;
	$('.matrixblock').each(function () {
		blockType = $(this).find('input[type="hidden"][name*="][type]"]').val();
		$(this).css({'background-color':blockColors[blockType]});
	});
}
