$(document).ready(() => {
    const form = $("#player-search-form");
    const inputBox = $("#player-search-box");
    const suggestion_container = $("#player-search-suggestions");

    const suggestion_class = "player-search-suggestion";
    const suggestion_selected_class = "player-search-suggestion-selected";
    const playerNameDataKey = "player-data";

    let search_result_cache = null;
    let selected_suggestion = null;

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
                .data(playerNameDataKey, player.name)
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

    function deselectSuggestion(suggestion_element) {
        suggestion_element.removeClass(suggestion_selected_class);
        selected_suggestion = null;
    }

    function selectSuggestion(suggestion_element) {
        if (selected_suggestion !== null) {
            deselectSuggestion(selected_suggestion);
        }

        suggestion_element.addClass(suggestion_selected_class);
        selected_suggestion = suggestion_element;

        inputBox.val(selected_suggestion.data(playerNameDataKey));
    }

    function moveSuggestion(is_movement_down) {
        if (selected_suggestion === null) {
            const extractor = is_movement_down ? "first" : "last";
            const suggestion_element = suggestion_container.find(`.${suggestion_class}`)[extractor]();
            if (suggestion_element.length !== 0) {
                selectSuggestion(suggestion_element);
            }
            return;
        }

        const next_selection = selected_suggestion[is_movement_down ? "next" : "prev"]();
        if (next_selection.length !== 0) {
            selectSuggestion(next_selection);
        } else {
            deselectSuggestion(selected_suggestion);
        }
    }

    function moveSuggestionSelectionDown() {
        moveSuggestion(true);
    }

    function moveSuggestionSelectionUp() {
        moveSuggestion(false);
    }

    function redirect(suggestion_element) {
        const playerName = suggestion_element.data(playerNameDataKey);
        window.location.href = `/player/${playerName}`;
    }

    inputBox.on("input", event => {
        $.ajax({
            url : "/api/search/player",
            data : {
                q : event.target.value,
                lim : 5
            }
        }).then(search_result => {
            selected_suggestion = null;
            displaySearchResults(search_result);
            search_result_cache = search_result;
        })
    });

    inputBox.on("focus", () => {
        if (search_result_cache !== null) {
            displaySearchResults(search_result_cache);
        }
    });

    inputBox.on("focusout", () => {
        if (selected_suggestion === null) {
            suggestion_container.empty();
        }
    });

    form.on("submit", event => {
        event.preventDefault();

        if (selected_suggestion !== null) {
            redirect(selected_suggestion);
        }
    });

    form.on("keydown", event => {
        if (event.keyCode === 38) {
            event.preventDefault();
            moveSuggestionSelectionUp();
        } else if (event.keyCode === 40) {
            moveSuggestionSelectionDown();
        }
    });

    suggestion_container.on("mouseover", `.${suggestion_class}`, event => selectSuggestion($(event.target)));

    suggestion_container.on("mouseleave", `.${suggestion_class}`, event => deselectSuggestion($(event.target)));

    suggestion_container.on("click", `.${suggestion_class}`, event => redirect($(event.target)));
});
