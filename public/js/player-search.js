$(document).ready(() => {
    function displaySearchResults(result) {
        // TODO
    }

    $("#player-search-form").submit(event => event.preventDefault());
    $("#player-search-box").on("input", event => {
        $.ajax({
            url : "/api/search/player",
            data : {
                q : event.target.value,
                lim : 10
            }
        }).then(displaySearchResults);
    });
});
