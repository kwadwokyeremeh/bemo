<template>
    <div class="column">
        <div class="column-title">
            <h2>{{ column.title }}</h2>
            <button class="delete-column" @click="onDeleteColumn">&times;</button>
        </div>

        <draggable :list="column.cards" :animation="200" ghost-class="ghost-card" group="cards" @end="onDragEnd">
            <Card
                :key="card.id"
                v-for="card in column.cards"
                :card="card"
                class="mt-3 cursor-move"
            ></Card>
        </draggable>


        <div class="card-input">
                <input
                    type="text"
                    placeholder="Enter new card"
                    class="card-input"
                    v-model="cardTitle"
                />
            <button class="add-card" @click="addCard">&plus;</button>
        </div>
    </div>
</template>

<script>
import Card from "./Card";
import draggable from "vuedraggable";

export default {
    props: [
        'column', 'onAddNewCard', 'deleteColumn', 'syncColumnItems'
    ],
    name: 'Column',
    data: function () {
        return {
            cardTitle: ''
        }
    },
    components: {
        Card,
        draggable
    },
    methods: {
        addCard() {
            if (this.cardTitle.length < 1) {
                alert('Please enter some description.');
                return false;
            }
            this.onAddNewCard(this.column.id, this.cardTitle)

            // Reset the cardTitle field
            this.cardTitle = '';
        },
        onDeleteColumn() {
            let confirmation = confirm("Are you sure, You want to delete this column?");
            if (!confirmation) {
                return false
            }

            this.deleteColumn(this.column.id)
        },
        onDragEnd() {
            this.syncColumnItems();
            console.log('Drag Ended.');
        }
    }
};
</script>

<style scoped lang="scss">
.column {
    margin-right: 20px;
    background-color: #dbe0e7;
    min-width: 360px;
    max-height: 95vh;
    border-radius: 4px;
    overflow-y: scroll;
    padding: 0 10px;
    font-weight: 500;
}

.column-title {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    font-size: 14px;
    margin: 10px 40px;
    text-align: center;
}

.delete-column {
    padding: 8px 12px;
    background-color: #e50847;
    color: white;
    outline: none;
    border: none;
    border-radius: 4px;
    font-weight: 700;
    cursor: pointer;
}

.card-input {
    width: 90%;
    background-color: white;
    border-radius: 4px;
    font-size: 12px;
    padding: 2px 2px;
    outline: none;
    margin-top: 10px;
    margin-bottom: 10px;
    border: none;
}

.add-card {
    margin: auto;
    padding: 8px 12px;
    background-color: #358edd;
    color: white;
    outline: none;
    border: none;
    border-radius: 4px;
    font-weight: 700;
    cursor: pointer;
}
.ghost-card {
    opacity: 0.5;
    background: #F7FAFC;
    border: 1px solid #4299e1;
}
</style>
