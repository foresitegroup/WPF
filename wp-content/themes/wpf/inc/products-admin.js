!function(a){FeaturedGalleryManager=function(a){function b(a,b){"HTMLPreview"in a&&(a.HTMLPreview,b.HTMLPreview.innerHTML=a.HTMLPreview),"permMetadata"in a&&(a.permMetadata,b.permMetadata.value=a.permMetadata),""===a.HTMLPreview||""===a.permMetadata?(b.buttonRemove.style.display="none",b.buttonSelect.textContent="Select Images"):(b.buttonRemove.style.display="",b.buttonSelect.textContent="Edit Selection")}function c(a,b){setTimeout(function(){e({method:"post",queryURL:fgInfoFromPHP.wpAdminAjaxURL,data:{action:"fg_save_temp_metadata",fg_post_id:b,fg_temp_noncedata:a.tempNoncedata.value,fg_temp_metadata:a.permMetadata.value},success:function(a){a=JSON.parse(a),a.success||(console.log(a.response),alert("There was an issue with updating the live preview. Make sure that you click Save to ensure your changes aren't lost."))},error:function(a){alert("There was an issue with updating the live preview. Make sure that you click Save to ensure your changes aren't lost.")}})},0)}function d(){var a=document.querySelector(".media-menu a:first-child");a&&(a.textContent="← Edit Selection",a.className="media-menu-item button button-large")}function e(a){var b="method"in a?a.method:"get",c="queryURL"in a?a.queryURL:"",d="data"in a?a.data:"",e="",f="success"in a?a.success:function(a){console.log("Successfully completed AJAX request.")},g="error"in a?a.error:function(a){console.log("Error during AJAX request.")},h=new XMLHttpRequest;switch(typeof d){case"string":e=d;break;case"object":for(key in d)e+=key+"="+d[key]+"&";e=e.slice(0,-1)}h.onreadystatechange=function(){4===h.readyState&&(200===h.status?f(h.responseText,h.status):g(h.responseText,h.status))},"post"==b.toLowerCase()?(h.open(b,c,!0),h.setRequestHeader("Content-type","application/x-www-form-urlencoded"),h.send(e)):(h.open(b,c+(""==e?"":"?"+e),!0),h.send(null))}var f={};return function(a){var e=this;if(e.flags={},e.frame=null,e.el={buttonSelect:document.querySelector("#products_gallery_select"),buttonRemove:document.querySelector("#products_gallery_removeall"),modal:null,HTMLPreview:document.querySelector("#fg-post-gallery"),permMetadata:document.querySelector("#fg_perm_metadata"),permNoncedata:document.querySelector("#fg_perm_noncedata"),tempNoncedata:document.querySelector("#fg_temp_noncedata")},f=wp.media.view.l10n,"1"===fgInfoFromPHP.showDetailsSidebar||!0===fgInfoFromPHP.showDetailsSidebar?e.flags.showDetailsSidebar=!0:e.flags.showDetailsSidebar=!1,"1"===fgInfoFromPHP.useLegacySelection||!0===fgInfoFromPHP.useLegacySelection?e.flags.useLegacySelection=!0:e.flags.useLegacySelection=!1,null==e.el.buttonSelect||null==e.el.buttonRemove)return!1;e.postID=e.el.permMetadata.dataset.post_id,e.frame=wp.media.frames.fg_frame=wp.media({state:"featured-gallery",frame:"post",library:{type:"image"}}),e.frame.states.add([new wp.media.controller.Library({id:"featured-gallery",title:"Select Images for Gallery",priority:20,toolbar:"main-gallery",filterable:"uploaded",library:wp.media.query(e.frame.options.library),multiple:!!e.flags.useLegacySelection||"add",editable:!1,displaySettings:!1,displayUserSettings:!1})]),e.el.modal=e.frame.el,e.frame.on("ready",function(){e.el.modal.classList.add("fg-media-frame"),e.flags.showDetailsSidebar||e.el.modal.classList.add("no-details-sidebar"),d()}),e.frame.on("open",function(){if(""!=e.el.permMetadata.value){var a,b=e.frame.state().get("selection"),c=e.el.permMetadata.value.split(",");e.frame.state("gallery-edit");c.forEach(function(c){a=wp.media.attachment(c),a.fetch(),b.add(a)}),e.frame.state("gallery-edit").set("library",b),e.frame.setState("gallery-edit"),e.frame.modal.focusManager.focus()}}),e.frame.on("close",function(){wp.media.view.l10n=f}),e.frame.on("update",function(){var a,d,f=[],g="";e.frame.state().get("library").each(function(b){f.push(b.attributes.id),d="thumbnail"in b.attributes.sizes?b.attributes.sizes.thumbnail.url:b.attributes.url,a=b.attributes.id,g+='<li><button type="button"></button><img id="'+a+'" src="'+d+'"></li>'}),f.length&&(b({HTMLPreview:g,permMetadata:f.join(",")},e.el),c(e.el,e.postID))}),e.frame.on("content:render",function(){d()}),e.el.buttonSelect.addEventListener("click",function(a){wp.media.view.l10n.createNewGallery="Arrange Images",wp.media.view.l10n.updateGallery="Set Featured Gallery",wp.media.view.l10n.insertGallery="Set Featured Gallery",e.frame.open()}),e.el.buttonRemove.addEventListener("click",function(a){confirm("Are you sure you want to remove all images?")&&(b({HTMLPreview:"",permMetadata:""},e.el),c(e.el,e.postID))}),e.el.HTMLPreview.addEventListener("click",function(a){if("button"==a.target.tagName.toLowerCase()&&confirm("Are you sure you want to remove this image?")){var d=a.target.nextElementSibling.id,f=e.el.permMetadata.value;f=f.replace(","+d,"").replace(d+",","").replace(d,""),e.el.permMetadata.value=f,a.target.parentNode.parentNode.removeChild(a.target.parentNode),""===e.el.permMetadata.value&&b({permMetadata:""},e.el),c(e.el,e.postID)}})}}(),document.addEventListener("DOMContentLoaded",function(b){a.featuredGalleryManager=new FeaturedGalleryManager})}(window);