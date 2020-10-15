<template>
    <header>
        <div class="col-md-12 d-md-flex p-2 justify-content-around">

            <div class="offset-2 col-6 text-center">
                <router-link :to="{name: 'main'}">
                    <img src="/images/logo.png" class="img-fluid" alt="logo" style="height: 40px">
                </router-link>
            </div>

            <div class="col-12 text-center p-3 p-md-0 col-md-3 text-md-right" v-if="getUser.auth">
                <p class="m-0 login" @click.stop="isShowMenu = !isShowMenu">
                    <i class="fa fa-bars"></i>
                    {{getUser.name}}
                </p>
                <Navigator v-if="isShowMenu"></Navigator>
            </div>

            <div class="col-2 offset-md-1 col-md-1" v-else>
                <small><router-link class="btn" :to="{name:'auth'}">Авторизация</router-link></small>
            </div>
        </div>
    </header>
</template>

<script>
    import { mapGetters } from 'vuex';
    import Navigator from "./Navigator";
    export default {

        name: "Header",

        components: {
            Navigator
        },

        data() {
            return {
                isShowMenu: false
            }
        },

        computed: {
            ...mapGetters(['getUser'])
        },

        mounted() {
            document.body.addEventListener('click', () => {
                this.isShowMenu = false;
            });
        }
    }
</script>

<style lang="scss" scoped>
    .login{
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;

        transition: .6s;
        cursor: pointer;
        &:hover {
            color: white;
        }
    }
</style>
