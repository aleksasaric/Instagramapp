<template>
    <transition name="fade">
        <div class="confirmationModal">
            <span class="confirmationModal-mask" @click="$emit('closeConfirmation')"></span>
            <div style="width:820px; height:600px; display:flex" class="confirmationModal-wrapper">
                <div class="left-panel">
                    <img :src="'/storage/' + post.path" alt="">
                </div>
                <div class="right-panel">
                        <div class="panel-heading">
                            <div class="panel-container">
                                <img v-if="profile.image" :src="'/storage/' + profile.image" alt="profile_image">
                                <img v-else src="/storage/no_img.png" alt="profile_image">
                                <p v-html="profile.username"></p>
                            </div>
                        </div>
                        <div v-html="post.description" class="panel-body">

                        </div>
                        <div class="panel-footer">

                        </div>
                </div>

                <!--<div class="confirmationModal-wrapper-text">-->
                    <!--<i @click="$emit('closeConfirmation')" class="fa fa-times"></i>-->
                <!--</div>-->
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        name: "PostModal",
        data(){
            return {
                files:'',
                title:'',
                description:''
            }
        },
        props:{
            post:{},
            profile:{}
        },
        methods:{
            showFilePicker(){
                this.$refs.file.click();
            },
            onChange(event){
                this.files = event.target.files[0]
            },
        }
    }
</script>

<style lang="scss" scoped>

    .left-panel{
        width: 55%;

        img{
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
    }

    .right-panel{
        width:45%;
        padding: 20px;
    }
    .panel-heading{
        height: 10%;
        display: flex;
        width: 100%;
        border-bottom: 1px solid #eee;
        /*padding:20px;*/
        .panel-container{
            display:flex;
            align-items: center;
            img{
                width:40px;
                height:40px;
                object-fit: cover;
                border-radius: 50%;
            }
            p{
                padding-left: 10px;
            }
        }
    }
    .panel-body{
        height:60%;
    }

    .panel-footer{
        height:30%
    }
    .submit-btn-add{
        background-color: #354053;
        color: white;
        padding: 13px 20px;
        border-radius: 2px;
        outline: none;
        border: 0;
        text-transform: uppercase;
        cursor: pointer;
    }
    .confirmationModal{
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        transition: opacity .3s ease;
        z-index: 20;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        &-wrapper{
            position: relative;
            z-index: 1;
            background: white;
            width: 350px;
            &-text{
                padding: 20px;
                color: #354053;
                i{
                    cursor: pointer;
                    position: absolute;
                    right: 20px;
                    top: 20px;
                }
                h2{
                    margin-top: 40px;
                    font-size: 14px;
                    text-align: center;
                    font-weight: normal;
                }
                span{
                    display: block;
                    text-align: center;
                    font-size: 12px;
                    font-weight: bold;
                    margin-bottom: 5px;
                }
            }
            &-bottom{
                padding: 0 40px 40px;
                margin-top: 30px;
                display: flex;
                align-items: center;
                justify-content: space-between;

                span{
                    width: 50%;
                    text-align: center;
                    padding: 15px;
                    font-size: 14px;
                    transition: .3s all ease-in-out;
                    text-transform: uppercase;
                    color: #a9bac6;
                    cursor: pointer;
                    &:hover{
                        color: #354053;
                    }
                    &:first-child{
                        margin-right: 20px;
                        background-color: #f9f9f9;
                        color: #354053;
                    }
                    &:last-child{
                        margin-left: 20px;
                        background-color: #354053;
                        color: white;
                    }
                }
            }
        }
        &-mask{
            background: rgba(0, 0, 0, 0.7);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }
        &-enter, &-leave {
            opacity: 0;
        }

        &-enter &-container,
        &-leave &-container {
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }
    }
</style>