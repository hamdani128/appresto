$(function () {
	"use strict";
	new PerfectScrollbar(".header-message-list"),
		new PerfectScrollbar(".header-notifications-list"),
		$(".mobile-search-icon").on("click", function () {
			$(".search-bar").addClass("full-search-bar");
		}),
		$(".search-close").on("click", function () {
			$(".search-bar").removeClass("full-search-bar");
		}),
		$(".mobile-toggle-menu").on("click", function () {
			$(".wrapper").addClass("toggled");
		}),
		$(".toggle-icon").click(function () {
			$(".wrapper").hasClass("toggled")
				? ($(".wrapper").removeClass("toggled"),
				  $(".sidebar-wrapper").unbind("hover"))
				: ($(".wrapper").addClass("toggled"),
				  $(".sidebar-wrapper").hover(
						function () {
							$(".wrapper").addClass("sidebar-hovered");
						},
						function () {
							$(".wrapper").removeClass("sidebar-hovered");
						}
				  ));
		}),
		$(document).ready(function () {
			$(window).on("scroll", function () {
				$(this).scrollTop() > 300
					? $(".back-to-top").fadeIn()
					: $(".back-to-top").fadeOut();
			}),
				$(".back-to-top").on("click", function () {
					return (
						$("html, body").animate(
							{
								scrollTop: 0,
							},
							600
						),
						!1
					);
				});
		}),
		$(".chat-toggle-btn").on("click", function () {
			$(".chat-wrapper").toggleClass("chat-toggled");
		}),
		$(".chat-toggle-btn-mobile").on("click", function () {
			$(".chat-wrapper").removeClass("chat-toggled");
		}),
		$(".email-toggle-btn").on("click", function () {
			$(".email-wrapper").toggleClass("email-toggled");
		}),
		$(".email-toggle-btn-mobile").on("click", function () {
			$(".email-wrapper").removeClass("email-toggled");
		}),
		$(".compose-mail-btn").on("click", function () {
			$(".compose-mail-popup").show();
		}),
		$(".compose-mail-close").on("click", function () {
			$(".compose-mail-popup").hide();
		}),
		$(".switcher-btn").on("click", function () {
			$(".switcher-wrapper").toggleClass("switcher-toggled");
		}),
		$(".close-switcher").on("click", function () {
			$(".switcher-wrapper").removeClass("switcher-toggled");
		}),
		$("#lightmode").on("click", function () {
			$("html").attr("class", "light-theme");
		}),
		$("#darkmode").on("click", function () {
			$("html").attr("class", "dark-theme");
		}),
		$("#semidark").on("click", function () {
			$("html").attr("class", "semi-dark");
		}),
		$("#minimaltheme").on("click", function () {
			$("html").attr("class", "minimal-theme");
		}),
		$("#headercolor1").on("click", function () {
			$("html").addClass("color-header headercolor1"),
				$("html").removeClass(
					"headercolor2 headercolor3 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8"
				);
		}),
		$("#headercolor2").on("click", function () {
			$("html").addClass("color-header headercolor2"),
				$("html").removeClass(
					"headercolor1 headercolor3 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8"
				);
		}),
		$("#headercolor3").on("click", function () {
			$("html").addClass("color-header headercolor3"),
				$("html").removeClass(
					"headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8"
				);
		}),
		$("#headercolor4").on("click", function () {
			$("html").addClass("color-header headercolor4"),
				$("html").removeClass(
					"headercolor1 headercolor2 headercolor3 headercolor5 headercolor6 headercolor7 headercolor8"
				);
		}),
		$("#headercolor5").on("click", function () {
			$("html").addClass("color-header headercolor5"),
				$("html").removeClass(
					"headercolor1 headercolor2 headercolor4 headercolor3 headercolor6 headercolor7 headercolor8"
				);
		}),
		$("#headercolor6").on("click", function () {
			$("html").addClass("color-header headercolor6"),
				$("html").removeClass(
					"headercolor1 headercolor2 headercolor4 headercolor5 headercolor3 headercolor7 headercolor8"
				);
		}),
		$("#headercolor7").on("click", function () {
			$("html").addClass("color-header headercolor7"),
				$("html").removeClass(
					"headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor3 headercolor8"
				);
		}),
		$("#headercolor8").on("click", function () {
			$("html").addClass("color-header headercolor8"),
				$("html").removeClass(
					"headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor7 headercolor3"
				);
		});
});
