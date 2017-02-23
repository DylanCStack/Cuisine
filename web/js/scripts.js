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

    $(".cuisine-edit").click(function(){
        $(this).parent().prev().html('<form class="form-group tbl-edit" action="/edit-cuisine/' + $(this).val() + '" method="post">' +
            '<input type="hidden" name="_method" value="patch">' +
            '<input type=text name="cuisine" value=' + $(this).parent().prev().children("a").text() + '>' +
            '<button type="submit" class="btn btn-xs btn-warning" name="button">Edit</button>' +
        '</form>')
    })
    $(".restaurant-edit").click(function() {
        $(this).parent().parent().html(
        '<form class="form-group tbl-edit" action="/edit-restaurant/' + $(this).val() + '" method="post">' +
            '<input type="hidden" name="_method" value="patch">' +
            '<label for="name">Name</label>' +
            '<input class="form-control" type=text name="name" value=' + $(this).prev().text() + '>' +
            '<label for="address">Address</label>' +
            '<input class="form-control" type=text name="address" value=' + $(this).parent().next().children("ul").children("li").first().text() + '>' +
            '<label for="website">Website</label>' +
            '<input class="form-control" type=text name="website" value=' + $(this).parent().next().children("ul").children("li:nth-of-type(2)").text() + '>' +
            '<label for="phone">Phone</label>' +
            '<input class="form-control" type=text name="phone" value=' + $(this).parent().next().children("ul").children("li").last().text() + '>' +
            '<button type="submit" class="btn btn-xs btn-warning" name="button">Edit</button>' +
        '</form>')
    })
})
