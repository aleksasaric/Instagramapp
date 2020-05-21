<template>
    <div  class="darkTheme error-message animated slideInDown">
        <div>
            <i class="fa fa-times"></i>
        </div>
        <div>
            <span class="error-title">{{this.message}}</span>
            <span class="error-info">
                <slot name="error-info"></slot>
            </span>
        </div>
        <div class="error-close" @click="$emit('alertClose')">
            <span>Close</span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErrorAlert",
        props: {
            message:'',
        },
        data(){
            return {
                darkTheme: true
            }
        },
        mounted() {
            let $this = this;
            setTimeout(() => {
                $this.$emit('alertClose');
            },3000);
        }
    }
</script>

<style lang="scss" scoped>
    $bold : "Gotham Bold";
    $medium : "Gotham Medium";
    $book : "Gotham Book";
    $regular : "Gotham Regular";
    .error-message{
        position: fixed;
        top: 40px;
        right: 40px;
        width: 700px;
        height: 90px;
        z-index: 10;
        border-radius: 2px;
        box-shadow: 1px 2px 4px 0 rgba(0, 0, 0, 0.12);
        border: solid 0.5px #5f021f;
        /*background-color: #0d1217;*/
        background-color: #f8d7da;
        display: flex;
        align-items: center;
        @media screen and (max-width:1919px){
            width: 500px;
        }
        > div{
            &:first-child{
                margin-right: 30px;
                margin-left: 30px;
            }
            i{
                font-size: 34.9px;
                color: #5f021f;
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
                    background-color:  #5f021f;
                }
            }
        }
        .error-title{
            font-size: 14px;
            font-weight: 500;
            font-style: normal;
            font-stretch: normal;
            line-height: normal;
            letter-spacing: normal;
            color: #5f021f;
            font-family: $medium;
        }
        .error-info{
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
        .error-close{
            font-size: 14px;
            font-weight: normal;
            font-style: normal;
            font-stretch: normal;
            letter-spacing: normal;
            color: #ffffff;
            display: block;
            font-family: $medium;
        }
        &.white_theme{
            background-color: white;
            .error-info,
            .error-close,
            > div i{
                color: #354053 !important;
            }
        }
    }
</style>