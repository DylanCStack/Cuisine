$(document).ready(function() {
    $(".edit-button").click(function() {
        $("#score_input").val($(this).prev().text());
        $("#review_text").val($(this).parent().next().children("span").text());

        //

        $("#edit-form").attr("action", "/edit-review/" + $(this).val());
    })

    $(".delete-button").click(function() {
        $("#delete-form").attr("action", "/delete-review/" + $(this).val());
    })
})
