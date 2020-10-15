<template>
    <div class="d-flex flex-wrap justify-content-center">
        <div class="modal-content se-form mt-5">

            <div class="modal-header">
                <h5 class="modal-title">Авторизация</h5>
                <router-link class="close" :to="{name: 'main'}">
                    <span>×</span>
                </router-link>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control text-center" placeholder="Логин"
                           ref="inputLogin"
                           v-model="user.login"
                           :class="{'error-input': $v.user.login.$error}"
                           @change="$v.user.login.$touch()"
                    >
                    <small class="form-text text-muted" :class="{'is-error': $v.user.login.$error}">Имя доменного пользователя.
                        <span v-if="!$v.user.login.required" class="error-text"
                              :class="{'error-show': !$v.user.login.required}">Поле пустое</span>
                        <span v-if="!$v.user.login.minLength" class="error-text"
                              :class="{'error-show': !$v.user.login.minLength}">Минимум 4 символа</span>
                    </small>
                </div>

                <div class="form-group">
                    <input type="password" class="form-control text-center" placeholder="Пароль"
                           v-model="user.password"
                           :class="{'error-input': $v.user.password.$error}"
                           @change="$v.user.password.$touch()"
                    >
                    <small class="form-text text-muted" :class="{'is-error': $v.user.login.$error}">Пароль доменного пользователя.
                        <span v-if="!$v.user.password.required" class="error-text"
                              :class="{'error-show': !$v.user.password.required}">Поле пустое</span>
                        <span v-if="!$v.user.password.minLength" class="error-text"
                              :class="{'error-show': !$v.user.password.minLength}">Минимум 4 символа</span>
                    </small>
                </div>
            </div>

            <div class="pb-4 text-center">
                <button class="btn" @click="auth">Войти</button>
            </div>
        </div>

        <Messenger :Messenger="Messenger"></Messenger>
    </div>
</template>

<script>
    import Messenger from "../structures/components/Messenger";
    import { mapMutations, mapGetters, mapActions } from 'vuex';
    import { required, minLength, between } from 'vuelidate/lib/validators';

    export default {
        name: "AuthPage",

        components: {
            Messenger
        },

        data() {
            return {

                user: {
                    login: '',
                    password: ''
                },

                Messenger: {
                    text: '',
                    status: ''
                }

            }
        },

        computed: {
            ...mapGetters(['getUser'])
        },

        validations: {

            user: {

                login: {
                    required,
                    minLength: minLength(4)
                },

                password: {
                    required,
                    minLength: minLength(4)
                }

            }
        },

        methods: {

            ...mapMutations(['initUser']),

            ...mapActions(['login']),

            auth() {
                this.$v.user.$touch();

                if (!this.$v.user.$invalid) {
                    this.login(this.user).then(response => {
                        if(!response.data.success) {
                            this.Messenger = {text: response.data.message, status: 'error'};
                        }
                    }).catch(e => {
                        console.dir(e);
                        this.Messenger = {text: e.response.data.message, status: 'error'};
                    });
                } else {
                    this.Messenger = {text: 'Заполните поля ввода.', status: 'error'};
                }
            },

            listenerKeyDown(e) {
                if(e.code === 'Enter' && e.key === 'Enter') {
                    this.auth();
                }

                if (e.code === 'Escape' && e.key === 'Escape') {
                    if (this.user.login.length > 0 || this.user.password.length > 0) {
                        if(confirm('Сбросить поля ввода?')) {
                            this.user.login = '';
                            this.user.password = '';
                            this.$v.user.$reset();
                            this.Messenger = {};
                        }
                    }
                }
            }
        },

        mounted() {

            if (this.getUser.auth) {
                this.$router.push('/');
            }

            document.body.addEventListener('keydown', this.listenerKeyDown);

            this.$refs.inputLogin.focus();
        },

        beforeDestroy() {
            document.body.removeEventListener('keydown', this.listenerKeyDown);
        }

    }
</script>

<style lang="scss" scoped>
    .se-form {
        max-width: 750px;
        background: #dedede;
        width: 500px;
    }
</style>
