function getNotifications () {
	if (uid != undefined) {
		var url = api_url + 'notifications/get'
		if (vm.$data.hasOwnProperty('notifications')) {
			vm.$http.get(url).then( res => {
				vm.$data.notification_loading = false
				if (res.body.length > 0) {
					res.body.forEach( (n) => {
						notification = n
						notification.redirect_url = null
						if (notification.lesson_id != null) {
							notification.redirect_url = `${domain}/courses/${notification.course_slug}/${notification.lesson_id}`
						}
						else if (notification.course_id != null) {
							notification.redirect_url = `${domain}/courses/${notification.course_slug}`			
						}
						if (vm.$data.hasOwnProperty('notifications')) {
							vm.$data.notifications.push(notification)
						}
					});

				}
			}, err => {
				vm.$data.notification_loading = false
			})
		}
	}
}
window.addEventListener("load", getNotifications());