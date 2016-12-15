$(window).load(function(){
        // The PHP endpoint queries the DB for the most
        // recent blog entry.
        $.getJSON('blog.php/blog/latest', function (data) {
                var title = data["title"];
                var body = data["body"];
                var author = data["author"];
                var createdDate = data["createdDate"];

                // Assign JSON values to DOM objects
                $("#blog-title").text(title);
                $("#blog-body").text(body);
                $("#blog-author").text(author);
                $("#blog-created-date").append(createdDate);
        });


        // These two functions are jQuery event responses that run
        // when the elements across the top menu are clicked.
        $("#blog-create").click(function() {
                $("#blog-title").replaceWith(
                    "<input id='blog-title' type='text' class='form-control'>"
                );
                $("#blog-author").replaceWith(
                    "<input id='blog-author' type='text' class='form-control'>"
                );
                $("#blog-body").replaceWith(
                    "<textarea id='blog-body' class='form-control' rows='7'></textarea><br><button id='send-post' type='submit' class='btn btn-primary'>Submit</button>"
                );
                    $("#send-post").click(function() {
                        var title = $("#blog-title").val();
                        var author = $("#blog-author").val();
                        var body = $("#blog-body").val();

                        pdata = JSON.stringify({'title': title,
                            'author': author, 'body': body});

                        // The PHP endpoint will handle the created date
                        $.post("blog.php/blog/create", pdata)
                            .done(function( data ) {
                                var cdate = $.parseJSON(data);
                                $("#blog-title").replaceWith("<h1 id='blog-title'>" + title + "</h1>");
                                $("#blog-author").replaceWith("<a id='blog-author' href='#''>" + author + "</a>");
                                $("#blog-body").replaceWith("<p id='blog-body' class='lead' style='word-wrap: break-word;'>" + body + "</p>");
                                $("#blog-created-date").replaceWith(
                                    "<p id='blog-created-date'><span class='glyphicon glyphicon-time'></span> " + cdate["date"] + "</p>"
                                );
                                $("#send-post").remove();
                            });
                    });
        });

        $("#blog-update").click(function() {
            // This will work similar to create, except we
            // have to fetch the data from the DB via PHP
            // first, and then put it in the HTML we replace.
            // This means we have to save the .val() data
            // temporarily so we can put it back after a
            // successful submit to the database.
        });

        $("#search-btn").click(function() {
                var search_term = JSON.stringify($("#search-query").val());
                $("#search-query").val("");
                $.post("blog.php/blog/search", search_term)
                    .done(function( data ) {
                        var rdata = $.parseJSON(data);
                        var author = rdata["author"];
                        var title = rdata["title"];
                        var body = rdata["body"];
                        var cdate = rdata["date"];

                        $("#blog-title").replaceWith("<h1 id='blog-title'>" + title + "</h1>");
                        $("#blog-author").replaceWith("<a id='blog-author' href='#''>" + author + "</a>");
                        $("#blog-body").replaceWith("<p id='blog-body' class='lead' style='word-wrap: break-word;'>" + body + "</p>");
                        $("#blog-created-date").replaceWith(
                            "<p id='blog-created-date'><span class='glyphicon glyphicon-time'></span> " + cdate["date"] + "</p>"
                        );
                    })
                    .fail(function( data ) {
                        var fdata = $.parseJSON(data.responseText);
                        var html = `
                                <div id="blog-search" class="well">
                                    <h4>Blog Search</h4>
                                            <div class="input-group">
                                                <input id="search-query" type="text" class="form-control">
                                                        <span class="input-group-btn">
                                                            <button id="search-btn" class="btn btn-default" type="button">
                                                                <span class="glyphicon glyphicon-search"></span>
                                                            </button>
                                                        </span>
                                            </div>
                                </div>
                                <p id='search-error' style='color: #B22222; font-size: 20px;'>` + fdata["error"] + `</p>
                        `;
                        $("#blog-search").replaceWith(html);
                        setTimeout(function() {
                            $("#search-error").remove();
                        }, 5000);
                    });
        });
});
