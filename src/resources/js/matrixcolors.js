// ==================================================================== //
// BEHAVIOR

function _colorizeBlocks(blockClass, blockTitlebarClass) {
    var blockType;
    $(blockClass).each(function () {
        blockType = $(this).find('input[type="hidden"][name*="][type]"]').val();
        // If block type is in the color list
        if (-1 < colorList.indexOf(blockType)) {
            $(this).addClass('mc-solid-'+blockType);
            $(this).find(blockTitlebarClass).css({'background-color':'rgba(255, 255, 255, 0.5)'});
        }
    });
}

// Find all matrix blocks, add specified background color
function colorizeMatrixBlocks() {
    _colorizeBlocks('.matrixblock', '.titlebar');
}

// Find buttons related to Matrix, update background color
function colorizeMatrixButtons() {
    for (var i in colorList) {
        $('.matrix').find('.btn[data-type="'+colorList[i]+'"]').addClass('mc-gradient-'+colorList[i]);
    }
}

// Find list items in menus related to Matrix, update background color
function colorizeMatrixMenus() {
    for (var i in colorList) {
        $('.menu').find('a[data-type="'+colorList[i]+'"]').addClass('mc-solid-'+colorList[i]);
    }
}

// Find all Neo blocks, add specified background color
function colorizeNeoBlocks() {
    _colorizeBlocks('.ni_block', '.ni_block_topbar');
}

// Find buttons related to Neo, update background color
function colorizeNeoButtons() {
    for (var i in colorList) {
        $('.neo-input').find('.btn[data-neo-bn-info="'+colorList[i]+'"]').addClass('mc-gradient-'+colorList[i]);
    }
}

// Find list items in menus related to Neo, update background color
function colorizeNeoMenus() {
    for (var i in colorList) {
        $('.menu').find('a[data-neo-bn-info="'+colorList[i]+'"]').addClass('mc-solid-'+colorList[i]);
    }
}

// Colorize all components
function colorizeAll() {
    colorizeMatrixBlocks();
    colorizeMatrixButtons();
    colorizeMatrixMenus();
    colorizeNeoBlocks();
    colorizeNeoButtons();
    colorizeNeoMenus();
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
    // Colorize existing menus and Neo buttons
    var observer = new MutationObserver(function() {
        colorizeMatrixMenus();
        colorizeNeoButtons();
        colorizeNeoMenus();
    });
    observer.observe(document.body, {childList: true});
});

// Listen for new Matrix blocks
$(document).on(
    'click',
    '.matrix .btn, .menu ul li a',
    function () {
        colorizeMatrixBlocks();
        colorizeMatrixMenus();
    }
);

// Listen for new Neo blocks
$(document).on(
    'click',
    '.neo-input .btn, a[data-neo-bn="button.addBlock"], .menu ul li a[data-action="add"]',
    function () {
        colorizeNeoBlocks();
        colorizeNeoButtons();
        colorizeNeoMenus();
    }
);

// Listen for changed entry type
$(document).on('change', '#entryType', function () {
    timedRefresh();
});

// Listen for new Super Table rows
$(document).on('click', '.superTableContainer .btn', function () {
    timedRefresh();
});
