$(document).on("pageload",function(){
	$.get( "blog.php/latest" );
            .done( function( data ) {
                var title = data[0].title;
                var body = data[0].body;
                var author = data[0].author;
                var createdDate = data[0].createdDate;

                $("#blog-title").text(title);
                $("#blog-body").text(body);
                $("blog-author").text(author);
                $("blog-created-date").text(createdDate);
        });
});
