<template>
    <div class="d-flex flex-wrap justify-content-center">
        <div class="bg p-4 m-4">
            <h1 class="text-center">
                <b>404!</b>
            </h1>
            <p>Ошибка 404. Нет такой страницы</p>
            <p>Вы могли неправильно ввести адрес.</p>
            <p>Или страница была удалена.</p>
            <p>Собственно, смотреть здесь не на что ...</p>
            <p>Нажмите на ссылки ниже, чтобы перейти на главную, спасибо!</p>
            <div class="text-center">
                <router-link class="btn btn-dark" to="/">На главную</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "404"
    }
</script>

<style scoped>
    .bg {
        background: #eee;
        min-width: 650px;
        box-shadow: 1px 2px 10px 0.2rem rgba(0, 0, 0, 0.25);
    }
</style>
