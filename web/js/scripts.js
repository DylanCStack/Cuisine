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
})


// <form class="form-group tbl-edit" action="/edit-cuisine/{{cuisine.getId}}" method="post">
//     <input type="hidden" name="_method" value="patch">
//     <button type="submit" class="btn btn-xs btn-warning" name="button">Edit</button>
// </form>
