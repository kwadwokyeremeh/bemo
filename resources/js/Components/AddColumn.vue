<template>
    <div class="column">
        <div class="card-input">
                <input
                    type="text"
                    placeholder="Enter column title"
                    class="card-input"
                    v-model="title"
                />
                <button class="add-column" @click="addColumn">&plus;</button>
        </div>
    </div>
</template>

<script>
import Card from "./Card";
import draggable from "vuedraggable";

export default {
    props: ['onAddNewColumn'],
    name: 'AddColumn',
    data: function () {
        return {
            title: ''
        }
    },
    methods: {
        addColumn: function() {
            if(this.title.length <1) {
                alert('Title Can\'t be empty.');
                return false;
            }
            this.onAddNewColumn(this.title)

            // Reset the title field.
            this.title = ''
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

.card-input {
    width: 90%;
    background-color: white;
    border-radius: 4px;
    font-size: 12px;
    outline: none;
    margin-top: 10px;
    margin-bottom: 10px;
    border: none;
}

.add-column {
    align-self: flex-end;
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

</style>
