function check_google_user () {
		gapi.load('client:auth2', () => {
	  gapi.client.init({
	    apiKey: google_api_key,
	    client_id: google_client_key,
	    discoveryDocs: ["https://people.googleapis.com/$discovery/rest?version=v1"],
	    scope: 'https://www.googleapis.com/auth/userinfo.profile',
	  })
	  .then(() => {
	    // Handle the initial sign-in state.
	  });
	});
}