$("body").on("click", ".action_nav_goback", function () {
    window.history.go(-1);
});

var $searchBar = $('#searchBar'),
    $searchText = $('#searchText'),
    $searchInput = $('#searchInput'),
    $searchClear = $('#searchClear'),
    $searchCancel = $('#searchCancel');

function hideSearchResult() {
    $searchInput.val('');
}

function cancelSearch() {
    hideSearchResult();
    $searchBar.removeClass('weui-search-bar_focusing');
    $searchText.show();
}

$searchText.on('click', function () {
    $searchBar.addClass('weui-search-bar_focusing');
    $searchInput.focus();
});

$searchInput.on('blur', function () {
    if (!this.value.length) cancelSearch();
});

$searchClear.on('click', function () {
    hideSearchResult();
    $searchInput.focus();
});

$searchCancel.on('click', function () {
    cancelSearch();
    $searchInput.blur();
});

