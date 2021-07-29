<template>
    <div id="app">
        <header>
            <h3 class="heading">Bemo Kanban Board</h3>


        </header>
        <section>
            <Column
                :key="column.id"
                v-for="column in columns"
                :column="column"
                :onAddNewCard="onAddNewCard"
                :deleteColumn="deleteColumn"
                :syncColumnItems="syncColumnItems"
            />
            <AddColumn :onAddNewColumn="onAddNewColumn"/>
        </section>
        <button>
            <a :href="downloadUrl()">Export Database</a>
        </button>
    </div>
</template>

<script>
import Vuex from '@/Vuex';
import Column from "@/Components/Column";
import AddColumn from "@/Components/AddColumn";

export default {
    name: 'app',
    components: {
        Column,
        AddColumn
    },
    data: function () {
        return {
            columns: {}
        }
    },
    methods: {
        async onAddNewColumn(title) {
            console.log('new column added', 'Title:', title);
            try {
                let response = await axios.post('/api/columns', {
                    title: title,
                    order: this.columns.length + 1
                })

                // Fetch the latest state again.
                this.getAppState();
            } catch (error) {
                alert('Error Adding Columns, Please try again.');
            }
        },
        async onAddNewCard(columnId, cardTitle) {
            // Get column with this columnId
            let column = this.columns.find(column => column.id == columnId);
            console.log('column', column);
            try {
                let response = await axios.post('/api/cards', {
                    title: cardTitle,
                    column_id: columnId,
                    order: column.cards.length + 1
                })

                // Fetch the latest state again.
                this.getAppState();
            } catch (error) {
                console.log(error);
                alert('Error Adding Card, Please try again.');
            }
        },
        async deleteColumn(columnId) {
            try{
                let response = await axios.delete('/api/columns', {
                    data: {
                        column_id: columnId,
                    }
                });

                // Fetch the latest state again.
                this.getAppState();
            } catch (error) {
                console.log('error', error);
                alert('Something went wrong deleting the column.');
            }
        },
        getAppState(){
            axios
                .get('/api/columns')
                .then(response => (this.columns = response.data))
                .catch((error) => {
                    alert('error fetching columns')
                });
        },
        async syncColumnItems(){
            try {
                let response = await axios.patch('/api/columns/order', {
                    columns: this.columns
                });
                // Fetch Latest App State
                this.getAppState();
            } catch (error) {
                console.log(error);
                alert('Error Syncing, Please try again.');
            }
        },
        downloadUrl(row){
            return window.location.origin + '/api/download-db-dump';
        },
    },
    mounted() {
        // Call Api to get the columns and card in it.
        this.getAppState();

        // Listen for app state update.
        Vuex.$on('UPDATE_APP_STATE', () => {
            this.getAppState();
        })
    }
};
</script>

<style scoped lang="scss">
header {
    text-align: center;
    background-color: #25d7d1;
    overflow: hidden;
    width: 100%;
    height: 28px;
}

.heading {
    display: inline-block;
    text-align: center;
    font-weight: 400;
    color: white;
}

section {
    height: calc(100vh - 48px);
    white-space: nowrap;
    overflow-x: auto;
    overflow-y: hidden;
    background-color: #9451e0;
    padding: 10px;
    display: flex;
    flex-direction: row;
    align-items: flex-start;
}
button {
    z-index: 10;
    display: flex;
    flex-direction: row-reverse;
    float: bottom;
    align-items: flex-end;
}
</style>
