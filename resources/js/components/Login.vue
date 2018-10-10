<template>
        <section class="hero is-medium">
            <div class="hero-body">
                <div class="container" style="width: 50%">
                    <h1 class="title has-text-centered">Login</h1>
                    <div class="box">
                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control">
                                <input v-model="login.email" class="input" type="email" placeholder="e.g bensondaniel@gmail.com">
                            </div>
                            </div>

                            <div class="field">
                            <label class="label">Password</label>
                            <div class="control">
                                <input v-model="login.password" class="input" type="password" placeholder="password">
                            </div>
                        </div>
                        <a class="button is-primary" @click="loginUser">Login</a>
                    </div>
                </div>
            </div>
        </section>
</template>
<style scoped>


</style>


<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data () {
            return {
                login: {
                    email: '',
                    password: ''
                }
            }
        },
        methods: {
            loginUser(){
                var app = this
                this.$auth.login({
                    params: {
                        email: app.login.email,
                        password: app.login.password
                    },
                    success: function(resp){
                        let user = this.$auth.user();
                        let newToken = resp.data.token;
                        axios.defaults.headers.common['Authorization'] = 'Bearer ' + newToken
                        console.log(`new token: ${newToken}`);
                        localStorage.setItem('token', newToken);
                        Event.$emit('login',user);
                        },
                    error: function(err) {
                        console.log(err)
                    },
                    rememberMe: true,
                    fetchUser: true,
                    redirect: '/boards'
                })
                // axios.post('/api/login', this.login).then(response => {
                //     localStorage.setItem('api_token', response.data.token)
                //     console.log(response.data.token)
                //     this.$router.push('/boards')
                // }).catch((err) => {
                //     console.log(err)
                // })
            }
        }
    }
</script>
