// Content Slider script for Module Banner Slider
// by VietNQ [aFeLiOn], based on Featured Content Slider script - dynamicdrive.com


function ContentSlider(sliderid, timeout, random, fadein) {
	this.id = sliderid
	this.timeout = (typeof timeout == "number") ? timeout : 5000
	this.fadein = (typeof fadein != "undefined") ? fadein : 1
	this.sliders = []
	this.pointer = -1
	this.pause = 0

	var slider = document.getElementById(sliderid)
	var alldivs = slider.getElementsByTagName("div")
	
	for (var i = 0; i < alldivs.length; i++) {
		if (alldivs[i].className == "bs_opacitylayer")
			slider.opacitylayer = alldivs[i]
		else if (alldivs[i].className == "bs_contentdiv") {
			this.sliders.push(alldivs[i])
		}
	}

	this.targetobject = slider.opacitylayer || null

	var csobj = this
	slider.onmouseover = function(){csobj.pause = 1}
	slider.onmouseout = function(){csobj.pause = 0}

	if ( (typeof random == "undefined") || (random == 1) )
		this.sliders.sort(function() {return 0.5 - Math.random();})

	this.slide()
}

ContentSlider.prototype.slide = function() {
	var csobj = this

	if (this.sliders.length == 0)
		return;

	if (this.pause) {
		setTimeout(function(){csobj.slide()}, 500)
	}
	else {
		this.pointer = (this.pointer < this.sliders.length - 1) ? this.pointer+1 : 0
	
		for (var i = 0; i < this.sliders.length; i++) {
			this.sliders[i].style.display = "none"
		}
		if (this.fadein) {
			if (window[this.id + "fadetimer"])
				clearTimeout(window[this.id + "fadetimer"])
			this.setopacity(0.1)
		}
		this.sliders[this.pointer].style.display = "block"
		if (this.fadein)
			this.fadeup()
	
		window[this.id + "timer"] = setTimeout(function(){csobj.slide()}, this.timeout)
	}
}

ContentSlider.prototype.setopacity = function(value) {
	if (this.targetobject && this.targetobject.filters && this.targetobject.filters[0]) {
		if (typeof this.targetobject.filters[0].opacity == "number")
			this.targetobject.filters[0].opacity = value * 100
		else
			this.targetobject.style.filter = "alpha(opacity=" + value * 100 + ")"
	}
	else if (this.targetobject && typeof this.targetobject.style.MozOpacity != "undefined")
		this.targetobject.style.MozOpacity = value
	else if (this.targetobject && typeof this.targetobject.style.opacity != "undefined")
		this.targetobject.style.opacity = value
	this.targetobject.currentopacity = value
}

ContentSlider.prototype.fadeup = function() {
	if (this.targetobject && this.targetobject.currentopacity < 1) {
		this.setopacity(this.targetobject.currentopacity + 0.1)
		var csobj = this
		window[this.id + "fadetimer"] = setTimeout(function(){csobj.fadeup()}, 100)
	}
}

// For Banner Slider
// ContentSlider.build = function(images) {
// 	for (var i = 0; i < images.length; i++) {
// 		ContentSlider.build1(images[i])
// // 		document.write('<div class="bs_contentdiv"><a href="index.php?option=com_banners&task=click&bid=' + images[i][0] + '"><img src="../../images/banners/' + images[i][1] + '" /></a></div>')
// 	}
// }
// 
// ContentSlider.build1 = function(image) {
// 	document.write('<div class="bs_contentdiv"><a href="index.php?option=com_banners&task=click&bid=' + images[0] + '"><img src="../../images/banners/' + images[1] + '" /></a></div>')
// }
