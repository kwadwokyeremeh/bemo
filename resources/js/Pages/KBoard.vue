<template>
    <div className="board">
        <div className=" flex flex-row items-start m-4 mb-0">

        </div>
    </div>
</template>

<script>

export default {
    name: 'Board',
    data() {
        return {
            columns: {}
        };
    },
    created() {
        const handler = (event) => {
            if (event.key === 'Escape' && this.isTaskOpen) {
                this.closeTaskModal();
            }
        };
        document.addEventListener('keydown', handler);
        this.$once('hook:beforeDestroy', () => {
            document.removeEventListener('keydown', handler);
        });
    },
    methods: {},
};
</script>

<style lang="scss" scoped>
.board {
    background-color: rgb(0, 121, 191);
    min-height: 100vh;
    overflow-y: hidden;
    overflow-x: auto;
}
</style>
