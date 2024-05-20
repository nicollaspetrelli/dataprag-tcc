import axios from "axios"

function searchLocation(query) {
    return axios.get('https://us1.locationiq.com/v1/search.php', {
        params: {
            q: query,
            key: 'pk.0b5d6779c85a67c491d518be70eb4833',
            format: "json",
            countrycodes: "br",
        },
    })
}

export default searchLocation