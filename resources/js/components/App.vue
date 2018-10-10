<template>
<div>
<nav class="navbar" role="navigation" aria-label="main navigation" style="background-color: #fafafa">
                <div class="container has-text-centered">
                    <div class="navbar-start" v-if="$auth.check()">
                        <div class="navbar-item" v-if="$auth.check()">
                            <div class="dropdown" style="cursor: pointer">
                                <div class="dropdown-trigger">
                                    <!-- <button class="button" aria-haspopup="true" aria-controls="dropdown-menu"> -->
                                    <i class="fa fa-table" aria-controls="dropdown-menu" style="font-size: 2em"></i>
                                    <span class="subtitle" style="padding-left: 0.2em;position: relative;top: -4px;">
                                        Tableros
                                    </span>
                                    <!-- </button> -->
                                </div>
                                <div class="dropdown-menu" id="dropdown-menu" role="menu">
                                    <div class="dropdown-content">
                                        <router-link  v-for="(board, index) in boards" :key="index" :to ="{ name:'SelectedBoard', params:{ id:board.id }}" class="dropdown-item">
                                            {{ board.name }}
                                        </router-link>
                                        <p v-if="boards.length == 0" >No tienes tableros aun, crea uno.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="navbar-item">
                            <div class="dropdown">
                                <div class="dropdown-trigger">
                                    <button class="button is-primary" aria-haspopup="true" aria-controls="dropdown-menu2">
                                    <!-- <span style="cursor: pointer"><img src="img/add.png" alt="" class="addpng"></span> -->
                                        Agregar
                                    </button>
                                </div>
                                <div class="dropdown-menu" id="dropdown-menu2" role="menu" style="min-width: 83vh">
                                    <div class="dropdown-content">
                                        <div class="dropdown-item" style="text-align: left">
                                            <div class="field" >
                                                <label class="label subtitle">Nombre</label>
                                                <div class="control">
                                                    <input type="text" class="input" placeholder="Nombre de Tablero" v-model="boardName">
                                                </div>
                                            </div>
                                            <a @click="createBoard" class="button is-primary">Crear</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <router-link to="/boards" v-if="$auth.check()">
                            <h1 class="logo">Nasana</h1>
                        </router-link>
                        <router-link to="/" v-if="!$auth.check()" style="width: 100%">
                            <h1 class="logo">Nasana</h1>
                        </router-link>
                    <div class="navbar-end">
                        <div class="navbar-item">
                            <div class="buttons">
                                <router-link v-if="!$auth.check()" to="/login">
                                    <a class="button is-info">Iniciar Sesión</a>
                                </router-link>
                                <router-link v-if="!$auth.check()" to="/register">
                                    <a class="button is-info">Registrarse</a>
                                </router-link>
                                <a v-if="$auth.check()" @click="logoutUser" class="button is-danger">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <transition name="fade">
                <router-view></router-view>
            </transition>
</div>

</template>
<style scoped>
    .dropdown-content {
        text-align: left;
    }

    .addpng {
        border-radius: 50%;
        padding: 1vh;
    }
    .addpng:hover {
    background-color: #00d0ff;
    -webkit-transition: background-color 950ms linear;
    -ms-transition: background-color 950ms linear;
    transition: background-color 950ms linear;
    }

</style>

<script>
import BoardLoadMixin from '../mixins/boardDataLoadMixin'
import Vue from 'vue';



    export default {
        data(){
            return {
                user: '',
                boards: [],
                token: '',
                boardName: ''
            }
        },
          methods: {
            logoutUser() {
            console.log('loggin out user')
            this.$auth.logout({
                success: function(resp) {
                    console.log('successfully log out user')
                },
                error: function(resp) {
                    console.log(resp)
                }
            });
        },
        createBoard() {
            console.log('creating board');
            let boardName = this.boardName;
            axios.post('/boards', { name: boardName }).then(response => {
                console.log(response)
                this.boards.push(response.data.board);
            })
            this.boardName = '';
            Event.$emit('created_board', boardName);
        }
    },
    mixins: [
        BoardLoadMixin
    ],
        created() {

            //Solution for fetching boards to toolbar

        Event.$on('token', ($token) => {
            let token = $token;
            this.token = token;
            console.log(`this is the token: ${token}`);
            axios.defaults.headers.common['Authorization'] = 'Bearer' + token;
               axios.get('/boards').then(response => {
                this.boards = response.data.boards
            }).catch((err) => {
                console.log(err)
            })

        })


            Event.$on('login', ($user) => {
                this.user = $user;
                console.log(`tesging from app.vue ${this.user}`)
            });

            console.log('loading data table');

           console.log('fetching board data!');
        }
    }
</script>
