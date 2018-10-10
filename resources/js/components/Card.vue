<template>
<div>
    <div class="message-body">
        <draggable v-model="cards" :options="{ group: 'cards'}" style="min-height: 15px" :listId="list.id" @add="changeCard">
            <div class="board-item" v-for="card in cards" :key="card.id" :cardId="card.id">
                <div  class="board-item-content">
                    <span>{{ card.name }}</span>
                    <span style="float: right">
                    <div class="dropdown is-right">
                        <div class="dropdown-trigger">
                            <span class="icon is-small" aria-haspopup="true" aria-controls="dropdown-menu">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </span>
                        </div>
                        <div class="dropdown-menu" id="dropdown-menu" role="menu">
                            <div class="dropdown-content">
                            <a @click="deleteTask(card.id)" class="dropdown-item">
                                Borrar
                            </a>
                            </div>
                        </div>
                    </div>
                    </span>
                </div>
            </div>
            <div  class="board-item" style="padding: 12px;">
                <input v-focus @keyup.esc="cancelTask" @keyup.enter="createTask" tabindex="0" type="text" class="input" v-if="createTaskFlag" v-model="taskName" placeholder="Nombre de la Tarea">
            </div>
            <div class="board-item" style="padding: 4vh">
                <a @click="createTaskFlag=!createTaskFlag" class="button is-warning" style="width: 100%">Crear Tarea</a>
            </div>

        </draggable>
    </div>
</div>
</template>
<style scoped>



a.dropdown-item {
    color: black !important;
}

.dropdown a {
    text-decoration: none !important;
}

.message.is-info .message-body {
    border-color: transparent;
}


   .board-item {
  margin: 5px 0;
  /* will-change: transform; */
  /* display: contents; */
}

.board-item-content {
  height:50px;
  word-wrap: normal;
  position: relative;
  padding: 20px;
  background: #fff;
  border-radius: 4px;
  font-size: 17px;
  text-align: left;
  cursor: pointer;
  -webkit-box-shadow: 0px 1px 3px 0 rgba(0,0,0,0.2);
  box-shadow: 0px 1px 3px 0 rgba(0,0,0,0.2);
  margin: 12px;
}
.message-body {
    padding-left: 0em;
    padding-right: 0em;
    padding-top: 0.5em;
}

.board-item-content:hover i.fa {
    display: block !important;

}

span i.fa:hover {
    background-color: lightgray;
    padding: 2px;
    border-radius: 2px;
}

span i.fa {
    cursor: pointer;
    display: none;
    position: relative;
    top: -1vh;
}

 .board-item {
    position: relative;
}

</style>

<script>
import loadBoardMixin from '../mixins/boardDataLoadMixin';
import draggable from 'vuedraggable';


    export default {
        data(){
            return {
                cards: '',
                boardId: this.$route.params.id,
                listId: this.list.id,
                boards: [],
                createTaskFlag: false,
                taskName : '',
                listId : this.list.id,
                editTask : false,
            }
        },
        props: [
            'list'
        ],
        mixins: [
            loadBoardMixin
        ],
        created() {
            this.cards = this.list.cards
        },
        methods: {
             createTask() {
                 console.log('creating task');
                 // ARREGLAR DE QUE LA DESCRIPCION SE PUEDA QUEDAR NULL
                 axios.post('/boards/' + this.boardId + '/list/' +  this.listId + '/card', { name: this.taskName, description: 'Escribe una descripción' }).then(response => {
                     console.log(response);
                 this.createTaskFlag = false;
                 this.cards.push(response.data.card);
                 this.taskName = '';
                 })
            },
            updateTask(cardId, listId){
                ///boards/{board}/list/{list}/card/{card}
                axios.put('/card/'+cardId, { lists_id: listId})
                    .then(response => {
                        console.log(response);
                    });
            },
            deleteTask(cardId){
                axios.delete('/card/' + cardId).then(response => {
                    console.log(response);
                    let card = this.cards.find(function (obj) { return obj.id === response.data.card.id })
                    let index = this.cards.indexOf(card);
                    this.cards.splice(index, 1);
                });
            },
            changeCard(event) {
                console.log('change detected on task');
                console.log(event);
                let fromListId = event.from.getAttribute('listId');
                let cardId = event.item.getAttribute('cardId');
                let toListId = event.to.getAttribute('listId');
                console.log(fromListId);
                console.log(cardId);
                console.log(toListId);

                this.updateTask(cardId, toListId);

            },
            testMethod() {
                this.createTaskFlag = false;
            },
            cancelTask(){
                this.taskName = '';
                this.createTaskFlag = false;
            }
        },
        components: {
            draggable
        },
    }
</script>
