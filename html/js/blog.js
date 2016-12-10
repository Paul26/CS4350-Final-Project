$(window).load(function(){
	$.getJSON('blog.php/blog/latest', function (data) {
		var title = data["title"];
		var body = data["body"];
		var author = data["author"];
		var createdDate = data["createdDate"];

		$("#blog-title").text(title);
		$("#blog-body").text(body);
		$("#blog-author").text(author);
		$("#blog-created-date").append(createdDate);
	});
});
