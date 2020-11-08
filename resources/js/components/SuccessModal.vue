<template>
    <div class="white_theme success-message animated slideInDown">
        <div>
            <img width="20" height="20" src="/images/invitation-info.png" alt="">
        </div>
        <div style="width:90%;">
            <span v-if="title" class="success-title">{{ title }}</span>
            <span v-else class="success-title"> <slot name="success-title"></slot></span>
            <span class="success-info">
                <slot name="success-info"></slot>
            </span>
            <span class="manage-users-button" @click="goToEditPage()">Manage profile</span>
        </div>
        <div class="success-close" @click="$emit('close')">
            <img width="10" height="10" src="/images/close_small.png" alt="">
        </div>
    </div>
</template>

<script>
    export default {
        name: "SuccessModal",
        props: {
            title: ''
        },
        methods: {
            goToEditPage(){
                window.location.href = '/profile/edit';
            }
        }
    }
</script>

<style lang="scss" scoped>
    $bold : "Gotham Bold";
    $medium : "Gotham Medium";
    $book : "Gotham Book";
    $regular : "Gotham Regular";
    .success-message{
        position: fixed;
        top: 100px;
        right: 40px;
        width: 608px;
        height: 97px;
        z-index: 10;
        border-radius: 3px;
        padding: 16px 0px 0px 16px;
        background-color: #DEEBFF;
        display: flex;
        > div{
            &:first-child{
                margin-right: 16px;
            }
            i{
                font-size: 34.9px;
                color: #00fff9;
            }
        }
        .success-title{
            font-size: 16px;
            font-weight: 500;
            font-style: normal;
            font-stretch: normal;
            line-height: 20px;
            letter-spacing: normal;
            color: #00fff9;
            font-family: $medium;
        }
        .success-info{
            font-size: 14px;
            font-weight: normal;
            font-style: normal;
            font-stretch: normal;
            line-height: 20px;
            letter-spacing: normal;
            color: #ffffff;
            display: block;
            font-family: $book;
            margin-top: 8px;
            margin-bottom: 8px;
        }
        .success-close{
            font-size: 16px;
            font-weight: normal;
            font-style: normal;
            font-stretch: normal;
            letter-spacing: normal;
            color: #0052CC;
            display: block;
            font-family: $medium;
            cursor: pointer;
        }
    }
    .white_theme{
        background-color: #DEEBFF!important;
        border-radius: 3px;
        padding: 16px 0px 0px 16px;
        .success-title,
        .success-info,
        .success-close,
        > div i{
            color: #354053 !important;
        }
        > div {
            &:last-child {
                &:before {
                    background-color:  #E9E9E9!important;
                }
            }
        }
        .success-close {
            color: #ADADAD!important;
        }
    }
    .manage-users-button {
        color: #0052CC;
        font-family: $medium;
        font-style: normal;
        font-weight: 500;
        font-size: 14px;
        line-height: 20px;
        cursor: pointer;
    }
</style>