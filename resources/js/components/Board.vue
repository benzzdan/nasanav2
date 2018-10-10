<template>
    <section class="hero">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">Tableros</h1>
                <div class="tile is-ancestor">
                    <div class="tile">
                        <div class="tile is-parent" v-for="(board, index) in boards" :key="index">
                            <router-link :to="{name:'SelectedBoard',params:{id:board.id}}">
                                <article class="tile is-child notification is-primary">
                                    <p class="title">{{ board.name}}
                                    </p>
                                </article>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<style scoped>
    .tile:not(.is-child) {
        display: inline-table;
    }

    .tile article {
        max-width: 175px;
    }

    .tile article {
    width: 180px;
    height: 95px;
    opacity: 0.9;
    }

    .tile article:hover {
        cursor: pointer;
        opacity: 1;
    }

    .tile article p {
        font-size: 0.9rem;
        font-weight: 900;
    }
</style>

<script>





import fetchBoardData from '../mixins/boardDataLoadMixin'
    export default {


        data(){
            return {
                boards: []
            }
        },
        mixins: [
            // fetchBoardData
        ],
        mounted(){
            console.log('testing from board')
            let refreshedToken = this.$auth.token();
            Event.$emit('token', refreshedToken)
                // console.log(refreshedToken);
            this.fetchBoardData();

            Event.$on('created_board', ($board) => {
                this.fetchBoardData();
            })

        },
        methods: {
            fetchBoardData() {
                axios.get('/boards').then(response => {
                this.boards = response.data.boards;
                let boards = response.data.boards;
                Event.$emit('loadBoard', boards);
            }).catch((err) => {
                console.log(err)
            });
            },
            created(){

            }
        },
    }
</script>
