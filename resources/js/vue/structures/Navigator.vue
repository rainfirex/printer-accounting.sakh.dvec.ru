<template>
    <nav class="se-menu">
        <ul>
            <li class="se-item" v-for="nav in getNavs" v-if="nav.auth === getUser.auth || nav.auth === 'both'">

                <a  href="#"
                    v-if="nav.path === '/auth/logout'"
                    @click.prevent="logout"
                >{{nav.title}}</a>

                <router-link
                    v-else
                    :to="nav.path"
                >{{nav.title}}</router-link>
            </li>
        </ul>
    </nav>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    export default {
        name: "Navigator",
        computed: mapGetters(['getNavs', 'getUser']),

        methods: {
            ...mapActions(['logout'])
        }
    }
</script>

<style lang="scss" scoped>

    .se-menu{

        ul {
            position: absolute;
            left: 0;
            background: #ccc;
            list-style: none;
            margin: 5px 0 0;

            z-index: 2;
            width: 100%;
            box-shadow: 2px 5px 4px rgba(0,0,0,0.5);
        }

        .se-item{
            text-align: center;
            border-bottom: solid 1px darkgray;
            margin: 5px;
            background: #c6c6c6;

            &:last-child {
                border-bottom: none;
            }

            a{
                color: #444;
                transition: .6s;
                padding: 5px;
                display: block;
                text-decoration: none;

                &:hover{
                    color: white;
                }
            }
        }
    }

</style>
