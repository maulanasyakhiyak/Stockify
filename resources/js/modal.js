$("[data-target-modal]").on("click", function () {
    var targetId = $(this).data("target-modal");
    $(`#${targetId}`).removeClass("hidden");
    setTimeout(() => {
        $(`#${targetId}`).removeClass(" bg-opacity-0");
        $(`#${targetId}`).addClass(" bg-opacity-50");
        $('[data-modal="body"]').addClass("active");
        // $("body").addClass("overflow-hidden");
    }, 50);
});

$("[data-hide-modal]").on("click", function () {
    var targetId = $(this).data("hide-modal");
    $('[data-modal="body"]').removeClass("active");
    $(`#${targetId}`).removeClass(" bg-opacity-50");
    $(`#${targetId}`).addClass(" bg-opacity-0");
    setTimeout(() => {
        $(`#${targetId}`).addClass("hidden");
        // $("body").removeClass("overflow-hidden");
    }, 500);
});