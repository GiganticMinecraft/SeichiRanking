$(document).ready(() => {
    const form = $("#player-search-form");
    const inputBox = $("#player-search-box");
    const suggestion_container = $("#player-search-suggestions");

    const suggestion_class = "player-search-suggestion";

    let search_result_cache = null;
    let is_mouse_in_form = false;

    function displaySearchResults(result) {
        suggestion_container.empty();
        result.players.forEach(player => {
            $("<li>")
                .addClass("list-group-item")
                .addClass(suggestion_class)
                .width(form.width())
                .text(player.name)
                .css({
                    cursor: "pointer"
                })
                .data("player-name", player.name)
                .appendTo(suggestion_container);
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
        if (!is_mouse_in_form) {
            suggestion_container.empty();
        }
    });

    form.mouseover(() => {
        is_mouse_in_form = true;
    }).mouseleave(() => {
        is_mouse_in_form = false;
    });

    suggestion_container.on("click", "li", (e) => {
        window.location.href = `/player/${$(e.target).data("player-name")}`
    })
});
