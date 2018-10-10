<template>
 <section class="hero is-medium">
            <div class="hero-body">
                <div class="container" style="width: 50%">
                    <h1 class="title has-text-centered">¡Regístrate!</h1>
                    <div class="box">
                        <div class="field">
                            <label class="label">Nombre</label>
                            <div class="control">
                                <input v-model="login.name" class="input" type="text" placeholder="Nombre">
                            </div>
                            </div>
                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control">
                                <input v-model="login.email" class="input" type="email" placeholder="e.g bensondaniel@gmail.com">
                            </div>
                            </div>

                            <div class="field">
                            <label class="label">Password</label>
                            <div class="control">
                                <input v-model="login.password" class="input" type="password" placeholder="Password">
                            </div>
                        </div>
                        <a class="button is-primary" @click="registerUser">Registrarse</a>
                    </div>
                </div>
            </div>
        </section>
</template>

<script>
    export default {
        mounted() {
        },
        data () {
            return {
                login: {
                    email: '',
                    password: '',
                    name: '',
                }
            }
        },
        methods: {
            registerUser(){
                var app = this
                this.$auth.register({
                    params: {
                        name: this.login.name,
                        email: this.login.email,
                        password: this.login.password
                    },
                    success: function(resp){
                        this.success = true
                        console.log('registered and logging in....')
                        console.log(resp)

                    },
                    error: function (resp) {
                        this.error = true
                        this.errors = resp.response.data.errors
                    },
                    autoLogin: true,
                    redirect: '/boards'
            })
        }
    }
}
</script>
