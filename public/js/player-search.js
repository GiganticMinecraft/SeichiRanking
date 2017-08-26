$(document).ready(() => {
    const form = $("#player-search-form");
    const inputBox = $("#player-search-box");
    const suggestion_container = $("#player-search-suggestions");

    let search_result_cache = null;

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
            element.on("click", () => {
                window.location.href = "/player/" + player.name;
            });

            suggestion_container.append(element);
        });

        // if result not found
        if (inputBox.val().length > 0 && result.result_count === 0) {
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
        }).then(search_result => {
            displaySearchResults(search_result);
            search_result_cache = search_result;
        })
    });

    inputBox.focusin(() => {
        if (search_result_cache !== null) {
            displaySearchResults(search_result_cache);
        }
    });
    inputBox.focusout(() => {
//        suggestion_container.empty();
    });
});
