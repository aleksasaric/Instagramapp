<template>
    <div :class="{'white_theme' : !darkTheme}" class="success-message animated slideInDown">
        <div>
            <i class="fas fa-check"></i>
        </div>
        <div>
            <span v-if="title" class="success-title">{{ title }}</span>
            <span v-else class="success-title"> <slot name="success-title"></slot></span>
            <span class="success-info">
                <slot name="success-info"></slot>
            </span>
        </div>
        <div class="success-close" @click="$emit('close')">
            <span>Close</span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SuccessAlert",
        props: {
            darkTheme: true,
            title: ''
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
        top: 40px;
        right: 40px;
        width: 700px;
        height: 90px;
        z-index: 10;
        border-radius: 2px;
        box-shadow: 1px 2px 4px 0 rgba(0, 0, 0, 0.12);
        border: solid 0.5px #133137;
        background-color: #0d1217;
        display: flex;
        align-items: center;
        > div{
            &:first-child{
                margin-right: 30px;
                margin-left: 30px;
            }
            i{
                font-size: 34.9px;
                color: #00fff9;
            }
            &:last-child{
                margin-left: auto;
                margin-right: 30px;
                padding-left: 30px;
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100%;
                cursor: pointer;
                width: 87px;
                font-size: 12px;
                font-weight: 500;
                font-style: normal;
                font-stretch: normal;
                line-height: normal;
                letter-spacing: normal;
                color: #ffffff;
                &:before{
                    position: absolute;
                    left: 0;
                    top: 0;
                    bottom: 0;
                    display: block;
                    width: 1px;
                    content: '';
                    background-color:  #133137;
                }
            }
        }
        .success-title{
            font-size: 14px;
            font-weight: 500;
            font-style: normal;
            font-stretch: normal;
            line-height: normal;
            letter-spacing: normal;
            color: #00fff9;
            font-family: $medium;
        }
        .success-info{
            font-size: 14px;
            font-weight: normal;
            font-style: normal;
            font-stretch: normal;
            line-height: 1.29;
            letter-spacing: normal;
            color: #ffffff;
            display: block;
            font-family: $book;
        }
        .success-close{
            font-size: 12px;
            font-weight: normal;
            font-style: normal;
            font-stretch: normal;
            letter-spacing: normal;
            color: #ffffff;
            display: block;
            font-family: $medium;
        }
    }
    .white_theme{
        background-color: white!important;
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
</style>