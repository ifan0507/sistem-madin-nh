$(window).on("load", function () {
    const $preloader = $("#preloader");
    const $body = $("body");

    if ($preloader.length) {
        $preloader.addClass("loaded");
    }

    $body.removeClass("preload-active");
});

$(window).on("pageshow", function (event) {
    const $preloader = $("#preloader");
    const $body = $("body");

    if (
        event.originalEvent &&
        event.originalEvent.persisted &&
        $preloader.length &&
        !$preloader.hasClass("loaded")
    ) {
        $preloader.addClass("loaded");
        $body.removeClass("preload-active");
    }
});
