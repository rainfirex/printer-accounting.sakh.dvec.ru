<template>
    <div class="wrapper">
        <Header></Header>
        <Body></Body>
    </div>
</template>

<script>
    import Header from "./structures/Header";
    import Body from "./structures/Body";
    import {mapMutations, mapGetters} from 'vuex';
    export default {
        name: "App",
        components: {
            Header,
            Body,
        },

        computed: {
            ...mapGetters(['getUser'])
        },

        methods: {
            ...mapMutations(['initUser'])
        },

        created() {
            //Пользователь
            this.initUser();
        }
    }
</script>
