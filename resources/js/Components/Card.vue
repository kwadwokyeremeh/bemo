<template>
    <div class="card" @click="openModal">
        <div>{{ card.title }}</div>
        <modal :focusTrap="true" :clickToClose="true" :name="''+card.id">
            <div class="modal-body">
                <div class="input-wrapper">
                    <label>
                        <input type="text" name="title" class="title-input" v-model="title">
                    </label>
                </div>

                <div class="input-wrapper">
                    <label>
                        <textarea cols="5" v-model="description">
                        </textarea>
                    </label>
                </div>

                <div class="input-wrapper">
                    <button @click="saveCard">
                        Save
                    </button>

                    <button @click="onClose">
                        Close
                    </button>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
import Vuex from '@/Vuex'
export default {
    name: 'Card',
    props: ['card', 'getAppState'],
    data: function () {
        return {
            title: this.card.title,
            description: this.card.description
        }
    },
    methods: {
        openModal() {
            this.$modal.show('' + this.card.id)
        },
        onClose() {
            this.$modal.hide('' + this.card.id)
        },
        async saveCard() {
            try {
                // Close the card
                this.onClose()

                let response = await axios.patch('/api/cards', {
                    card_id: this.card.id,
                    title: this.title,
                    description: this.description
                });
                // Fetch Latest App State
                Vuex.$emit('UPDATE_APP_STATE')
            } catch (error) {
                alert('Error updating card, Please try again.');
            }
        }
    }
};
</script>

<style scoped lang="scss">
.card {
    font-size: 12px;
    background-color: #65c44c;
    color: white;
    margin: 10px 0;
    padding: 15px 10px;
    display: flex;
    border-radius: 4px;
    align-items: center;
    justify-content: space-between;
    cursor: move;
}

.modal-body {
    background-color: #dbe0e7;
    min-height: 100%;
}

.input-wrapper {
    padding-top: 5px;
    padding-left: 5px;
}

textarea {
    display: block;
    width: 80%;
}

.title-input {
    display: block;
    width: 80%;
    background-color: white;
    border-radius: 4px;
    font-size: 12px;
    padding: 10px 3px;
    outline: none;
    margin-bottom: 25px;
    border: none;
}
</style>
