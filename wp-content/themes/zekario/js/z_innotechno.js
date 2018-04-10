function init_techno() {
    $(".right-image").click(function () {
        $("#collapseRight").collapse("toggle"), console.log("right")
    }), $(".left-image").click(function () {
        $("#collapseLeft").collapse("toggle"), console.log("left")
    }), $("#collapseLeft").on("show.bs.collapse", function () {
        $("#collapseRight").collapse("hide")
    }), $("#collapseRight").on("show.bs.collapse", function () {
        $("#collapseLeft").collapse("hide")
    })
} 

$(function(){
    init_techno();
});
