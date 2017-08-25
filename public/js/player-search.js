$(document).ready(() => {
    const form = $("#player-search-form");
    const inputBox = $("#player-search-box");
    const suggestion_container = $("#player-search-suggestions");

    function displaySearchResults(result) {
        suggestion_container.empty();
        result.players.forEach(player => {
            const element = $("<li>")
                .addClass("list-group-item")
                .addClass("player-search-suggestion")
                .width(form.width())
                .text(player.name)
                .css({
                    cursor: "pointer"
                });
            suggestion_container
                .append(element)
                .on("click", () => {
                    window.location.href = "/player/" + player.name
                });
        });

        // if result not found
        if (inputBox.val().length > 0 && result.result_count == 0) {
            $("<li>")
                .addClass("list-group-item")
                .width(form.width())
                .text("見つかりませんでした。")
                .css("color", "#aaa")
                .appendTo(suggestion_container);
        }
    }

    form.submit(event => event.preventDefault());
    inputBox.on("input", event => {
        $.ajax({
            url : "/api/search/player",
            data : {
                q : event.target.value,
                lim : 5
            }
        }).then(search_result => displaySearchResults(search_result));
    });
});
