jQuery( document ).ready(function() {
	jQuery('.experience_slider').slick({
		dots: false,
		infinite: true,
		arrows: false,
// 		slidesToShow: 3,
// 		slidesToScroll: 1,
		speed: 1000,
		autoplay: true,
		autoplaySpeed: 2000,
		variableWidth: true,
	});


	const winW = window.innerWidth;
	const winH = window.innerHeight;
	gsap.registerPlugin(ScrollTrigger);
	const movingPin = gsap.timeline();
	movingPin.add(
		gsap
		.timeline()
		.fromTo(".moving_forward .zoomText .elementor-heading-title", { scale: 1.5 }, { scale: 1 }, 0)
		.fromTo(".moving_forward .scale_img", { scale: 0.5 }, { scale: 1 }, 0)
		.fromTo(".moving_forward .clip_img img", { scale: 1.2 }, { scale: 1 }, 0.3)
	);
	ScrollTrigger.create({
		animation: movingPin,
		trigger: ".moving_forward",
		start: "top bottom",
		end: "center top",
		scrub: true,
	// 	markers: true,
	});
	
// 	const experiencePin = gsap.timeline();
// 	experiencePin.add(
// 		gsap
// 		.timeline()
// 		.fromTo(".experience .zoomText .elementor-heading-title", { scale: 1.5 }, { scale: 1 }, 0)
// 	);
// 	ScrollTrigger.create({
// 		animation: experiencePin,
// 		trigger: ".experience",
// 		start: "top bottom",
// 		end: "center center",
// 		scrub: true,
// 	// 	markers: true,
// 	});
	
	const modernPin = gsap.timeline();
	modernPin.add(
		gsap
		.timeline()
		.fromTo(".modern .zoomText .elementor-heading-title", { scale: 1.5 }, { scale: 1 }, 0)
		.fromTo(".modern .clip_img img", { scale: 1.2 }, { scale: 1 }, 0)
	);
	ScrollTrigger.create({
		animation: modernPin,
		trigger: ".modern",
		start: "top bottom",
		end: "center center",
		scrub: true,
	// 	markers: true,
	});

});