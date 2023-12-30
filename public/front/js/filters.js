$(document).ready(function () {
    var queryStringObject = {};

    if ($(".filtertrue").length > 0) {
        RefreshFilters("no");
        popTriggerList();
    }

    $(".filterAjax").click(function () {
        var name = $(this).attr("name");
        var val = $(this).val();
        var $tt = $("#AppenderLinks");

        if (
            name === "price" &&
            $(document).find(
                '.inlineFilterLink[id*="RemoveFilter-"][data-name="price"]'
            ).length > 0
        ) {
            var targetToRemove = $(
                '.inlineFilterLink[id*="RemoveFilter-"][data-name="price"]'
            );
            targetToRemove.trigger("click");
        }

        $(".filterAjax").each(function () {
            var v = $(this).val();

            if (v === val && $(this).is(":checked")) {
                $tt.prepend(
                    '<a data-target="' +
                        val +
                        '" id=RemoveFilter-' +
                        val +
                        '" href="javascript:void(0);"></a>'
                );
            } else if (v === val && !$(this).is(":checked")) {
                $(
                    '.inlineFilterLink[data-target="' +
                        val +
                        '"][id*="RemoveFilter-"]'
                ).remove();
                RefreshFilters("yes");
            }
        });

        if (
            $("#AppenderLinks .inlineFilterLink").length > 0 &&
            $("#AppenderLinks .absClear").length
        ) {
            $tt.append(
                '<a href="javascript:void(0);" class="absClear">Clear All</a>'
            );
        }

        if ($("#AppenderLinks .inlineFilterLink").length <= 0) {
            $("#AppenderLinks").html(" ");
        }

        queryStringObject[name] = [];
        $.each(
            $("input[name='" + $(this).attr("name") + "']:checked"),
            function () {
                queryStringObject[name].push($(this).val());
            }
        );

        if (queryStringObject[name].length == 0) {
            delete queryStringObject[name];
        }

        RefreshFilters("yes");
    });

    $(document).on("change", ".getsort", function () {
        var value = $(this).val();
        var name = $(this).attr("name");
        queryStringObject[name] = [value];
        if (value == "") {
            delete queryStringObject[name];
        }
        RefreshFilters("yes");
    });

    $(document).on("click", "#pricesort", function () {
        var minprice = parseInt($("#from_range").val());
        var maxprice = parseInt($("#to_range").val());

        queryStringObject["price"] = [minprice + "-" + maxprice];

        if (minprice == "" && maxprice == "") {
            delete queryStringObject["price"];
        }

        $("#priceRange").val(minprice + "-" + maxprice);

        debounce(function () {
            $("input[name='price']").val($("#priceRange").val()).click();
        }, 100)();

        RefreshFilters("yes");
    });

    $(document).on("click", ".filterAjax", function () {
        // ... other code ...

        console.log("Selected color values:", queryStringObject["color"]);

        // ... other code ...
    });

    function RefreshFilters(type) {
        var queryStringObject = {};

        if (type != "clear-all") {
            $(".filterAjax").each(function () {
                var name = $(this).attr("name");

                queryStringObject[name] = [];

                $.each(
                    $("input[name='" + $(this).attr("name") + "']:checked"),
                    function () {
                        queryStringObject[name].push($(this).val());
                    }
                );

                if (queryStringObject[name].length == 0) {
                    delete queryStringObject[name];
                }
            });

            var value = $(".getsort option:selected").val();
            var name = $(".getsort").attr("name");

            queryStringObject[name] = [value];
            if (value == "") {
                delete queryStringObject[name];
            }

            if (type === "yes") {
                filterproducts(queryStringObject);
            }
        } else {
            filterproducts(queryStringObject);
        }
    }

    function filterproducts(queryStringObject) {
        $("body").css({ overflow: "hidden" });
        let searchParams = new URLSearchParams(window.location.search);

        if (searchParams.has("q")) {
            let parameterQuery = searchParams.get("q");
            var queryString = "?q=" + parameterQuery;
        } else {
            var queryString = "";
        }

        for (var key in queryStringObject) {
            if (queryString === "") {
                queryString += "?" + key + "=";
            } else {
                queryString += "&" + key + "=";
            }

            var queryValue = "";

            for (var i in queryStringObject[key]) {
                if (queryValue === "") {
                    queryValue += queryStringObject[key][i];
                } else {
                    queryValue += "~" + queryStringObject[key][i];
                }
            }
            queryString += queryValue;
        }

        if (history.pushState) {
            var newurl =
                window.location.protocol +
                "//" +
                window.location.host +
                window.location.pathname;

            if (queryString !== "") {
                if (newurl.indexOf("?") >= 0) {
                    newurl = newurl + "&" + queryString;
                } else {
                    newurl = newurl + queryString;
                }
            }

            $.ajax({
                url: newurl,
                type: "get",
                dataType: "json",
                success: function (resp) {
                    $("#appendProducts").html(resp.view);
                    document.body.style.overflow = "scroll";
                },
                error: function () {},
            });
        }
    }
});
