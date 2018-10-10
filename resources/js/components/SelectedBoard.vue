<template>
    <section class="hero">
        <div class="hero-body">
                <h1 class="title">{{ board.name }}</h1>
                          <div class="dropdown">
                                <div class="dropdown-trigger">
                                    <button class="button is-warning" aria-haspopup="true" aria-controls="dropdown-menu2">
                                        <span>Agregar Lista</span>
                                    </button>
                                </div>
                                <div class="dropdown-menu" id="dropdown-menu2" role="menu" style="min-width: 83vh;">
                                    <div class="dropdown-content">
                                        <div class="dropdown-item">
                                            <div class="field">
                                                <label class="label subtitle">Nombre</label>
                                                <input type="text" class="input" placeholder="Nombre de la lista" v-model="listName">
                                            </div>
                                            <a @click="createList" class="button is-primary">Agregar Lista</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                <div class="columns" style="display: inline-box">
                    <div class="column is-one-quarter" v-for="(list, index) in lists" :key="index">
                        <article class="message is-info" style="max-width: 360px" >
                                      <div class="message-header">
                                            <p>{{ list.name }}</p> <span>
                        <div class="dropdown is-right">
                            <div class="dropdown-trigger">
                                <span class="icon is-small">
                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </span>
                            </div>
                            <div class="dropdown-menu" id="dropdown-menu" role="menu">
                                <div class="dropdown-content">
                                    <a @click="deleteList(list.id)" class="dropdown-item">
                                        Borrar Lista
                                    </a>
                                </div>
                            </div>
                        </div>
                                            </span>
                                     </div>
                            <card :list="list"></card>
                        </article>
                    </div>

                </div>
        </div>
    </section>
</template>
<style scoped>

.columns  {
    overflow-x: auto;
}
.columns::-webkit-scrollbar {
    width: 1em;
}

.columns::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #0067a3;
    border-radius: 8px;
}

.columns::-webkit-scrollbar-thumb {
  background-color: lightskyblue;
  outline: 1px solid lightskyblue;
  border-radius: 8px;
}



.list-container {
    overflow-x: scroll;
    overflow-y: hidden;
    min-height: 28rem;
    white-space: nowrap;
}

.message a:not(.button):not(.tag) {
        text-decoration: none !important;
    color: black !important;
}

</style>

<script>
    import Card from './Card';

    export default {
        data(){
            return {
                boardId: '',
                boards: '',
                board: '',
                lists: '',
                listName: '',

            }
        },
        created(){
            let refreshedToken = this.$auth.token();
            Event.$emit('token', refreshedToken)

            this.boardId = this.$route.params.id;
            this.fetchBoardsData();
        },
        methods: {
            getLists(){
				this.boards.map((board)=>{
					if(board.id==this.boardId){
                        this.board=board;
						return this.lists=board.lists;
					}
				})
            },
            createList(){
                let listName = this.listName;

                axios.post('/boards/' + this.boardId + '/list', { name: listName }).then(response => {
                    console.log('creating list!');
                    console.log(response);
                    console.log('updating lists');
                    this.listName = '';
                    this.fetchBoardsData();
                })
            }
            ,
            fetchBoardsData(){
                console.log('fetching boards data');
                axios.get('/boards').then(response => {
                    this.boards = response.data.boards;
                    this.getLists();
                })
            },
            deleteList(listId) {
                   console.log('deleting list');
                    axios.delete('/boards/'+ this.boardId + '/list/ ' + listId ).then(response => {
                    this.fetchBoardsData();
                    console.log(response);
                })
            }
        },
        components: {
            Card
        },
        	beforeRouteUpdate (to,from,next){
			this.boardId=to.params.id;
			this.fetchBoardsData();
			next();
        },
        mounted(){
            Event.$on('createdTask', () => {
                console.log('created task! lets update lists.tasks!');
                this.fetchBoardsData();
            })
        }
    }
</script>
