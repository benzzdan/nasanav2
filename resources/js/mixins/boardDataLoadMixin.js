export default {
    methods: {
        fetchBoardData() {
            console.log('fetching board data!');
            let token = localStorage.getItem('token');
            console.log('token: ' + token)
            axios.defaults.headers.common['Authorization'] = 'Bearer' + token;

            axios.get('/boards').then(response => {
                this.boards = response.data.boards
            }).catch((err) => {
                console.log(err)
            })
        }
    }
}