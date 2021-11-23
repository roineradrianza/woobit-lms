const Http = {
    async get(url) {
        let response = await fetch(url)
        return response.json()
    },

    post(url, data) {
        let response = fetch(url,
            {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json'
                },
                referrerPolicy: 'no-referrer',
                body: JSON.stringify(data)
            }
        ).then(response => {
            return response.json()
        })
        return response
    },

    put(url, data) {
        let response = fetch(url,
            {
                method: 'PUT',
                mode: 'cors',
                cache: 'no-cache',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json'
                },
                referrerPolicy: 'no-referrer',
                body: JSON.stringify(data)
            }
        ).then(response => {
            return response.json()
        })
        return response
    },

    delete(url, data) {
        let response = fetch(url,
            {
                method: 'DELETE',
                mode: 'cors',
                cache: 'no-cache',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json'
                },
                referrerPolicy: 'no-referrer',
                body: JSON.stringify(data)
            }
        ).then(response => {
            return response.json()
        })
        return response
    }
}