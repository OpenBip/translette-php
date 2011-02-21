<?php

$pageTitle="Example Web Service Usage";
include( 'template/header.php' );
?>

<script type="text/javascript">
dojo.require("dojo.io.script");

var rowOnToggle = true;
dojo.addOnLoad(function() {
dojo.io.script.get({
  callbackParamName : "jsoncallback",

  url: "http://www.flickr.com/services/rest/?method=flickr.photos.search"
	  + "&api_key=388c6859df53fc16121451527a0913bc"
	  + "&tags=cats,dogs"
	  + "&per_page=10"
	  + "&tag_mode=and",
	  //photos_public.gne",
  content: {format: "json"},
  load: function(response, ioArgs) {
	  console.log(response);
	  for (var i = 0; i < response.photos.photo.length; ++i) {
		  
		  var item = response.photos.photo[i];
  	  var tr = document.createElement("tr");
  	  dojo.addClass(tr, rowOnToggle ? 'table-row-on' : 'table-row-off');
  	  rowOnToggle = ! rowOnToggle;
  	  var descriptionCell = document.createElement("td");
//  	  descriptionCell.innerHTML = item.description;

  	  var image = document.createElement("img");
  	  image.src = "http://farm" + item["farm"] + ".static.flickr.com/"
  		    + item['server'] + "/"
  		    + item['id'] + "_" + item['secret'] + "_" + "s.jpg"; // [mstb].jpg";
  		descriptionCell.appendChild(image);
  		
  	  descriptionCell.style.textAlign = "center";
  	  tr.appendChild(descriptionCell);
  	  dojo.byId("body").appendChild(tr);
	  }
	  return response;
  },
  error: function(response, ioArgs) {
	  console.log("error");
	  console.log(response);
	  return response;
  }
}); });
</script>

<table class="list-table" style="width: 60%;">
  <tr class="table-header">
    <th>Image</th>
  </tr>
  
  <tbody id="body">
  </tbody>
</table>

<? include 'template/footer.php'; ?>