"use strict";
document.addEventListener("DOMContentLoaded", function () {
	const body = document.querySelector("body");

	/**
	 * Theme Settings
	 */
	//   const themeDropdownIcon = document.getElementById("themeDropdownIcon");
	//   const theme = localStorage.getItem("theme");
	//   const systemPrefersDark = window.matchMedia(
	//     "(prefers-color-scheme: dark)"
	//   ).matches;

	//   if (theme === "dark") {
	//     document.body.setAttribute("data-bs-theme", "dark");
	//     updateThemeIcon("dark");
	//   } else if (theme === "light") {
	//     document.body.setAttribute("data-bs-theme", "light");
	//     updateThemeIcon("light");
	//   } else if (theme === "auto" && systemPrefersDark) {
	//     document.body.setAttribute("data-bs-theme", "dark");
	//     updateThemeIcon("auto");
	//   } else if (theme === "auto" && !systemPrefersDark) {
	//     document.body.setAttribute("data-bs-theme", "light");
	//     updateThemeIcon("auto");
	//   } else if (systemPrefersDark) {
	//     document.body.setAttribute("data-bs-theme", "dark");
	//     updateThemeIcon("dark");
	//   } else {
	//     document.body.setAttribute("data-bs-theme", "light");
	//     updateThemeIcon("light");
	//   }

	// Handle theme change
	//   document.getElementById("lightTheme").addEventListener("click", function () {
	//     document.body.setAttribute("data-bs-theme", "light");
	//     localStorage.setItem("theme", "light");
	//     updateThemeIcon("light");
	//   });

	//   document.getElementById("darkTheme").addEventListener("click", function () {
	//     document.body.setAttribute("data-bs-theme", "dark");
	//     localStorage.setItem("theme", "dark");
	//     updateThemeIcon("dark");
	//   });

	//   document.getElementById("autoTheme").addEventListener("click", function () {
	//     localStorage.setItem("theme", "auto");
	//     if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
	//       document.body.setAttribute("data-bs-theme", "dark");
	//     } else {
	//       document.body.setAttribute("data-bs-theme", "light");
	//     }
	//     updateThemeIcon("auto");
	//   });
	//   function updateThemeIcon(theme) {
	//     if (theme === "light") {
	//       themeDropdownIcon.className = "bi bi-brightness-high";
	//     } else if (theme === "dark") {
	//       themeDropdownIcon.className = "bi bi-moon-stars";
	//     } else {
	//       themeDropdownIcon.className = "bi bi-circle-half";
	//     }
	//   }
	/**
	 * Slide Up
	 */
	const slideUp = (target, duration = 500) => {
		target.style.transitionProperty = "height, margin, padding";
		target.style.transitionDuration = duration + "ms";
		target.style.boxSizing = "border-box";
		target.style.height = target.offsetHeight + "px";
		target.offsetHeight;
		target.style.overflow = "hidden";
		target.style.height = 0;
		target.style.paddingTop = 0;
		target.style.paddingBottom = 0;
		target.style.marginTop = 0;
		target.style.marginBottom = 0;
		window.setTimeout(() => {
			target.style.display = "none";
			target.style.removeProperty("height");
			target.style.removeProperty("padding-top");
			target.style.removeProperty("padding-bottom");
			target.style.removeProperty("margin-top");
			target.style.removeProperty("margin-bottom");
			target.style.removeProperty("overflow");
			target.style.removeProperty("transition-duration");
			target.style.removeProperty("transition-property");
		}, duration);
	};
	/**
	 * Slide Down
	 */
	const slideDown = (target, duration = 500) => {
		target.style.removeProperty("display");
		let display = window.getComputedStyle(target).display;

		if (display === "none") display = "block";

		target.style.display = display;
		let height = target.offsetHeight;
		target.style.overflow = "hidden";
		target.style.height = 0;
		target.style.paddingTop = 0;
		target.style.paddingBottom = 0;
		target.style.marginTop = 0;
		target.style.marginBottom = 0;
		target.offsetHeight;
		target.style.boxSizing = "border-box";
		target.style.transitionProperty = "height, margin, padding";
		target.style.transitionDuration = duration + "ms";
		target.style.height = height + "px";
		target.style.removeProperty("padding-top");
		target.style.removeProperty("padding-bottom");
		target.style.removeProperty("margin-top");
		target.style.removeProperty("margin-bottom");
		window.setTimeout(() => {
			target.style.removeProperty("height");
			target.style.removeProperty("overflow");
			target.style.removeProperty("transition-duration");
			target.style.removeProperty("transition-property");
		}, duration);
	};
	/**
	 * Slide Toggle
	 */
	const slideToggle = (target, duration = 500) => {
		if (target.attributes.style === undefined || target.style.display === "none") {
			return slideDown(target, duration);
		} else {
			return slideUp(target, duration);
		}
	};
	/**
	 * Primary Menu
	 */
	const mdScreen = "(max-width: 991px)";
	const mdScreenSize = window.matchMedia(mdScreen);
	const menuHasSub = document.querySelectorAll(".has-sub");

	const mdScreenSizeActive = (screen) => {
		if (screen.matches) {
			// Menu Toggle
			const menuToggleHandler = document.querySelectorAll(".menu-toggle");
			if (menuToggleHandler) {
				menuToggleHandler.forEach((e) => {
					e.addEventListener("click", (el) => {
						el.stopPropagation();
						document.body.classList.toggle("menu-open");
					});
				});
			}
			// Menu Toggle End

			// if menu has sub
			menuHasSub.forEach((e) => {
				e.addEventListener("click", (el) => {
					el.preventDefault();
					el.stopPropagation();
					el.target.classList.toggle("active");
					const menuSub = e.nextElementSibling;
					slideToggle(menuSub, 500);
				});
			});
			// if menu has sub end

			// Close submenu on click outside
			document.addEventListener("click", () => {
				if (document.body.classList.contains("menu-open")) {
					document.body.classList.remove("menu-open");
				}
			});
			// Close submenu on click outside end

			// Menu Nav Stop Propagation
			const menuNav = document.querySelectorAll(".menu-nav");
			if (menuNav.length) {
				menuNav.forEach((e) => {
					e.addEventListener("click", (el) => {
						el.stopPropagation();
					});
				});
			}
			// Menu Nav Stop Propagation end
		} else {
			menuHasSub.forEach((e) => {
				e.addEventListener("click", (el) => {
					el.preventDefault();
				});
			});
		}
	};
	mdScreenSize.addEventListener("change", (e) => {
		if (e.matches) {
			window.location.reload();
			mdScreenSizeActive(e);
		} else {
			mdScreenSize.removeEventListener("change", (e) => {
				mdScreenSizeActive(e);
			});
			window.location.reload();
		}
	});
	mdScreenSizeActive(mdScreenSize);
	/**
	 * Header Fixed On Scroll
	 */
	window.addEventListener("scroll", () => {
		const fixedHeader = document.querySelector(".header");
		if (fixedHeader) {
			const headerTop = fixedHeader.offsetHeight;
			const scrolled = window.scrollY;
			const headerFixed = () => {
				if (scrolled > headerTop) {
					body.classList.add("header-crossed");
				} else if (scrolled < headerTop) {
					body.classList.remove("header-crossed");
				} else {
					body.classList.remove("header-crossed");
				}
			};
			headerFixed();
		}
	});
	/**
	 * Dropdown Init
	 */
	const dropdownElementList = document.querySelectorAll('[data-bs-toggle="dropdown"]');
	const dropdownList = [...dropdownElementList].map((dropdownToggleEl) => new bootstrap.Dropdown(dropdownToggleEl));
	/**
	 * Sidebar Content Stop Propagation
	 */
	const sidebarContent = document.querySelector(".doc-sidebar__content");
	if (sidebarContent) {
		sidebarContent.addEventListener("click", (e) => {
			e.stopPropagation();
		});
	}
	/**
	 * Sidebar Menu Current Page Status
	 */
	const sidebarMenuList = document.querySelectorAll(".doc-sidebar-menu__list li");
	sidebarMenuList.forEach(function (item) {
		item.addEventListener("click", function () {
			// Add "current-page" class to the clicked item
			item.classList.add("current-page");

			// Remove "current-page" class from sibling items
			sidebarMenuList.forEach(function (sibling) {
				if (sibling !== item) {
					sibling.classList.remove("current-page");
				}
			});
		});
	});
	// Detect Current Page Location
	const docSidebarMenuLink = document.querySelectorAll(".doc-sidebar-menu__list > li > a");
	if (docSidebarMenuLink) {
		docSidebarMenuLink.forEach((e) => {
			const currentURL = window.location.href;
			const baseURL = currentURL.split(/[?#]/)[0];
			if (e.href == baseURL) {
				e.parentElement.classList.add("current-page");
			} else {
				e.parentElement.classList.remove("current-page");
			}
		});
	}

	// Sidebar Show Hide
	// Select all buttons and all sidebars
    const buttons = document.querySelectorAll('.side_btn');
    const sidebars = document.querySelectorAll('.doc-sidebar-wrapper');

    // Add click event listener to each button
    buttons.forEach((button, index) => {
      button.addEventListener('click', () => {
        // Toggle the corresponding sidebar
        if (sidebars[index]) {
          sidebars[index].classList.toggle('hide_sidebar');
        }
      });
    });

	// Sidebar Dropdown
	const dropdowns = document.querySelectorAll('.side_nav_item.has_dropdown');
	const contents = document.querySelectorAll('.sub_side_nav_wrapper');

	// for (let i = 0; i < dropdowns.length; i++) {
	// 	dropdowns[i].addEventListener('click', () => {
	// 		const isCurrentlyShown = contents[i].classList.contains('show');
			
	// 		contents.forEach(content => content.classList.remove('show'));

	// 		if (!isCurrentlyShown) {
	// 		contents[i].classList.add('show');
	// 		}
	// 	});
	// }


	// Current Page
	// Get the current page's URL path
	// const currentPage = window.location.pathname.split('/').pop();
	// const navItems = document.querySelectorAll('.side_nav_item');

	// Loop through the nav items
	// navItems.forEach(item => {
	// 	const link = item.querySelector('a'); 
	// 	if (link && link.getAttribute('href') === currentPage) {
	// 		item.classList.add('current'); 
	// 	}
	// });

	// Current Parent
	// const itemCurrent = document.querySelector(".side_nav_item.current");
	// const itemSidebar = document.querySelectorAll(".sub_side_nav_wrapper .side_nav_item");
	// itemCurrent.parentElement.classList.add("show");
	// itemCurrent.parentElement.parentElement.classList.add("current")
	// for (let i = 0; i < itemSidebar.length; i++) {
	// 	itemSidebar[i].parentElement.style.display = "none";
	// }
	// itemCurrent.parentElement.classList.add("show");

	// New Js
	for (let i = 0; i < dropdowns.length; i++) {
		for (let j = 0; j < contents.length; j++) {
			contents[j].style.display = 'none';
		}
	}

	// for (let i = 0; i < dropdowns.length; i++) {
	// 	dropdowns[i].addEventListener('click', () => {
			
	// 		for (let j = 0; j < contents.length; j++) {
	// 			contents[j].style.display = 'none';
	// 		}
	
	// 		contents[i].style.display = 'block';
	// 	});
	// }

	// for (let i = 0; i < dropdowns.length; i++) {
	// 	dropdowns[i].addEventListener('click', () => {
	// 		const isCurrentlyShown = contents[i].style.display === 'block';
	
	// 		// Hide all content elements
	// 		for (let j = 0; j < contents.length; j++) {
	// 			contents[j].style.display = 'none';
	// 		}
	
	// 		// Toggle the clicked content element
	// 		if (!isCurrentlyShown) {
	// 			contents[i].style.display = 'block';
	// 		}
	// 	});
	// }

	dropdowns.forEach((dropdown) => {
		const toggleButton = dropdown.querySelector('.sb_title');
		const content = dropdown.querySelector('.sub_side_nav_wrapper');
	
		toggleButton.addEventListener('click', () => {
		  // Check if this sub-menu is currently visible
		  const isCurrentlyShown = content.style.display === 'block';
	
		  // Hide all sub-menus
		  dropdowns.forEach((item) => {
			const subMenu = item.querySelector('.sub_side_nav_wrapper');
			subMenu.style.display = 'none';
		  });
	
		  // Toggle the clicked sub-menu
		  if (!isCurrentlyShown) {
			content.style.display = 'block';
		  }
		});
	});
	

	// Current Page
	// Get the current page's URL path
	const currentPage = window.location.pathname.split('/').pop();
	const navItems = document.querySelectorAll('.side_nav_item');

	// Loop through the nav items
	navItems.forEach(item => {
		const link = item.querySelector('a'); 
		if (link && link.getAttribute('href') === currentPage) {
			item.classList.add('current'); 
		}
	});

	const itemCurrent = document.querySelector(".side_nav_item.current");
	itemCurrent.parentElement.style.display = "block";
	itemCurrent.parentElement.parentElement.classList.add("current")
	
});

/**
 * Sidebar Toggle
 */
function toggleSidebar() {
	const sidebar = document.querySelector(".doc-sidebar");
	if (sidebar) {
		sidebar.classList.toggle("active");
	}
}
/**
 * Preloader
 */
const preloader = document.querySelector(".preloader");

window.onload = () => {
	if (preloader) {
		preloader.style.display = "none";
	}
	const sidebarMenuList = document.querySelectorAll(".doc-sidebar-menu__list li");
	sidebarMenuList.forEach(function (item) {
		if (item.classList.contains("current-page")) {
			let parentElement = item.parentNode;
			while (parentElement && !parentElement.classList.contains("accordion-collapse")) {
				parentElement = parentElement.parentNode;
			}
			if (parentElement) {
				parentElement.classList.add("show");
			}
		}
	});
	// Find the active item in vanilla JavaScript
	var findActiveItem = document.querySelector(".current-page");

	// Initialize activeOffsetTop
	var activeOffsetTop = 0;

	// Check if the active item is found
	if (findActiveItem) {
		// Calculate the offset top and subtract 150
		activeOffsetTop = findActiveItem.offsetTop - 150;
	}

	// Find the scrollable container in vanilla JavaScript
	var scrollableContainer = document.querySelector(".doc-sidebar__nav");

	// Check if the scrollable container is found
	if (scrollableContainer) {
		// Use vanilla JavaScript to animate the scrollTop property
		scrollableContainer.animate(
			{ scrollTop: activeOffsetTop },
			{ duration: 400, easing: "ease-in-out" } // Adjust duration and easing as needed
		);
	}
};
