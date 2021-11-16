document.addEventListener("DOMContentLoaded", (e) => {
	var html = document.getElementById('preload')
	var preloader = document.getElementById('pg-preloader')
	var app_container = document.getElementById('app')
	var pre_container = document.getElementById('preload-container')
	setTimeout(removePreload, 1000, html, app_container, pre_container, preloader)
});
function removePreload(html, app, preloader_container, preloader) {
		preloader_container.removeChild(preloader)
		html.classList.remove('preload')
		app.classList.remove('preloading')
}