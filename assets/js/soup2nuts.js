/*! Eugene Weekly 2017 - v0.1.0
 * http://eugeneweekly.com
 * Copyright (c) 2016; */

!function(a){"use strict";a.fn.fitVids=function(b){var c={customSelector:null,ignore:null};if(!document.getElementById("fit-vids-style")){var d=document.head||document.getElementsByTagName("head")[0],e=".fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}",f=document.createElement("div");f.innerHTML='<p>x</p><style id="fit-vids-style">'+e+"</style>",d.appendChild(f.childNodes[1])}return b&&a.extend(c,b),this.each(function(){var b=['iframe[src*="player.vimeo.com"]','iframe[src*="youtube.com"]','iframe[src*="youtube-nocookie.com"]','iframe[src*="kickstarter.com"][src*="video.html"]',"object","embed"];c.customSelector&&b.push(c.customSelector);var d=".fitvidsignore";c.ignore&&(d=d+", "+c.ignore);var e=a(this).find(b.join(","));e=e.not("object object"),e=e.not(d),e.each(function(){var b=a(this);if(!(b.parents(d).length>0||"embed"===this.tagName.toLowerCase()&&b.parent("object").length||b.parent(".fluid-width-video-wrapper").length)){b.css("height")||b.css("width")||!isNaN(b.attr("height"))&&!isNaN(b.attr("width"))||(b.attr("height",9),b.attr("width",16));var c="object"===this.tagName.toLowerCase()||b.attr("height")&&!isNaN(parseInt(b.attr("height"),10))?parseInt(b.attr("height"),10):b.height(),e=isNaN(parseInt(b.attr("width"),10))?b.width():parseInt(b.attr("width"),10),f=c/e;if(!b.attr("name")){var g="fitvid"+a.fn.fitVids._count;b.attr("name",g),a.fn.fitVids._count++}b.wrap('<div class="fluid-width-video-wrapper"></div>').parent(".fluid-width-video-wrapper").css("padding-top",100*f+"%"),b.removeAttr("height").removeAttr("width")}})})},a.fn.fitVids._count=0}(window.jQuery||window.Zepto),function(a,b){"use strict";Modernizr.mq("only all")?jQuery("html").addClass("mq"):jQuery("html").addClass("no-mq"),jQuery(".delayed").each(function(){jQuery(this).is("iframe")?jQuery(this).attr("src",jQuery(this).data("src")):jQuery(this).css("background-image","url("+jQuery(this).data("delayed-background-image")+")")}),jQuery(".menu-toggle").on("click",function(){jQuery("body").removeClass("show-search").toggleClass("show-nav")}),jQuery(".search-trigger").on("click",function(){jQuery("body").removeClass("show-nav").toggleClass("show-search")})}(this),!function(a,b){"function"==typeof define&&define.amd?define([],function(){return a.svg4everybody=b()}):"object"==typeof exports?module.exports=b():a.svg4everybody=b()}(this,function(){function a(a,b){if(b){var c=document.createDocumentFragment(),d=!a.getAttribute("viewBox")&&b.getAttribute("viewBox");d&&a.setAttribute("viewBox",d);for(var e=b.cloneNode(!0);e.childNodes.length;)c.appendChild(e.firstChild);a.appendChild(c)}}function b(b){b.onreadystatechange=function(){if(4===b.readyState){var c=b._cachedDocument;c||(c=b._cachedDocument=document.implementation.createHTMLDocument(""),c.body.innerHTML=b.responseText,b._cachedTarget={}),b._embeds.splice(0).map(function(d){var e=b._cachedTarget[d.id];e||(e=b._cachedTarget[d.id]=c.getElementById(d.id)),a(d.svg,e)})}},b.onreadystatechange()}function c(c){function d(){for(var c=0;c<l.length;){var g=l[c],h=g.parentNode;if(h&&/svg/i.test(h.nodeName)){var i=g.getAttribute("xlink:href")||g.getAttribute("href");if(e&&(!f.validate||f.validate(i,h,g))){h.removeChild(g);var m=i.split("#"),n=m.shift(),o=m.join("#");if(n.length){var p=j[n];p||(p=j[n]=new XMLHttpRequest,p.open("GET",n),p.send(),p._embeds=[]),p._embeds.push({svg:h,id:o}),b(p)}else a(h,document.getElementById(o))}}else++c}k(d,67)}var e,f=Object(c),g=/\bTrident\/[567]\b|\bMSIE (?:9|10)\.0\b/,h=/\bAppleWebKit\/(\d+)\b/,i=/\bEdge\/12\.(\d+)\b/;e="polyfill"in f?f.polyfill:g.test(navigator.userAgent)||(navigator.userAgent.match(i)||[])[1]<10547||(navigator.userAgent.match(h)||[])[1]<537;var j={},k=window.requestAnimationFrame||setTimeout,l=document.getElementsByTagName("use");e&&d()}return c});
//# sourceMappingURL=../maps/soup2nuts.js.map