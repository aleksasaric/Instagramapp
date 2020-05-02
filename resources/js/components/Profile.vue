<template>
    <div class="container">
        <div class="profile">
            <div class="profile__header">
                <div class="profile__picture">
                    <img src="/storage/images/aleksa.jpg" alt="profie picture">
                </div>
                <div class="profile__information">
                    <div class="profile__information__header">
                        <p>{{profile.username}}</p>
                        <button><a href="/profile/edit">Edit Profile</a></button>
                    </div>
                    <div class="profile__information__body">
                        <ul>
                            <li><span class="bold">16</span> posts</li>
                            <li><span class="bold">330</span> followers</li>
                            <li><span class="bold">325</span> following</li>
                        </ul>
                    </div>
                    <div class="profile__information__footer">
                        <p><span class="bold">{{profile.name}}</span></p>
                        <p>{{profile.bio}}</p>
                    </div>

                </div>
            </div>

            <div class="profile__middle"></div>
            <div class="profile__pictures">
                <div @click="openPost(1)" class="profile__pictures__container">
                    <img src="/storage/images/aleksa.jpg" alt="">
                </div>
                <div class="profile__pictures__container">
                    <img src="/storage/images/aleksa.jpg" alt="">
                </div>
                <div class="profile__pictures__container">
                    <img src="/storage/images/aleksa.jpg" alt="">
                </div>
                <div class="profile__pictures__container">
                    <img src="/storage/images/aleksa.jpg" alt="">
                </div>
            </div>

        </div>
        <transition name="fade" mode="out-in">
            <post-modal v-if="showModal" :post="this.selectedPost"  @closeConfirmation="showModal = false">
                <!--@deleteItem="deleteCourse"-->
            </post-modal>
        </transition>
    </div>
</template>

<script>
    export default {
        name: "Profile",
        props:{
            prof: null,
        },
        data(){
            return {
                profile: this.prof,
                showModal: false,
                selectedPost: null,
            }
        },
        methods:{
            openPost(post){
                this.selectedPost = post;
                this.showModal = true;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .profile{

        &__header{
            display: flex;
            position: relative;
         }
        &__header::after{
            content:"";
            position: absolute;
            width: 100%;
            height: 1px;
            top: 20px;
        }
        &__picture{
            width: 300px;
            height: 300px;
        }
        &__picture img{
            width: 100%;
            height: 100%;
            object-fit: cover;
            /*object-position: 50% 50%;*/
            border-radius: 50%;
        }
        &__information{
            margin: 20px;
            width: 40%;
            &__header{
                display: flex;
                justify-content: space-between;
                flex-wrap: wrap;
                p{
                    margin-bottom:unset;
                    font-size: 1.5em;
                    color:black;
                    font-weight: bold;
                }
                button{
                    border: 0;
                    padding: 7px 14px;
                    border: 1px solid gray;
                    border-radius: 10px;
                    outline: none;
                }
                button:active{
                    background: gray;
                    color: white;

                }
            }
            &__body{
                margin: 20px 0 20px 0;
                ul{
                    display: flex;
                    justify-content: space-between;
                }
            }
            &__footer{
               p{
                   margin-bottom:unset;
               }
            }
        }


        &__middle{
            width: 100%;
            height: 1px;
            background: gray;
            margin: 30px 0 30px 0;
        }

        &__pictures{
            margin-left: -10px;
            margin-right: -10px;

            &__container{
                margin:10px;
                width: calc(100%/3 - #{23px});
                display: inline-block;
                cursor: pointer;
            }
            &__container img{
                width: 100%;


            }
        }



    }

    /*.profile__header{*/
       /**/
    /*}*/
    /*.profile__picture{*/
        /*width: 300px;*/
        /*height: 300px;*/
    /*}*/
    /*.profile__picture img{*/
        /*width: 100%;*/
        /*height: 100%;*/
        /*object-fit: cover;*/
        /*!*object-position: 50% 50%;*!*/
        /*border-radius: 50%;*/
    /*}*/
    /*.profile__information{*/

    /*}*/
</style>