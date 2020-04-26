<template>
    <div class="container">
        <div class="profile">
            <div class="profile__header">
                <div class="profile__picture">
                    <img src="/storage/images/aleksa.jpg" alt="profie picture">
                </div>
                <div class="profile__information">
                    <div class="profile"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
<style scoped>
    .profile__picture{
        width: 400px;
    }
</style>
