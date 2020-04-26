<template>
    <div class="container">
        <div class="edit-wrapper">
            <div class="edit-menu">
                <div class="edit-menu__items">
                    <div :class="[this.activeTab === 1 ? 'active' : '', 'edit-menu__item']"  @click="activateTab(1)">Edit Profile</div>
                    <div :class="[this.activeTab === 2 ? 'active' : '', 'edit-menu__item']" @click="activateTab(2)">Privacy and Security</div>
                    <div :class="[this.activeTab === 3 ? 'active' : '', 'edit-menu__item']" @click="activateTab(3)">Change Password</div>
                </div>
            </div>
            <div class="edit-inputs">
                <div v-if="activeTab===1">

                    <div class="row-input-header">
                        <div class="img-container">
                            <img src="/storage/images/aleksa.jpg" alt="">
                        </div>
                        <div class="change-picture">
                            <p class="change-picture-name">aleksasaric21</p>
                            <p class="change-picture-profile">Change Profile Photo</p>
                        </div>
                    </div>

                    <div class="row-input">
                        <label for="row1">Name</label>
                        <input id="row1" type="text">
                    </div>
                    <div class="row-input">
                        <label for="row2">Username</label>
                        <input id="row2" type="text">
                    </div>
                    <div class="row-input">
                        <label for="row3">Website</label>
                        <input id="row3" type="text">
                    </div>
                    <div class="row-input">
                        <label for="row4">Bio</label>
                        <input id="row4" type="text">
                    </div>
                    <div class="row-input">
                        <label for="row5">Email</label>
                        <input id="row5" type="email">
                    </div>
                    <div class="row-input">
                        <label for="row6">Gender</label>
                        <input id="row6" type="text">
                    </div>
                    <div class="row-input">
                       <button>Submit</button>
                    </div>
                    <!--</div>-->
                </div>

                <div class="tab-2-active" v-if="activeTab===2">
                    <div class="privacy">
                        <h2>Account Privacy</h2>
                        <input id="checkbox-1" type="checkbox">
                        <label for="checkbox-1">Private Account</label>
                        <p>When your account is private, only people you approve can see your photos and videos on Instagram. Your existing followers won't be affected.
                        </p>
                    </div>

                </div>
                <div v-if="activeTab===3">
                    <div class="row-input-header">
                        <div class="img-container">
                            <img src="/storage/images/aleksa.jpg" alt="">
                        </div>
                        <div style="padding-right:50px; line-height:40px" class="change-picture">
                            <p class="change-picture-name">aleksasaric21</p>
                        </div>
                    </div>
                    <div class="row-input">
                        <label for="password">Old Password</label>
                        <input id="password" type="password">
                    </div>
                    <div class="row-input">
                        <label for="password-new">New Password</label>
                        <input id="password-new" type="password">
                    </div>
                    <div class="row-input">
                        <label for="password-conform">Conform New Password</label>
                        <input id="password-conform" type="password">
                    </div>
                    <div class="row-input">
                        <button>Change Password</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "EditProfile.vue",
        data(){
            return {
                activeTab: 1,
            }
        },
        methods:{
            activateTab(tabNumber){
                this.activeTab = tabNumber;
            }
        }
    }
</script>

<style scoped>
    .edit-wrapper{
        height: 80vh;
        width: 100%;
        background: whitesmoke;
        display: flex;
        justify-content:center;
    }
    .edit-menu{
        width: 20%;
        background: #b0d4f1;
    }
    .edit-menu__item{
        width: 100%;
        padding: 10px 20px 10px 20px;
        cursor: pointer;
        border-left: #b0d4f1 solid 2px;
    }
    .edit-menu__item:hover{
        background: rgba(38,38,38,0.1);
        border-left: gray 2px solid;
        /*border-left: gray solid 2px;*/
    }
    .edit-inputs{
        background: lightblue;
        width: 40%;
        display: flex;
        justify-content: center;
    }
    .input-holder{

    }
    .row-input-header{
        display: flex;
        justify-content: flex-end;
        margin: 10px 0 10px 0;
    }
    .row-input-header img{
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .row-input{
        width: 100%;
        display: flex;
        justify-content: flex-end;
        margin: 10px 0 10px 0;
    }
    .row-input label{
       padding-right: 20px;
    }
    .row-input input{

    }
    .change-picture{
        padding-right:20px
    }
    .change-picture-name{
        font-size: 1.2em;
        font-weight: bold;
    }
    .change-picture-profile{
        color: #1d68a7;
        cursor: pointer;
    }
    .active{
        border-left: black 2px solid;
    }
    .img-container{
        padding-right: 20px;
    }
    .tab-2-active{
        padding: 40px;
    }

</style>